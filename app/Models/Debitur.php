<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debitur extends Model
{
    protected $fillable = [
        'cif', 'nama', 'no_loan', 'segmen', 'produk',
        'cabang_pengelola', 'kolektibilitas', 'os_pokok', 'is_npf',
    ];

    protected $casts = ['is_npf' => 'boolean', 'os_pokok' => 'decimal:2'];

    /**
     * No Loan acak berformat LD + 8 angka (contoh: LD43516251), dijamin unik.
     */
    public static function generateNoLoan(): string
    {
        do {
            $noLoan = 'LD'.str_pad((string) random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
        } while (static::where('no_loan', $noLoan)->exists());

        return $noLoan;
    }

    public function asets()
    {
        return $this->hasMany(Aset::class);
    }
}