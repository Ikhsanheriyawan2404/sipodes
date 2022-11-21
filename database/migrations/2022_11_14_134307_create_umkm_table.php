<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUmkmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('umkm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('meta_description')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('location');
            $table->string('thumbnail');
            $table->string('contact');
            $table->text('description');
            $table->text('type_umkm');
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
        Schema::dropIfExists('umkm');
    }
}
