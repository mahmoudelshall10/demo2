<?php

use Faker\Generator as Faker;

$factory->define(\App\News::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(5),
        'body'  => $faker->sentence(5),
        'desc' => $faker->sentence(5),
        'addby' => 1,
        'deleted_at' => null
  
    ];
});
