<?php

namespace Database\Seeders;

use App\Models\KBGroup;
use App\Models\KBArticle;
use App\Models\MailingList;
use App\Models\MailingListEmail;
use App\Models\MailingListEmailValue;
use App\Models\MailingListField;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyCampaign;
use App\Models\SurveyCompaignEmail;
use App\Models\SurveyCompaignMailingList;
use App\Models\SurveyParticipant;
use App\Models\SurveyQuestion;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Knowledge Base
        /*KBGroup::truncate();
        KBArticle::truncate();
        KBGroup::factory()->times(7)->hasArticles(7)->create();*/
        // Mailing Lists
        /*MailingList::truncate();
        MailingListField::truncate();
        MailingListEmail::truncate();
        MailingListEmailValue::truncate();
        MailingList::factory()->times(4)
            ->afterCreating(function ($list, $faker) {
                $fields = MailingListField::factory()->times(rand(1, 3))->create(["mailing_list_id" => $list->id]);
                MailingListEmail::factory()->times(rand(100, 1000))
                    ->afterCreating(function ($email, $faker) use($list, $fields) {
                        foreach ($fields as $field){
                            MailingListEmailValue::factory()
                                ->create(["mailing_list_email_id" => $email->id, "mailing_list_id" => $list->id, "mailing_list_field_id" => $field->id]);
                        }
                    })->create(["mailing_list_id" => $list->id]);
            })->create();
        */
        // Surveys
        Survey::truncate();
        SurveyQuestion::truncate();
        SurveyAnswer::truncate();
        SurveyCampaign::truncate();
        SurveyCompaignMailingList::truncate();
        SurveyCompaignEmail::truncate();
        SurveyParticipant::truncate();
        Survey::factory()->times(3)
            ->afterCreating(function ($survey, $faker){
                SurveyQuestion::factory()->times(rand(4, 10))
                    ->create(["survey_id" => $survey->id]);
            })
            ->create();
    }
}
