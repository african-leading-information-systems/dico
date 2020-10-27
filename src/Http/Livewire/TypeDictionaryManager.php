<?php

namespace Alis\Dico\Http\Livewire;

use Alis\Dico\Dico;
use Livewire\Component;
use Livewire\WithPagination;

class TypeDictionaryManager extends Component
{
    use WithPagination;

    public $code;
    public $description;
    public $type;
    public $perPage = 10;
    public $search_text;

    public function submit()
    {
        if ($this->type) {
            $this->update();
        } else {
            $this->create();
        }
    }

    public function openModal(int $id = null): void
    {
        $this->showForm($id);

        $this->emit('openModal');
    }

    public function update()
    {
        $type = $this->getTypeDico()->findOrfail($this->type->id);

        $this->validate([
            'code' => 'required|string|max:255|unique:type_dictionaries,code,'.$type->id
        ]);

        $type->update([
            'code' => $this->code,
            'description' => $this->description
        ]);

        session()->flash('message-success', 'Type dictionnaire modifié avec succès.');
    }

    public function edit(int $id)
    {
        $this->type = $this->getTypeDico()->findOrfail($id);

        $this->setType();
    }

    private function showForm($id = null)
    {
        if ($id) {
            $this->type = $this->getTypeDico()->findOrfail($id);
            $this->setType();
        }

        $this->setType();
    }

    public function create()
    {
        $this->validate([
            'code' => 'required|string|max:255|unique:type_dictionaries,code',
            'description' => 'required|array',
            'description.*' => 'required|max:255'
        ]);

        $this->getTypeDIco()->create([
           'code' => $this->code,
           'description' => $this->description
        ]);

        $this->resetForm();

        session()->flash('message-success', 'Type dictionnaire crée avec succès.');
    }

    public function resetForm()
    {
        $this->type = null;

        $this->setType();
    }

    public function delete(int $id)
    {
        $type = $this->getTypeDico()->findOrfail($id);

        if (count($type->dictionaries)) {

            session()->flash('message-error', 'Impossible de supprimer ce type dictionnaire car il est lié à un ou plusieurs dictionnaires.');

            return false;
        }

        $type->delete();

        session()->flash('message-success', 'Type dictionnaire supprimé avec succès.');
    }

    private function setType()
    {
        $this->code = $this->type ? $this->type->code : null;

        $this->description = $this->type ? ($this->type->getTranslations()['description']) : null;
    }

    private function getTypeDico()
    {
        return Dico::getTypeDictionaryModel();
    }

    public function resetFilter ()
    {
        $this->search_text = null;
    }

    public function render()
    {
        $typeQuery = $this->getTypeDIco();

        if ($this->search_text) {
            $typeQuery = $typeQuery->where('code', 'like', '%'.$this->search_text.'%')
                     ->orWhere('description', 'like', '%'.$this->search_text.'%');
        }

        $types = $typeQuery->paginate($this->perPage);

        return view('dico::livewire.type-dictionary-manager', [
            'types' => $types
        ]);
    }
}
