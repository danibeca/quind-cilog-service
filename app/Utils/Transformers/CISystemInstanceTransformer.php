<?php

namespace App\Utils\Transformers;


class CISystemInstanceTransformer extends Transformer
{

    public function transform($instance)
    {
        return [
            'id' => $instance['id'],
            'name'  => $instance['c_i_system']['name'],
            'url_build_server'  => $instance['url_build_server'],
            'username_build_server'  => $instance['username_build_server'],
            'url_release_manager'  => $instance['url_release_manager'],
            'username_release_manager'  => $instance['username_release_manager'],
            'type'  => $instance['type'],
            'ci_system_id' => $instance['type'],
            'verified' =>$instance['verified'],
            'component_owner_id' =>$instance['component_owner_id']
        ];

        return $instance;
    }
}