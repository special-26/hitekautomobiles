<?php

namespace App\Livewire\JobCards;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.job-cards.index')
            ->layout('components.layouts.management', [
                'title' => 'Job Cards',
            ]);
    }
}
