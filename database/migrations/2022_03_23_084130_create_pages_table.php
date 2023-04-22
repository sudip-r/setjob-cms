<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('page')->comment('Name of page');
            $table->string("slug")->unique();
            $table->text('summary')->nullable()->comment('Page excerpt');
            $table->text('description')->nullable()->comment('Full description');
            $table->string('type',10)->nullable()->default('normal')->comment('Type of page (normal / block)');
            $table->text('blocks')->nullable()->comment('Block designs / sections in JSON format');
            $table->string('image')->nullable()->comment('Featured image');
            $table->text('video')->nullable();
            $table->boolean('publish')->default(0)->comment('Publish status');
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
        Schema::dropIfExists('pages');
    }
}
