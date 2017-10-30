<?php

namespace App\Models\APIClient;


use Illuminate\Database\Eloquent\Model;

class APIClient extends Model
{
    protected $table = 'api_clients';


    public function continuousIntegrationSystemInstance()
    {
        return  $this->hasMany('\App\Models\ContinuousIntegrationSystem\ContinuousIntegrationSystemInstance', 'api_client_id');
    }
}
