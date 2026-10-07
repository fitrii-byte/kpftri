<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Debitur;
use Illuminate\Http\Request;
use ZipArchive;

class MasterDataController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q'));
        $status = $request->get('status'); // npf | non-npf

        $debiturs = Debitur::query()
            ->when($q !== '', fn ($query) => $query->where(function ($w) use ($q) {
                $w->where('nama', 'like', "%$q%")
                    ->orWhere('cif', 'like', "%$q%")
                    ->orWhere('no_loan', 'like', "%$q%")
                    ->orWhere('cabang_pengelola', 'like', "%$q%");
            }))
            ->when($status === 'npf', fn ($query) => $query->where('is_npf', true))
            ->when($status === 'non-npf', fn ($query) => $query->where('is_npf', false))
            ->orderBy('nama')
            ->paginate(15)
            ->withQueryString();

        return view('admin.master-data', compact('debiturs', 'q', 'status'));
    }

    public function show(Debitur $debitur)
    {
        return view('admin.master-data-show', [
            'debitur' => $debitur->load('asets'),
        ]);
    }

    public function create()
    {
        return view('admin.master-data-form', [
            'debitur' => new Debitur(['no_loan' => Debitur::generateNoLoan()]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        Debitur::create($data);

        return redirect()->route('admin.master.index')->with('status', 'Data debitur berhasil ditambahkan.');
    }

    public function edit(Debitur $debitur)
    {
        return view('admin.master-data-form', compact('debitur'));
    }

    public function update(Request $request, Debitur $debitur)
    {
        $data = $this->validated($request, $debitur->id);

        $debitur->update($data);

        return redirect()->route('admin.master.index')->with('status', 'Data debitur berhasil diperbarui.');
    }

    public function destroy(Debitur $debitur)
    {
        $debitur->delete();

        return back()->with('status', 'Data debitur berhasil dihapus.');
    }

    protected function validated(Request $request, ?int $ignoreId = null): array
    {
        $data = $request->validate([
            'cif' => ['required', 'string', 'max:30'],
            'nama' => ['required', 'string', 'max:150'],
            'no_loan' => ['required', 'regex:/^LD\d{8}$/', 'unique:debiturs,no_loan'.($ignoreId ? ",$ignoreId" : '')],
            'segmen' => ['required', 'string', 'max:50'],
            'produk' => ['required', 'string', 'max:100'],
            'cabang_pengelola' => ['required', 'string', 'max:150'],
            'kolektibilitas' => ['required', 'integer', 'min:1', 'max:5'],
            'os_pokok' => ['required', 'numeric', 'min:0'],
        ], [
            'no_loan.regex' => 'No Loan harus diawali LD diikuti 8 angka, contoh: LD43516251.',
            'no_loan.unique' => 'No Loan ini sudah dipakai debitur lain.',
        ]);

        $data['is_npf'] = $data['kolektibilitas'] >= 3;

        return $data;
    }

    /**
     * Unduh database portofolio pembiayaan (NPF & Non NPF) dalam satu file ZIP.
     */
    public function exportZip()
    {
        $tmpDir = storage_path('app/export');
        if (! is_dir($tmpDir)) {
            mkdir($tmpDir, 0775, true);
        }

        $zipPath = $tmpDir.'/portofolio-'.now()->format('Ymd-His').'.zip';
        $zip = new ZipArchive();
        $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $zip->addFromString('portofolio_npf.csv', $this->csv(true));
        $zip->addFromString('portofolio_non_npf.csv', $this->csv(false));
        $zip->addFromString('README.txt',
            "Database Portofolio Pembiayaan\nDiunduh: ".now()->format('d/m/Y H:i')."\n".
            "portofolio_npf.csv     : debitur dengan kolektibilitas 3-5 (NPF)\n".
            "portofolio_non_npf.csv : debitur dengan kolektibilitas 1-2 (Non NPF)\n"
        );
        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    protected function csv(bool $npf): string
    {
        $rows = [['NO', 'CIF', 'NAMA NASABAH', 'NO LOAN', 'SEGMEN', 'PRODUK', 'CABANG PENGELOLA', 'KOLEKTIBILITAS', 'OS POKOK']];

        foreach (Debitur::where('is_npf', $npf)->orderBy('nama')->get() as $i => $d) {
            $rows[] = [$i + 1, $d->cif, $d->nama, $d->no_loan, $d->segmen, $d->produk, $d->cabang_pengelola, $d->kolektibilitas, $d->os_pokok];
        }

        $out = fopen('php://temp', 'r+');
        foreach ($rows as $row) {
            fputcsv($out, $row, ';');
        }
        rewind($out);
        $csv = stream_get_contents($out);
        fclose($out);

        return $csv;
    }
}