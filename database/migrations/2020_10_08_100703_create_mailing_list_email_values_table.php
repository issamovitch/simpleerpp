<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailingListEmailValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailing_list_email_values', function (Blueprint $table) {
            $table->id();
            $table->integer("mailing_list_id");
            $table->integer("mailing_list_field_id");
            $table->integer("mailing_list_email_id");
            $table->text("value")->nullable();
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
        Schema::dropIfExists('mailing_list_email_values');
    }
}
