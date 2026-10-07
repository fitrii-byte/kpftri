<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asets', function (Blueprint $table) {
            $table->decimal('njop', 15, 2)->nullable()->after('harga_estimasi');
            $table->decimal('biaya_koran', 15, 2)->nullable()->after('njop');
            $table->decimal('biaya_kjpp', 15, 2)->nullable()->after('biaya_koran');
            $table->boolean('pajak_lunas')->default(false)->after('biaya_kjpp');
        });
    }

    public function down(): void
    {
        Schema::table('asets', function (Blueprint $table) {
            $table->dropColumn(['njop', 'biaya_koran', 'biaya_kjpp', 'pajak_lunas']);
        });
    }
};