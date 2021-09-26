<?php

namespace App\Http\Livewire;

use App\Models\Person;
use Livewire\Component;

class ClientSearchBar extends Component
{
    public $client;

    public function render()
    {
        $clients = Person::join('clients', 'clients.person_id', 'people.id')
            ->where('id', 'LIKE', '%' . $this->client)
            ->orWhere('last_name', 'LIKE', '%' . $this->client . '%')
            ->orWhere('first_name', 'LIKE', '%' . $this->client . '%')
            ->orWhere('father_name', 'LIKE', '%' . $this->client . '%')
            ->select('id', 'last_name', 'first_name', 'father_name')
            ->paginate(15);

        return view('livewire.client-search-bar')
            ->with('clients', $clients);
    }
}
