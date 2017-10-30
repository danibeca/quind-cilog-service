<?php

namespace App\Models\ContinuousIntegrationSystem;

use App\Models\Component\Component;
use Illuminate\Database\Eloquent\Model;


class ContinuousIntegrationSystemInstance extends Model
{

    public function continuousIntegrationSystem()
    {
        return $this->belongsTo('\App\Models\ContinuousIntegrationSystem\ContinuousIntegrationSystem', 'ci_system_id');
    }

    public static function verify($url, $username, $password)
    {
        return true;
    }
}
