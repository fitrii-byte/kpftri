<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aset;
use App\Models\Debitur;
use Illuminate\Http\Request;

class AsetAdminController extends Controller
{
    public const JENIS = ['Tanah', 'Rumah', 'Ruko', 'Gudang', 'Apartemen', 'Pabrik'];

    public function create()
    {
        return view('admin.aset-form', [
            'aset' => new Aset([
                'kode' => Aset::generateKode(),
                'sertifikat' => 'SHM',
                'booklet_ready' => true,
            ]),
            'debiturs' => Debitur::orderBy('nama')->get(),
            'jenisList' => self::JENIS,
        ]);
    }

    public function edit(Aset $aset)
    {
        return view('admin.aset-form', [
            'aset' => $aset,
            'debiturs' => Debitur::orderBy('nama')->get(),
            'jenisList' => self::JENIS,
        ]);
    }

    public function store(Request $request)
    {
        $aset = Aset::create($this->validated($request));

        return redirect()->route('admin.dashboard')->with('status', "Aset {$aset->kode} berhasil ditambahkan.");
    }

    public function update(Request $request, Aset $aset)
    {
        $aset->update($this->validated($request, $aset));

        return redirect()->route('admin.dashboard')->with('status', "Aset {$aset->kode} berhasil diperbarui.");
    }

    public function destroy(Aset $aset)
    {
        $aset->delete();

        return back()->with('status', 'Aset berhasil dihapus.');
    }

    protected function validated(Request $request, ?Aset $aset = null): array
    {
        $data = $request->validate([
            'kode' => ['required', 'string', 'max:30', 'unique:asets,kode'.($aset ? ','.$aset->id : '')],
            'jenis' => ['required', 'string', 'max:40'],
            'nama' => ['required', 'string', 'max:150'],
            'alamat' => ['required', 'string', 'max:200'],
            'kota' => ['required', 'string', 'max:80'],
            'debitur_id' => ['nullable', 'exists:debiturs,id'],
            'luas_tanah' => ['required', 'integer', 'min:0'],
            'luas_bangunan' => ['required', 'integer', 'min:0'],
            'sertifikat' => ['required', 'string', 'max:60'],
            'harga_estimasi' => ['required', 'numeric', 'min:0'],
            'njop' => ['nullable', 'numeric', 'min:0'],
            'biaya_koran' => ['nullable', 'numeric', 'min:0'],
            'biaya_kjpp' => ['nullable', 'numeric', 'min:0'],
            'spesifikasi' => ['nullable', 'string'],
            'legalitas' => ['nullable', 'string'],
            'gambar_file' => ['nullable', 'image', 'max:4096'],
        ]);

        $data['booklet_ready'] = $request->boolean('booklet_ready');
        $data['pajak_lunas'] = $request->boolean('pajak_lunas');

        if ($request->hasFile('gambar_file')) {
            $file = $request->file('gambar_file');
            $name = 'aset-'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/aset'), $name);
            $data['gambar'] = 'uploads/aset/'.$name;
        }

        unset($data['gambar_file']);

        return $data;
    }
}