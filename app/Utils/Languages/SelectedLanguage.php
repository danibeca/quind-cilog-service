<?php


namespace App\Utils\Models\Language;


class SelectedLanguage
{

    public function __construct()
    {

    }

    private $languageId;

    public function setLanguageId($id)
    {
        $this->languageId = $id;
    }

    public function getLanguageId()
    {
        return $this->languageId;
    }
}