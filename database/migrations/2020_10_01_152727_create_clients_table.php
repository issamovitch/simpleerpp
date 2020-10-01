<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->integer("company")->nullable();
            $table->tinyInteger("type")->default(0)->comment("0 = Particular, 1 = Company");
            $table->string("name");
            $table->string("reference")->unique();
            $table->integer("sector_id")->nullable();
            $table->integer("client_group_id")->nullable();
            $table->string("image")->nullable();
            // Address
            $table->string("street")->nullable();
            $table->string("street2")->nullable();
            $table->string("city")->nullable();
            $table->string("state")->nullable();
            $table->string("postal_code")->nullable();
            $table->string("country")->nullable();
            $table->string("tva_num")->nullable();
            // Contact
            $table->string("phone")->nullable();
            $table->string("mobile")->nullable();
            $table->string("email")->nullable();
            $table->string("website")->nullable();
            // Notes
            $table->text("notes")->nullable();
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
        Schema::dropIfExists('clients');
    }
}
