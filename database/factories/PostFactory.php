<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Post::class;

    public function definition()
    {
        return [
            'title' => $this->faker->realText(rand(15,40)),
            'prefecture'=> '東京都',
            'user_id'=> $this->faker->numberBetween(1,3),
            'created_at'=>now(),
            'updated_at' => now(),
            //
        ];
    }
}
