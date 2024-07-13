<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerencanaanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perencanaan_details', function (Blueprint $table) {
            $table->id();
            $table->integer('qty');
            $table->integer('harga');
            $table->string('status',20);
            $table->string('merk',20);
            $table->foreignId('barang_id')->constrained();
            $table->foreignId('perencanaan_id')->constrained();
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
        Schema::dropIfExists('perencanaan_details');
    }
}
