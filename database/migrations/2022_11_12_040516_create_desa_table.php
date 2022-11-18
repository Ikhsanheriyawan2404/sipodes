<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('code', 10);
            $table->char('district_code', 7);
            $table->char('city_code', 4);
            $table->string('url');
            $table->string('struktur');
            $table->string('phone_number')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            // $table->string('longitude');
            // $table->string('latitude');
            $table->text('description')->nullable();
            $table->string('logo')->default('default.jpg')->nullable();
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
        Schema::dropIfExists('desas');
    }
}
