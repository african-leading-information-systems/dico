<?php
use Faker\Generator as Faker;

$factory->define(\Alis\Dico\TypeDictionary::class, function (Faker $faker) {
    return [
        'code' => $faker->text(5),
        'description' => [
            'en' => $faker->text(50),
            'fr' => $faker->text(50)
        ]
    ];
});

