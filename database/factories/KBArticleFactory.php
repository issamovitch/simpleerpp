<?php

namespace Database\Factories;

use App\Models\KBArticle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class KBArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = KBArticle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "order" => $this->faker->unique(true, 100000)->numberBetween(1,1000),
            "subject" => $this->faker->sentence(3, true),
            "slug" => $this->faker->slug(),
            "draft" => $this->faker->boolean(50),
            "text" => $this->faker->realText(2000, 5)
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (KBArticle $article) {
            $article->slug = $this->slug_unique($article->subject);
        })->afterCreating(function (KBArticle $user) {
            //
        });
    }

    public function slug_unique($title)
    {
        $unique = false;
        $tested = [];
        do {
            $slug = Str::of($title)->slug('-');
            if(count($tested)>0)
                $slug.= "-".count($tested);
            if (in_array($slug, $tested)) {
                continue;
            }
            $count = KBArticle::where("slug", $slug)->count();
            array_push($tested, $slug);
            if ($count == 0) {
                $unique = true;
            }
        } while (!$unique);
        return $slug;
    }

}
