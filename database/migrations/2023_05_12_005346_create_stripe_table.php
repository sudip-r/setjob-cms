<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->boolean('live')->default(false);
            $table->string('test_publishable_key')->nullable();
            $table->string('test_secret_key')->nullable();
            $table->string('live_publishable_key')->nullable();
            $table->string('live_secret_key')->nullable();
            $table->string('currency',3)->nullable();
            $table->string('currency_symbol',3)->nullable();
            $table->string('dashboard')->nullable();
            $table->string('test_dashboard')->nullable();
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
        Schema::dropIfExists('stripe');
    }
}
