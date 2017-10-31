<?php


namespace App\Models\ProcessPhase;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class PhaseJob extends Model
{


    public function evaluate($value)
    {
        return preg_match($this->regular_expression, $value);
    }


}