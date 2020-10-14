<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->integer("client_id")->nullable();
            $table->boolean("progress_tasks")->default(true);
            $table->integer("progress")->default(0);
            $table->text("description")->nullable();
            $table->string("start_date");
            $table->string("deadline")->nullable();
            $table->tinyInteger("status")->default(0);
            $table->tinyInteger("billing_type")->default(0);
            $table->string("fixed_rate")->default("0");
            $table->string("rate_per_hour")->default("0");
            $table->string("final_price")->default("0");
            $table->text("labels")->nullable();
            $table->timestamps();
        });
        Schema::create('project_user', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('project_id')->unsigned()->index();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->tinyInteger("type")->default(0)->comment("0=member, 1=manager");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
        Schema::dropIfExists('project_user');
    }
}
