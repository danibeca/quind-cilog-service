<?php

namespace App\Http\Controllers\ContinuousIntegrationSystem;


use App\Http\Controllers\ApiController;
use App\Models\APIClient\APIClient;
use App\Models\ContinuousIntegrationSystem\CISystemInstance;
use App\Utils\Transformers\QualitySystemInstanceTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CISystemInstanceController extends ApiController
{


  /*  public function index()
    {
        $result = collect();
        if (Input::has('component_id'))
        {
            return $this->respondData((new QualitySystemInstanceTransformer())
                ->transformCollection(
                    QualitySystemInstance::with('qualitySystem')->where('component_owner_id', Input::get('component_id'))->get()
                        ->toArray()));
        }
    }
*/
    /*public function show($instanceId)
    {

        $qa = QualitySystemInstance::find($instanceId);
        if (Input::has('resources'))
        {

            if (! is_null($qa))
            {
                //FIX THIS
                return $this->respondData($qa->getResources());
            } else
            {
                return $this->respondData([]);
            }

        }

        return $this->respondData($qa);

    }*/

    public function store(Request $request)
    {

        $verified = ($request->has('verified')) ? $request->verified : false;
        $cisi = new CISystemInstance();
        $cisi->ci_system_id = $request->ci_system_id;
        $cisi->url_build_server = $request->url_build_server;
        $cisi->url_release_manager = $request->url_release_manager;
        $cisi->type = $request->type;
        $cisi->verified = $verified;
        $cisi->component_owner_id = $request->component_id;
        if ($request->has('username_build_server'))
        {
            $cisi->username_build_server = $request->username_build_server;
            $cisi->password_build_server = $request->password_build_server;
        }

        if ($request->has('username_release_manager'))
        {
            $cisi->username_release_manager = $request->username_release_manager;
            $cisi->password_release_manager = $request->password_release_manager;
        }

        if ($request->type == 1)
        {
            $cisi->api_client_id = 1;
        } else
        {
            $newClient = new APIClient();
            $newClient->code = str_replace('/', '', password_hash($request->url . strtotime(date('Y-m-d H:i:s')), PASSWORD_BCRYPT));
            $newClient->save();
            $cisi->api_client_id = $newClient->id;
        }
        $cisi->save();

        return $this->respondResourceCreated();
    }


    /*public function update(Request $request, $id)
    {
        $qsi = QualitySystemInstance::find($id);
        if (isset($qsi))
        {
            $verified = ($request->has('verified')) ? $request->verified : false;
            $qsi->quality_system_id = $request->quality_system_id;
            $qsi->url = $request->url;
            $qsi->type = $request->type;
            $qsi->verified = $verified;

            if ($request->has('username'))
            {
                $qsi->username = $request->username;
                $qsi->password = $request->password;
            }

            if ($request->type == 1)
            {
                $qsi->api_client_id = 1;
            } else
            {
                $newClient = new APIClient();
                $newClient->code = password_hash('testing', PASSWORD_BCRYPT);
                $newClient->save();
                $qsi->api_client_id = $newClient->id;
            }

            $qsi->save();

            return $this->respond('OK');
        }

        return $this->respondNotFound();

    }*/

    public function verify()
    {
        //return $this->respond(QualitySystemInstance::verify(Input::get('url'), Input::get('username'), Input::get('password')));
        return true;
    }


}
