<?php

namespace App\Http\Livewire\Team;

use App\Models\Team;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Form extends Component
{
    public Team $team;
    protected $rules = [
        'team.name' => 'required|min:3|max:255',
        'team.description' => 'nullable|min:3|max:255',
    ];
    protected $validationAttributes = [
        'team.name' => 'name',
        'team.description' => 'description',
    ];
    public function mount()
    {
        $this->team = session('currentTeam');
    }
    public function submit()
    {
        $this->validate();
        try {
            $this->team->save();
            session(['currentTeam' => $this->team]);
            $this->emit('reloadWindow');
        } catch (\Throwable $th) {
            return general_error_handler($th, $this);
        }
    }
}