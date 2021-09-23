<?php

namespace App\Http\Livewire;

use App\Models\Provider;
use Livewire\Component;

class ProviderSearchBar extends Component
{
    public $provider;

    public function render()
    {
        $providers = Provider::where('id', 'LIKE', '%' . $this->provider)
            ->orWhere('last_name', 'LIKE', '%' . $this->provider . '%')
            ->orWhere('first_name', 'LIKE', '%' . $this->provider . '%')
            ->orWhere('father_name', 'LIKE', '%' . $this->provider . '%')
            ->select('id', 'last_name', 'first_name', 'father_name')
            ->paginate(15);

        return view('livewire.provider-search-bar')
            ->with('providers', $providers);
    }
}
