<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksiPanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produksi_pangan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('meta_description')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('thumbnail');
            $table->string('name');
            $table->string('slug');
            $table->text('location');
            $table->string('contact');
            $table->string('type_produksi_pangan');
            $table->text('description');
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
        Schema::dropIfExists('produksi_pangan');
    }
}
