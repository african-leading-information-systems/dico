<?php

namespace Alis\Dico\View\Components;

use Alis\Dico\Dico;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class DicoSelect extends Component
{
    public $dictionaries;
    public $types;
    public $source;
    public $wire;
    public $class;
    public $name;
    public $placeholder;
    public $value;
    public $multiple;

    /**
     * DicoSelect constructor.
     *
     * @param array|string $types
     * @param Collection|null $source
     * @param string $name
     * @param bool $wire
     * @param string $class
     * @param null $value
     * @param string $placeholder
     * @param bool $multiple
     */
    public function __construct($types, Collection $source = null, $name = 'dictionary_id',
                                $wire = false, $class = 'form-control', $value = null, string $placeholder = "CLick to choose",
                                $multiple = false)
    {
        $this->types = is_string($types) ? explode(',', $types) : $types;

        $this->source = $source;

        $this->wire = $wire;

        $this->class = $class;

        $this->name = $name;

        $this->placeholder = $placeholder;

        $this->value = $value;

        $this->multiple = $multiple;

        $this->initDico();
    }

    private function initDico()
    {
        if (! count($this->source)) {
            $this->dictionaries = (Dico::getDictionaryModel())->getByTypeCodes($this->types)->get();
        } else {
            $this->dictionaries = $this->source->filter(function ($dico) {
                return in_array($dico->type->code, $this->types);
            });
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('dico::components.dico-select');
    }
}
