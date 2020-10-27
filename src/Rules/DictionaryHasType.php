<?php

namespace Alis\Dico\Rules;

use Alis\Dico\Dico;
use Illuminate\Contracts\Validation\Rule;

class DictionaryHasType implements Rule
{
    /**
     * @var string
     */
    private $code;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (Dico::getDictionaryModel())
            ->where('id', $value)
            ->getByTypeCodes($this->code)
            ->first();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Le dictionnaire n\'est pas du bon type dictionnaire.';
    }
}
