<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aset;
use App\Models\Debitur;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'total_aset' => Aset::count(),
            'total_debitur' => Debitur::count(),
            'nilai_market' => (float) Aset::sum('harga_estimasi'),
            'total_npf' => Debitur::where('is_npf', true)->count(),
        ];

        $trends = [
            'total_aset' => $this->trend(Aset::query()),
            'total_debitur' => $this->trend(Debitur::query()),
            'nilai_market' => $this->trend(Aset::query(), 'harga_estimasi'),
            'total_npf' => $this->trend(Debitur::where('is_npf', true)),
        ];

        $chart = $this->monthlyAsetChart();

        $topAset = Aset::with('debitur')->orderByDesc('likes_count')->orderByDesc('harga_estimasi')->first();

        $q = trim((string) $request->get('q'));
        $jenis = $request->get('jenis');

        $asets = Aset::with('debitur')
            ->when($q !== '', fn ($query) => $query->where(function ($w) use ($q) {
                $w->where('nama', 'like', "%$q%")
                    ->orWhere('kode', 'like', "%$q%")
                    ->orWhere('kota', 'like', "%$q%")
                    ->orWhereHas('debitur', fn ($d) => $d
                        ->where('cif', 'like', "%$q%")
                        ->orWhere('nama', 'like', "%$q%"));
            }))
            ->when($jenis, fn ($query) => $query->where('jenis', $jenis))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.dashboard', compact('stats', 'trends', 'chart', 'topAset', 'asets', 'q', 'jenis'));
    }

    /**
     * Bandingkan jumlah/total baris bulan ini vs bulan lalu untuk badge tren naik/turun.
     */
    protected function trend($query, ?string $sumColumn = null): ?array
    {
        $now = now();
        $lastMonth = now()->subMonthNoOverflow();

        $thisVal = (clone $query)
            ->whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)
            ->when($sumColumn, fn ($q) => $q, fn ($q) => $q)
            ->{$sumColumn ? 'sum' : 'count'}($sumColumn ?? '*');

        $lastVal = (clone $query)
            ->whereYear('created_at', $lastMonth->year)->whereMonth('created_at', $lastMonth->month)
            ->{$sumColumn ? 'sum' : 'count'}($sumColumn ?? '*');

        if ($lastVal <= 0) {
            return null; // belum ada pembanding bulan lalu
        }

        $pct = round((($thisVal - $lastVal) / $lastVal) * 100);

        return ['up' => $pct >= 0, 'pct' => abs($pct)];
    }

    /**
     * Jumlah aset baru per bulan, 6 bulan terakhir, untuk grafik.
     */
    protected function monthlyAsetChart(): array
    {
        $labels = [];
        $values = [];

        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->subMonthsNoOverflow($i);
            $labels[] = $bulan->translatedFormat('M');
            $values[] = Aset::whereYear('created_at', $bulan->year)->whereMonth('created_at', $bulan->month)->count();
        }

        return ['labels' => $labels, 'values' => $values];
    }
}