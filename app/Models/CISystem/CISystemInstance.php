<?php

namespace App\Models\ContinuousIntegrationSystem;

use Illuminate\Database\Eloquent\Model;


class CISystemInstance extends Model
{

    public function cISystem()
    {
        return $this->belongsTo('\App\Models\ContinuousIntegrationSystem\CISystem', 'ci_system_id');
    }

    public static function verify($url, $username, $password)
    {
        return true;
    }
}
