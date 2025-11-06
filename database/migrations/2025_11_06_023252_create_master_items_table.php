<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('master_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori_items')->onDelete('cascade');
            $table->string('kode');
            $table->string('nama');
            $table->integer('harga_beli');
            $table->integer('laba');
            $table->string('supplier');
            $table->string('jenis');
            $table->string('foto');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('master_items');
    }
};
