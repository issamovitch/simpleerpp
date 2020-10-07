<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKBArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('k_b_articles', function (Blueprint $table) {
            $table->id();
            $table->integer("order")->default(0);
            $table->string("subject");
            $table->string("slug")->unique();
            $table->integer("group_id")->nullable();
            $table->boolean("draft")->default(false);
            $table->text("text");
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
        Schema::dropIfExists('k_b_articles');
    }
}
