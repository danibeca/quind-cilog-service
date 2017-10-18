<?php

namespace App\Models\Component;

use App\Utils\Helpers\NodeTraitExt;
use Illuminate\Database\Eloquent\Model;

class ComponentTree extends Model
{
    use NodeTraitExt;

    public function getRoot()
    {
        if(is_null($this->parent_id)){
            return $this;
        }

        return Component::from('components')
            ->where('_lft', '<', $this->_lft)
            ->where('_rgt', '>', $this->_rgt)
            ->whereNull('parent_id')->get()->first;
    }

}
