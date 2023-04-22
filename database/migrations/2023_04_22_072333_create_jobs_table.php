<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->string("slug")->unique();
            $table->string("title");
            $table->text("summary")->nullable();
            $table->longText("description")->nullable();
            $table->double("salary_min")->nullable()->default(0.00);
            $table->double("salary_max")->nullable()->default(0.00);
            $table->text("insurance")->nullable();
            $table->date("deadline")->nullable();
            $table->integer('location')->nullable();
            $table->boolean('remote')->default(false);
            $table->text('responsibilities')->nullable();
            $table->text('required_skills')->nullable();
            $table->text('preferred_skills')->nullable();
            $table->string("type");
            $table->boolean("trash")->default(false);
            $table->boolean("publish")->default(false);
            $table->timestamp("published_on")->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
