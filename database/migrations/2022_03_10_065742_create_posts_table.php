<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string("title");
            $table->text("summary")->nullable();
            $table->string("slug")->unique();
            $table->longText("description");
            $table->string("image");
            $table->integer("author");
            $table->text("video")->nullable();
            $table->integer("last_modified");
            $table->boolean("trash")->default(false);
            $table->string("post_type")->default("post");
            $table->boolean("publish")->default(false);
            $table->timestamp("published_on")->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('posts');
    }
}
