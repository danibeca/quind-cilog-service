<?php


namespace App\Models\ProcessPhase;


use Illuminate\Database\Eloquent\Model;

class ProcessPhase extends Model
{

    public function jobs()
    {
        return $this->hasMany('\App\Models\ProcessPhase\PhaseJob', 'process_phase_id');
    }

}