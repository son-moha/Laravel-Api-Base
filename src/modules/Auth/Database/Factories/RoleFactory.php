<?php

namespace Modules\Auth\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Auth\Entities\Models\Role;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class RoleFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = \Faker\Factory::create('en_US');

        return [
            'name' => $faker->word,
            'description' => $faker->word,
        ];
    }
}
