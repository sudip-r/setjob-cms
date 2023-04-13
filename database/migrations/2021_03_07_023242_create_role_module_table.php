<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleModuleTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('role_module', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('role_id');
      $table->unsignedBigInteger('module_id');
      $table->timestamps();

      $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
      $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('role_module');
  }
}
