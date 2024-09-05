<?php

namespace App\Http\Livewire;

use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotesForm extends Component
{
    public $notes = [];

    protected $rules = [
        'notes.*.property' => 'required',
        'notes.*.asset' => 'required',
    ];

    public function mount($initialNotes)
    {
        $this->notes = collect($initialNotes)->map(function ($note, $index) {
            return array_merge($note, ['arrange' => $index]);
        })->toArray();
    }

    public function addNote()
    {
        $this->notes[] = [
            'property' => '',
            'asset' => '',
            'arrange' => count($this->notes)
        ];
    }

    public function removeNote($index)
    {
        unset($this->notes[$index]);
        $this->notes = array_values($this->notes);
        $this->updateOrder();
    }

    public function updateNoteOrder($newOrder)
    {
        $orderedNotes = collect($newOrder)->map(function ($item) {
            return $this->notes[$item['asset']];
        })->toArray();

        $this->notes = $orderedNotes;
        $this->updateOrder();
    }

    private function updateOrder()
    {
        foreach ($this->notes as $index => $note) {
            $this->notes[$index]['arrange'] = $index;
        }
    }

    public function save()
    {
        \Log::info('Saving notes:', $this->notes);

        $this->validate();

        $user = Auth::user();

        foreach ($this->notes as $note) {
            Note::updateOrCreate(
                [
                    'contact_id' => $user->id,
                    'property' => $note['property']
                ],
                [
                    'asset' => $note['asset'],
                    'arrange' => $note['arrange']
                ]
            );
        }

        $this->emit('notesSaved');
    }

    public function render()
    {
        return view('livewire.notes-form');
    }
}
