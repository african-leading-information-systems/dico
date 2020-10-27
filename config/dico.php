<?php

return [
    'stack' => 'livewire',

    'model' => [
        'dictionary' => \Alis\Dico\Dictionary::class,

        'type_dictionary' => \Alis\Dico\TypeDictionary::class,
    ],

    'databases' => [
        'soft_delete' => false,

        'sluggable' => false
    ],

    'lang' => ['en', 'fr'],

    'route_key_name' => null,
];
