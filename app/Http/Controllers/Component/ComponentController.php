<?php

namespace App\Http\Controllers\Component;

use App\Http\Controllers\ApiController;
use App\Models\Component\Component;
use App\Models\Component\ComponentTree;
use App\Utils\Transformers\SimpleComponentTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class ComponentController extends ApiController
{

    public function index()
    {
        if (Input::has('parent_id'))
        {
            /** @var ComponentTree $node */
            $node = ComponentTree::where('component_id', Input::get('parent_id'))->get()->first();

            /** @var Component $parent */
            $parent = Component::find($node->component_id);
            $ids = $node->getDescendants()->pluck('component_id');
            /** @var Component $result */
            $result = Component::whereIn('id', $ids)->get();
            if (Input::has('self_included') && Input::get('self_included'))
            {
                $result = $result->push($parent);
            }

            if (Input::has('no_leaves'))
            {
                $result = $result->diff($parent->getLeaves());
            }

            if (Input::has('only_leaves'))
            {
                $result = Component::find(Input::get('parent_id'))->getLeaves();
            }

            return $this->respondData((new SimpleComponentTransformer())->transformCollection(array_values($result->sortBy('tag_id')->toArray())));
        }

        return $this->respondNotFound();
    }

    public function store(Request $request)
    {
        $newComponent = new Component ($request->except('parent_id'));
        $newComponent->save();
        $newComponentTree = new ComponentTree();
        if ($request->has('parent_id') && $request->type_id !== 1)
        {
            $newComponentTree->component_id = $newComponent->id;
            $newComponentTree->appendToNode(ComponentTree::where('component_id', $request->parent_id)->first())->save();

            /** @var Component $root */
            $root = Component::find(ComponentTree::where('component_id', $request->parent_id)
                ->get()->first()->getRoot()->component_id);
            if ($root->run_client === 2 || $root->run_quind === 2 || $root->run_quind === 1)
            {
                $root->run_client = 3;
            } else
            {
                $root->run_client = 1;
            }

            $root->save();

        } else
        {
            $newComponentTree->component_id = $newComponent->id;
            $newComponentTree->saveAsRoot();
        }

        ComponentTree::fixTree();


        return $this->respondResourceCreated();
    }


    public function update(Request $request, $id)
    {
        /** @var Component $component */
        $component = Component::find($id);
        /** @var ComponentTree $componentTree */
        $componentTree = ComponentTree::where('component_id', $component->id)->get()->first();
        if (! $componentTree->isRoot())
        {
            $component->update($request->all());
            if ($request->parent_id)
            {
                $componentTree->parent_id = $request->parent_id;
                $componentTree->save();
                ComponentTree::fixTree();
            }
        }

        return $this->respond('OK');
    }

    public function destroy($id)
    {
        /** @var Component $component */
        $component = Component::find($id);
        /** @var ComponentTree $componentTree */
        $componentTree = ComponentTree::where('component_id', $component->id)->get()->first();
        if (! $componentTree->isRoot())
        {
            Component::whereIn('id',$componentTree->getDescendants()->pluck('component_id'))->delete();
            Component::find($id)->delete();
            ComponentTree::fixTree();
        }

        return $this->respondResourceDeleted();
    }

}
