<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Status::class, function (Faker $faker) {
    $time=$faker->dateTime;
    return [
        'content'=>$faker->text(),
        'created_at'=>$time,
        'updated_at'=>$time,
    ];
});
