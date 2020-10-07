<?php

namespace Database\Seeders;

use App\Models\KBGroup;
use App\Models\KBArticle;
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
        KBGroup::truncate();
        KBArticle::truncate();
        KBGroup::factory()->times(7)->hasArticles(7)->create();
    }
}
