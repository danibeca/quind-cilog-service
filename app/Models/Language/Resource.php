<?php


namespace App\Models\Language;


use App\Utils\Models\Language\SelectedLanguage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Resource extends Model
{

    protected $table = 'language_resources';

    public function language()
    {
        return $this->belongsToMany('App\Models\Language\Language', 'language_translations', 'resource_id')
            ->select(array('id'))
            ->withPivot('translation')
            ->where('language_id', '=', App::make(SelectedLanguage::class)->getLanguageId());
    }
}