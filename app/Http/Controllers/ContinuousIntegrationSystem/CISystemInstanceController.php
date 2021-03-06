<?php

namespace App\Http\Controllers\ContinuousIntegrationSystem;


use App\Http\Controllers\ApiController;
use App\Models\APIClient\APIClient;
use App\Models\CISystem\CISystemInstance;
use App\Models\Component\Component;
use App\Utils\Transformers\CISystemInstanceTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CISystemInstanceController extends ApiController
{


    public function index()
    {
        $result = collect();
        if (Input::has('component_id'))
        {
            return $this->respondData((new CISystemInstanceTransformer())
                ->transformCollection(
                    CISystemInstance::with('cISystem')->where('component_owner_id', Input::get('component_id'))->get()
                        ->toArray()));
        }
    }


    public function store(Request $request)
    {
        $verified = ($request->has('verified')) ? $request->verified : false;
        $cisi = new CISystemInstance();
        $cisi->ci_system_id = $request->ci_system_id;
        $cisi->url_build_server = $request->url_build_server;
        $cisi->url_release_manager = $request->url_release_manager;
        $cisi->type = $request->type;
        $cisi->verified = $verified;
        $cisi->component_owner_id = $request->component_owner_id;
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


    public function update(Request $request, $id)
    {
        $cisi = CISystemInstance::find($id);
        if (isset($cisi))
        {
            $verified = ($request->has('verified')) ? $request->verified : false;
            $cisi->ci_system_id = $request->ci_system_id;
            $cisi->url_build_server = $request->url_build_server;
            $cisi->url_release_manager = $request->url_release_manager;
            $cisi->type = $request->type;
            $cisi->verified = $verified;
            $cisi->component_owner_id = $request->component_owner_id;
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
            $this->updateRun($request->component_owner_id);

            return $this->respond('OK');
        }

        return $this->respondNotFound();

    }

    public function verify()
    {
        //return $this->respond(QualitySystemInstance::verify(Input::get('url'), Input::get('username'), Input::get('password')));
        return $this->respond(true);
    }


    public function updateRun($componentId)
    {
        $root = Component::find($componentId);

        if ($root)
        {
            if ($root->run_client === 2 || $root->run_quind === 2 || $root->run_quind === 1)
            {
                $root->run_client = 3;
            } else
            {
                $root->run_client = 1;
            }

            $root->save();
        }
    }


}
