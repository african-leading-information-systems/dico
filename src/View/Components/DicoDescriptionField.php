<?php

namespace Alis\Dico\View\Components;

use Illuminate\View\Component;

class DicoDescriptionField extends Component
{
    /**
     * @var \Illuminate\Config\Repository
     */
    public $lang;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->lang = config('dico.lang');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('dico::components.dico-description-field');
    }
}
