<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel untuk menyimpan pesan/komplain dari halaman Customer Service.
     * Bisa dikirim oleh pengunjung (guest) maupun user yang sudah login.
     */
    public function up(): void
    {
        Schema::create('cs_messages', function (Blueprint $table) {
            $table->id();
            $table->string('nama');                       // nama pengirim
            $table->string('email');                      // email pengirim
            $table->string('whatsapp')->nullable();       // no. WA (opsional)
            $table->string('subjek')->nullable();         // jenis pertanyaan
            $table->string('id_pembelian')->nullable();   // no. pesanan terkait (TRX-xxxx, opsional)
            $table->text('pesan');                        // isi pesan
            $table->unsignedBigInteger('user_id')->nullable(); // FK → users.id (null kalau guest)
            $table->enum('status', ['Baru', 'Dibaca', 'Dibalas'])->default('Baru');
            $table->timestamps();

            $table->foreign('user_id')
                   ->references('id')->on('users')
                   ->nullOnDelete();
            $table->foreign('id_pembelian')
                   ->references('id_pembelian')->on('pembelians')
                   ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cs_messages');
    }
};
