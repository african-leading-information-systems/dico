# Dico package

## Introduction

It's basically livewire based as scaffolding for the moment for the CRUD, but you can still do without that and use your tools yourself. Dico uses boostrap as the base UI, 
but you can still push package views and customize them.

**We are planning to add more scaffolding, so you will have the flexibility to choose the right scaffold for you.**

## Installation
Require this package in your composer.json and update composer.

```bash
composer require alis/dico
```

## Configuration
**Laravel 5.5** uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider/Facade.

Finally you can publish the config file:

```bash
php artisan vendor:publish --provider="Alis\Dico\DicoServiceProvider"
```

#### Config file

The main change to this config file (config/dico.php) will be the path to the binaries.

```php
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

    'lang' => ['en'],

    'route_key_name' => null,
];

```

## Using

## Licenses
This packages is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
