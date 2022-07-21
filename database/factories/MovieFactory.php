<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $a=array(1,2,3,4,5);
        $n=2;
        $pushArray = [];
        $get = array_values(array_intersect_key( $a, array_flip( array_rand( $a, $n ) ) ));
        return [
            'title' => fake()->name(),
            'category' => json_encode($get)
        ];
    }
}
