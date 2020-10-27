<?php

namespace Alis\Dico;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

abstract class DicoAbstract extends Model implements DicoContract
{
    use HasTranslations;

    public $translatable = ['slug', 'description'];

    protected $fillable = [
        'type_dictionary_id',
        'code',
        'description',
        'slug'
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(TypeDictionary::class,'type_dictionary_id');
    }

    public function scopeGetByTypeCodes($query, $codes)
    {
        if (is_string($codes)) {
            $args = func_get_args();

            array_shift($args);

            $codes = $args;
        }

        return $query->with('type')->whereHas('type', function ($builder) use ($codes) {
            return $builder->whereIn('code', $codes);
        });
    }

    public function setAttribute($key, $value)
    {
        if ($key === 'description' && is_array($value) && config('dico.databases.sluggable')) {
            $this->attributes['description'] = json_encode($value);

            return $this->attributes['slug'] = json_encode($this->generateTranslateSlugArray($value));
        }

        return parent::setAttribute($key, $value);
    }

    private function generateTranslateSlugArray(array $data): array
    {
        $i = 0;

        do {
            $slug = [];

            $prefix = $i ? '-'.$i : '';

            foreach (config('dico.lang') as $lang) {
                $slug[$lang] = Str::slug($data[$lang], '-').$prefix;
            }

            $i++;
        } while (self::slugExist($slug)->first());

        return $slug;
    }

    public function scopeSlugExist($query, array $slug)
    {
        foreach (config('dico.lang') as $lang) {
            $query->orWhere('slug->'.$lang, $slug[$lang]);
        }

        return $query;
    }

    public function getRouteKeyName()
    {
        return config('dico.route_key_name') ?: $this->getKeyName();
    }
}
