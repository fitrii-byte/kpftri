<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aset;
use Illuminate\Http\Request;

class BookletController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q'));

        $asets = Aset::with('debitur')
            ->where('booklet_ready', true)
            ->when($q !== '', fn ($query) => $query->where(function ($w) use ($q) {
                $w->where('nama', 'like', "%$q%")
                    ->orWhere('kota', 'like', "%$q%")
                    ->orWhereHas('debitur', fn ($d) => $d->where('nama', 'like', "%$q%")
                        ->orWhere('no_loan', 'like', "%$q%")
                        ->orWhere('cabang_pengelola', 'like', "%$q%"));
            }))
            ->orderBy('kode')
            ->paginate(10)
            ->withQueryString();

        return view('admin.booklet', compact('asets', 'q'));
    }

    /** Halaman booklet siap cetak (gunakan Ctrl+P > Save as PDF). */
    public function show(Aset $aset)
    {
        return view('admin.booklet-cetak', ['aset' => $aset->load('debitur')]);
    }
}
