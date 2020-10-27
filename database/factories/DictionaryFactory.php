<?php
use Faker\Generator as Faker;

$factory->define(\Alis\Dico\Dictionary::class, function (Faker $faker) {
    $type = factory(\Alis\Dico\TypeDictionary::class)->create();

    return [
        'code' => $faker->text(5),
        'description' => [
            'en' => $faker->text(50),
            'fr' => $faker->text(50)
        ],
        'type_dictionary_id' => $type->id
    ];
});
