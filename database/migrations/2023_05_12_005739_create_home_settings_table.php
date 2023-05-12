<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_settings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('title');
            $table->string('sub_title');
            $table->string('left_col_title');
            $table->string('left_col_summary');
            $table->string('left_col_btn');
            $table->string('left_col_btn_link')->nullable();
            $table->string('right_col_title');
            $table->string('right_col_summary');
            $table->string('right_col_btn');
            $table->string('right_col_btn_link')->nullable();
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
        Schema::dropIfExists('home_settings');
    }
}
