<?php


namespace App\Models\ProcessPhase;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class PhaseJob extends Model
{


    public function evaluate($value)
    {
        $result = false;
        foreach (explode(';', $this->regular_expression) as $re)
        {
            if (preg_match('/'.$re.'/', $value))
            {
                $result = true;
            }
        }

        return $result;
    }


}