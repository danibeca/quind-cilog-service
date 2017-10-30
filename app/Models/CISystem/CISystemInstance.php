<?php

namespace App\Models\CISystem;

use Illuminate\Database\Eloquent\Model;


class CISystemInstance extends Model
{

    protected $table = 'ci_system_instances';

    public function cISystem()
    {
        return $this->belongsTo('\App\Models\ContinuousIntegrationSystem\CISystem', 'ci_system_id');
    }

    public static function verify($url, $username, $password)
    {
        return true;
    }
}
