<?php
namespace Alis\Dico;


class Dico
{
    public static function getDictionaryModel()
    {
        $dico = app(config('dico.model.dictionary'));

        if (! ($dico instanceof DicoContract)) {
            throw new \InvalidArgumentException('Dictionary model in config file must be implemented '.DicoContract::class);
        }

        return $dico;
    }

    public static function getTypeDictionaryModel()
    {
        return app(config('dico.model.type_dictionary'));
    }

}
