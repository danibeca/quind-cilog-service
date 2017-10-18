<?php

namespace App\Utils\Models\Language;


trait NameAttribute {

    public function lrname(){
        return $this->belongsTo('App\Models\Language\Resource', 'lr_name','id');
    }

    public function getNameAttribute(){
        $resource = $this->lrname;
        $result =  is_null($resource) ? $this->tmpname : $resource->language->first()->pivot->translation;
        return $result;
    }

}