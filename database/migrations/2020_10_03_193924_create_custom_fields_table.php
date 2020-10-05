<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->id();
            $table->integer("order")->default(0);
            $table->string("model");
            $table->integer("group_id")->nullable();
            $table->string("name");
            $table->string("type");
            $table->text("options")->nullable();
            $table->integer("width")->default(12);
            $table->string("placeholder")->nullable();
            $table->boolean("required")->default(false);
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
        Schema::dropIfExists('custom_fields');
    }
}
