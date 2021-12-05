<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjectToCollectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('object_to_collects', function (Blueprint $table) {
            $table->id();
            $table->string('unique_name')->unique();
            $table->unsignedBigInteger('instrections_id');
            $table->float('sell_price');
            $table->float('buy_price');
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
        Schema::dropIfExists('object_to_collects');
    }
}