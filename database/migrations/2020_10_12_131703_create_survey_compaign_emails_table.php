<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyCompaignEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_compaign_emails', function (Blueprint $table) {
            $table->id();
            $table->integer("survey_id");
            $table->integer("survey_compaign_id");
            $table->integer("mailing_list_email_id");
            $table->string("email");
            $table->tinyInteger("status")->default(0);
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
        Schema::dropIfExists('survey_compaign_emails');
    }
}
