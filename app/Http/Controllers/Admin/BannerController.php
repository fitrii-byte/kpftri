<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        return view('admin.banner', ['banners' => Banner::latest('id')->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
            'link' => ['nullable', 'url', 'max:255'],
            'gambar_file' => ['required', 'image', 'max:4096'],
        ]);

        $file = $request->file('gambar_file');
        $name = 'banner-'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads/banner'), $name);

        Banner::create([
            'judul' => $data['judul'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'link' => $data['link'] ?? null,
            'gambar' => 'uploads/banner/'.$name,
            'aktif' => true,
        ]);

        return back()->with('status', 'Banner berhasil diunggah.');
    }

    public function toggle(Banner $banner)
    {
        $banner->update(['aktif' => ! $banner->aktif]);

        return back()->with('status', 'Status banner diperbarui.');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->gambar && file_exists(public_path($banner->gambar))) {
            @unlink(public_path($banner->gambar));
        }
        $banner->delete();

        return back()->with('status', 'Banner berhasil dihapus.');
    }
}
