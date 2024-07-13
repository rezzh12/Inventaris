<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendistribusiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendistribusians', function (Blueprint $table) {
             $table->id();
            $table->string('kode',10);
            $table->date('tanggal_pendistribusian');
            $table->string('keterangan',100);
            $table->string('penerima',100);
            $table->foreignId('pengadaan_id')->constrained();
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
        Schema::dropIfExists('pendistribusians');
    }
}
