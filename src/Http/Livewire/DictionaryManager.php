<?php

namespace Alis\Dico\Http\Livewire;

use Alis\Dico\Dico;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class DictionaryManager extends Component
{
    use WithPagination;

    public $code;
    public $description;
    public $types;
    public $type;
    public $dictionary;
    public $perPage = 10;
    public $search_text;
    public $search_type;

    public function mount()
    {
        $this->types = (Dico::getTypeDictionaryModel())->all();
    }

    public function openModal(int $id = null): void
    {
        $this->showForm($id);

        $this->emit('openModal');
    }

    private function showForm($id = null)
    {
        $this->dictionary = is_null($id) ? null : $this->getDicoModel()->findOrfail($id);

        $this->setType();
    }

    public function submit()
    {
        if ($this->dictionary) {
            $this->update();
        } else {
            $this->create();
        }
    }

    public function create ()
    {
        $this->validate([
            'code' => ['required', 'string', 'max:255',
                Rule::unique('dictionaries', 'code')->where(function ($query) {
                    return $query->where('type_dictionary_id', $this->type);
                })
            ],
            'description' => 'required|array',
            'description.*' => 'required|max:255',
            'type' => 'required|numeric|exists:type_dictionaries,id'
        ]);

        $this->getDicoModel()->create([
            'code' => $this->code,
            'description' => $this->description,
            'type_dictionary_id' => $this->type
        ]);

        $this->resetForm();

        session()->flash('message-success', 'Dictionnaire crée avec succès.');
    }

    public function edit(int $id)
    {
        $this->dictionary = $this->getDicoModel()->findOrfail($id);

        $this->setType();
    }

    public function update()
    {
        $dictionary = $this->getDicoModel()->findOrfail($this->dictionary->id);

        $this->validate([
            'code' => ['required', 'string', 'max:255',
                Rule::unique('dictionaries', 'code')->ignore($dictionary->id)->where(function ($query) {
                    return $query->where('type_dictionary_id', $this->type);
                })
            ],
            'description' => 'required|array',
            'description.*' => 'required|max:255',
            'type' => 'required|numeric|exists:type_dictionaries,id'
        ]);

        $dictionary->update([
            'code' => $this->code,
            'description' => $this->description,
            'type_dictionary_id' => $this->type
        ]);

        session()->flash('message-success', 'Dictionnaire mis à jour avec succès.');
    }

    public function resetForm()
    {
        $this->dictionary = null;

        $this->setType();
    }

    public function resetFilter ()
    {
        $this->search_text = null;

        $this->search_type = null;
    }

    public function delete(int $id)
    {
        $dico = $this->getDicoModel()->findOrfail($id);

        if ($dico->hasConstraint()) {

            session()->flash('message-error', 'Impossible de supprimer le dictionnaire car il est lié à des données.');

            return false;
        }

        $dico->delete();

        session()->flash('message-success', 'Dictionnaire supprimé avec succès.');
    }

    private function setType()
    {
        $this->code = is_null($this->dictionary) ? null : $this->dictionary->code;

        $this->description = is_null($this->dictionary) ? null : $this->dictionary->getTranslations()['description'];

        $this->type = is_null($this->dictionary) ? null : $this->dictionary->type_dictionary_id;
    }

    private function getDicoModel()
    {
        return (Dico::getDictionaryModel());
    }

    public function render()
    {
        $dictionaryQuery = $this->getDicoModel()->with('type');

        if ($this->search_text) {
            $dictionaryQuery = $dictionaryQuery->where('code', 'like', '%'.$this->search_text.'%')
                ->orWhere('description', 'like', '%'.$this->search_text.'%');
        }

        if ($this->search_type) {
            $dictionaryQuery = $dictionaryQuery->where('type_dictionary_id', $this->search_type);
        }

        $dictionaries = $dictionaryQuery->paginate($this->perPage);

        return view('dico::livewire.dictionary-manager', [
            'dictionaries' => $dictionaries
        ]);
    }
}
