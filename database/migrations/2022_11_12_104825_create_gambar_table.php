<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGambarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gambar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('wisata_id')->nullable();
            $table->unsignedBigInteger('umkm_id')->nullable();
            $table->unsignedBigInteger('produksi_pangan_id')->nullable();
            $table->unsignedBigInteger('budaya_id')->nullable();
            $table->string('image');
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
        Schema::dropIfExists('gambar');
    }
}
