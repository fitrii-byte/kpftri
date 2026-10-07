<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('password');
            $table->string('no_hp')->nullable()->after('role');
            $table->timestamp('last_login_at')->nullable()->after('no_hp');
        });

        Schema::create('debiturs', function (Blueprint $table) {
            $table->id();
            $table->string('cif', 30);
            $table->string('nama');
            $table->string('no_loan', 40);
            $table->string('segmen', 60);
            $table->string('produk', 80);
            $table->string('cabang_pengelola', 100);
            $table->unsignedTinyInteger('kolektibilitas')->default(1);
            $table->decimal('os_pokok', 18, 2)->default(0);
            $table->boolean('is_npf')->default(false);
            $table->timestamps();
        });

        Schema::create('asets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('debitur_id')->nullable()->constrained('debiturs')->nullOnDelete();
            $table->string('kode', 30)->unique();
            $table->string('jenis', 40);            // Tanah, Rumah, Ruko, Gudang, Apartemen, Pabrik
            $table->string('nama');
            $table->string('alamat');
            $table->string('kota', 80);
            $table->unsignedInteger('luas_tanah')->default(0);
            $table->unsignedInteger('luas_bangunan')->default(0);
            $table->string('sertifikat', 60)->default('SHM');
            $table->text('spesifikasi')->nullable();
            $table->text('legalitas')->nullable();
            $table->decimal('harga_estimasi', 18, 2)->default(0);
            $table->string('gambar')->nullable();
            $table->boolean('booklet_ready')->default(true);
            $table->unsignedInteger('likes_count')->default(0);
            $table->timestamps();
        });

        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('link')->nullable();
            $table->string('gambar')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('aset_id')->constrained('asets')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'aset_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
        Schema::dropIfExists('banners');
        Schema::dropIfExists('asets');
        Schema::dropIfExists('debiturs');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'no_hp', 'last_login_at']);
        });
    }
};
