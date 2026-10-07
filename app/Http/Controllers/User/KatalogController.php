<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Aset;
use App\Models\Banner;
use App\Models\Like;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public const KATEGORI = ['Tanah', 'Rumah', 'Ruko', 'Gudang', 'Apartemen', 'Pabrik'];

    public function landing()
    {
        return view('user.landing', [
            'banners' => Banner::where('aktif', true)->latest('id')->get(),
            'terbaru' => Aset::latest('id')->take(6)->get(),
            'kategori' => self::KATEGORI,
        ]);
    }

    public function kalkulator(Request $request)
    {
        return view('user.kalkulator', [
            'hargaAwal' => (float) $request->get('harga', 0),
        ]);
    }

    public function index(Request $request)
    {
        $q = trim((string) $request->get('q'));
        $jenis = $request->get('jenis');
        $kota = $request->get('kota');
        $hargaMax = (float) $request->get('harga_max', 0);

        $asets = Aset::query()
            ->when($q !== '', fn ($query) => $query->where(function ($w) use ($q) {
                $w->where('nama', 'like', "%$q%")
                    ->orWhere('alamat', 'like', "%$q%")
                    ->orWhere('kota', 'like', "%$q%")
                    ->orWhere('jenis', 'like', "%$q%");
            }))
            ->when($jenis, fn ($query) => $query->where('jenis', $jenis))
            ->when($kota, fn ($query) => $query->where('kota', $kota))
            ->when($hargaMax > 0, fn ($query) => $query->where('harga_estimasi', '<=', $hargaMax))
            ->latest('id')
            ->paginate(9)
            ->withQueryString();

        return view('user.katalog', [
            'asets' => $asets,
            'q' => $q,
            'jenis' => $jenis,
            'kota' => $kota,
            'hargaMax' => $hargaMax,
            'kategori' => self::KATEGORI,
            'kotaList' => Aset::select('kota')->distinct()->orderBy('kota')->pluck('kota'),
            'banners' => Banner::where('aktif', true)->latest('id')->get(),
            'likedIds' => $this->likedIds($request),
        ]);
    }

    public function show(Request $request, Aset $aset)
    {
        return view('user.detail', [
            'aset' => $aset->load('debitur'),
            'liked' => in_array($aset->id, $this->likedIds($request), true),
            'serupa' => Aset::where('jenis', $aset->jenis)->where('id', '!=', $aset->id)->take(3)->get(),
        ]);
    }

    public function favorit(Request $request)
    {
        $ids = $this->likedIds($request);

        return view('user.favorit', [
            'asets' => Aset::whereIn('id', $ids)->get(),
            'likedIds' => $ids,
        ]);
    }

    public function toggleLike(Request $request, Aset $aset)
    {
        $like = Like::where('user_id', $request->user()->id)->where('aset_id', $aset->id)->first();

        if ($like) {
            $like->delete();
            $aset->decrement('likes_count');
            $liked = false;
        } else {
            Like::create(['user_id' => $request->user()->id, 'aset_id' => $aset->id]);
            $aset->increment('likes_count');
            $liked = true;
        }

        if ($request->wantsJson()) {
            return response()->json(['liked' => $liked, 'likes' => $aset->fresh()->likes_count]);
        }

        return back();
    }

    protected function likedIds(Request $request): array
    {
        if (! $request->user()) {
            return [];
        }

        return Like::where('user_id', $request->user()->id)->pluck('aset_id')->all();
    }
}