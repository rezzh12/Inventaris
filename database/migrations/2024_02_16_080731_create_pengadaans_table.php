<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengadaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengadaans', function (Blueprint $table) {
            $table->id();
            $table->string('kode',10);
            $table->date('tanggal_pengadaan');
            $table->string('keterangan',100);
            $table->integer('harga');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('perencanaan_id')->constrained();
            $table->foreignId('ruangan_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengadaans');
    }
}
