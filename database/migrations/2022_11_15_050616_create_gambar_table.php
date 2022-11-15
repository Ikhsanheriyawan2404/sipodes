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
            $table->string('alt')->nullable();

            $table->foreign('wisata_id')->references('id')->on('wisata')->onDelete('CASCADE');
            $table->foreign('budaya_id')->references('id')->on('budaya')->onDelete('CASCADE');
            $table->foreign('umkm_id')->references('id')->on('umkm')->onDelete('CASCADE');
            $table->foreign('produksi_pangan_id')->references('id')->on('produksi_pangan')->onDelete('CASCADE');
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
