<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string("partner_name");
            $table->string("image")->default("default.png");
            $table->string("cover_image")->nullable()->default("default_cover.png");
            $table->string("partner_link")->nullable();
            $table->integer("sort_order")->nullable()->default(0);
            $table->boolean("publish")->default(0);
            $table->text("summary")->nullable();
            $table->text("description")->nullable();
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
        Schema::dropIfExists('partners');
    }
}
