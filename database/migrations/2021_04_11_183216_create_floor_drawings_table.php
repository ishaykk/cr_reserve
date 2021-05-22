<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFloorDrawingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('floor_drawings', function (Blueprint $table) {
            $table->id();
            $table->integer('floor_id')->unique();
            $table->string('building');
            $table->string('description')->nullable();
            $table->longText('drawing_data');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('last_update_by')->unsigned()->nullable();
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
        Schema::dropIfExists('floor_drawings');
    }
}
