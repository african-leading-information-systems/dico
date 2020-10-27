<?php


namespace Alis\Dico;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

abstract class TypeDicoAbstract extends Model
{
    use HasTranslations;

    public $translatable = ['description'];

    protected $fillable = [
        'code',
        'description'
    ];

    public function dictionaries(): HasMany
    {
        return $this->hasMany(Dico::getDictionaryModel());
    }
}
