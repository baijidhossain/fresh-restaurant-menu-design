<?php

namespace App\Http\Livewire;

use App\Models\SocialLink;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SocialLinksForm extends Component
{
    public $socialLinks = [];

    protected $rules = [
        'socialLinks.*.key' => 'required',
        'socialLinks.*.value' => 'required',
    ];

    public function mount($initialLinks)
    {
        $this->socialLinks = collect($initialLinks)->map(function ($link, $index) {
            return array_merge($link, ['order' => $index]);
        })->toArray();
    }

    public function addLink()
    {
        $this->socialLinks[] = [
            'key' => '',
            'value' => '',
            'order' => count($this->socialLinks)
        ];
    }

    public function removeLink($index)
    {
        unset($this->socialLinks[$index]);
        $this->socialLinks = array_values($this->socialLinks);
        $this->updateOrder();
    }

    public function updateLinkOrder($newOrder)
    {
        $orderedLinks = collect($newOrder)->map(function ($item) {
            return $this->socialLinks[$item['value']];
        })->toArray();

        $this->socialLinks = $orderedLinks;
        $this->updateOrder();
    }

    private function updateOrder()
    {
        foreach ($this->socialLinks as $index => $link) {
            $this->socialLinks[$index]['order'] = $index;
        }
    }

    public function save()
    {
        $this->validate();

        $user = Auth::user();

        foreach ($this->socialLinks as $link) {
            SocialLink::updateOrCreate(
                [
                    'contact_id' => $user->id,
                    'key' => $link['key']
                ],
                [
                    'value' => $link['value'],
                    'order' => $link['order']
                ]
            );
        }

        $this->emit('socialLinksSaved');
    }

    public function render()
    {
        return view('livewire.social-links-form', [
            'buttons' => SocialLink::$buttons,
        ]);
    }
}
