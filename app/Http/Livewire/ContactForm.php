<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ContactForm extends Component
{
    public $name = '';
    public $email = '';
    public $message = '';
    public $showModal = false;

    protected $listeners = ['openContactModal' => 'openModal'];

    protected $rules = [
        'name' => 'required|min:2',
        'email' => 'required|email',
        'message' => 'required|min:10',
    ];

    public function openModal()
    {
        $this->showModal = true;
    }

    public function submit()
    {
        $this->validate();


        //success message
        $this->emit('contactFormSubmitted');

        $this->resetForm();
        $this->showModal = false;
    }

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->message = '';
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
