<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemeliharaanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemeliharaan_details', function (Blueprint $table) {
            $table->id();
            $table->integer('jumlah');
            $table->string('status',10);
            $table->string('keterangan',100);
            $table->foreignId('barang_id')->constrained();
            $table->foreignId('inventaris_id')->constrained();
            $table->foreignId('pemeliharaan_id')->constrained();
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
        Schema::dropIfExists('pemeliharaan_details');
    }
}
