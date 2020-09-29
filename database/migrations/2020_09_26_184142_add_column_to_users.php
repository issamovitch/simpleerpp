<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer("role_id")->after("password");
            $table->integer("designation_id")->nullable();
            $table->integer("department_id")->nullable();
            $table->integer("manager_id")->nullable();
            $table->text("workplace")->nullable();
            $table->string("phone")->nullable();
            $table->string("mobile")->nullable();
            $table->text("emergency_contact")->nullable();
            $table->string("gender")->nullable();
            $table->string("civil_status")->nullable();
            $table->integer("number_of_children")->nullable();
            $table->string("nationality")->nullable();
            $table->string("num_identification")->nullable();
            $table->string("num_passport")->nullable();
            $table->string("date_of_birth")->nullable();
            $table->string("place_of_birth")->nullable();
            $table->string("native_country")->nullable();
            $table->string("certificate_level")->nullable();
            $table->string("field_of_study")->nullable();
            $table->string("university")->nullable();
            $table->string("image")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
