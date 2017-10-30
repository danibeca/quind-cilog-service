<?php

namespace App\Utils\Transformers;


class SecureComponentTransformer extends Transformer
{

    public function transform($component)
    {
        return [
            'id'                      => $component['id'],
            'jobsPath'                => $component['job_path'],
            'urlBuildServer'          => $component['c_i_system_instance']['url_build_server'],
            'urlReleaseManager'       => $component['c_i_system_instance']['url_release_manager'],
            'usernameBuildServer'     => $component['c_i_system_instance']['username_build_server'],
            'tokenBuildServer'        => $component['c_i_system_instance']['password_build_server'],
            'usernameReleaseManager'  => $component['c_i_system_instance']['username_release_manager'],
            'tokenReleaseManager'     => $component['c_i_system_instance']['password_release_manager'],
            'name'                    => $component['app_code'],
            'appClassifierExpression' => $component['classifier_expression']
        ];

        return $component;
    }
}