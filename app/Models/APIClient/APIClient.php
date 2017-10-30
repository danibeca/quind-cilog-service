<?php

namespace App\Models\APIClient;


use Illuminate\Database\Eloquent\Model;

class APIClient extends Model
{
    protected $table = 'api_clients';


    public function cISystemInstance()
    {
        return  $this->hasMany('\App\Models\CISystem\CISystemInstance', 'api_client_id');
    }
}
