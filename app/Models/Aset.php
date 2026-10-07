<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    protected $fillable = [
        'debitur_id', 'kode', 'jenis', 'nama', 'alamat', 'kota',
        'luas_tanah', 'luas_bangunan', 'sertifikat', 'spesifikasi',
        'legalitas', 'harga_estimasi', 'gambar', 'booklet_ready', 'likes_count',
        'njop', 'biaya_koran', 'biaya_kjpp', 'pajak_lunas',
    ];

    protected $casts = [
        'booklet_ready' => 'boolean',
        'harga_estimasi' => 'decimal:2',
        'njop' => 'decimal:2',
        'biaya_koran' => 'decimal:2',
        'biaya_kjpp' => 'decimal:2',
        'pajak_lunas' => 'boolean',
    ];

    public const BIAYA_PENDAFTARAN_LELANG = 150000;

    /** Dasar pengenaan BPHTB = nilai tertinggi antara harga lelang dan NJOP. */
    public function getDasarBphtbAttribute(): float
    {
        return max((float) $this->harga_estimasi, (float) $this->njop);
    }

    /** BPHTB 5% dari dasar pengenaan. */
    public function getBphtbAttribute(): float
    {
        return $this->dasar_bphtb * 0.05;
    }

    /** Total estimasi biaya yang perlu disiapkan pembeli. */
    public function getTotalBiayaLelangAttribute(): float
    {
        return $this->bphtb
            + self::BIAYA_PENDAFTARAN_LELANG
            + (float) $this->biaya_koran
            + (float) $this->biaya_kjpp;
    }

    /** Apakah admin sudah mengisi data biaya lelang untuk aset ini. */
    public function getRincianBiayaTersediaAttribute(): bool
    {
        return (float) $this->njop > 0;
    }

    /**
     * Buat kode aset acak 6 angka (contoh: 362738), dijamin unik.
     */
    public static function generateKode(): string
    {
        do {
            $kode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (static::where('kode', $kode)->exists());

        return $kode;
    }

    public function debitur()
    {
        return $this->belongsTo(Debitur::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function getGambarUrlAttribute(): string
    {
        $g = $this->gambar ?: 'images/rumah.jpg';

        return asset($g);
    }
}