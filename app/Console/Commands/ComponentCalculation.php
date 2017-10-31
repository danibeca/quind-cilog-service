<?php

namespace App\Console\Commands;


use App\Models\Component\Component;
use App\Models\Component\ComponentTree;
use App\Models\Component\JobIndicatorValue;
use App\Utils\Models\Language\SelectedLanguage;
use App\Utils\Wrapper\HTTPWrapper;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;


class ComponentCalculation extends Command
{


    protected $signature = 'component:calculate';
    protected $description = 'Calculate component CI indicators';
    protected $accounts;

    public function handle()
    {


        App::singleton(SelectedLanguage::class);
        $instance = App::make(SelectedLanguage::class);
        $instance->setLanguageId(1);

        $qastaURL = env('QASTA_ENDPOINT');

        $mainComponentIds = Component::
        whereIn('id', ComponentTree::getRoots()->pluck('component_id'))
            ->Where(function ($query) {
                $query->where('run_quind', 1)
                    ->orWhere('last_run_quind', '<=', Carbon::now()->subHours(12));
            })->get()->pluck('id');

        Log::info(json_encode($mainComponentIds));
        foreach ($mainComponentIds as $mainComponentId)
        {

            /** @var ComponentTree $node */
            $node = ComponentTree::where('component_id', $mainComponentId)->get()->first();

            $root = Component::find($mainComponentId);
            $root->run_quind = 2;
            $root->save();

            $ids = $node->getDescendants()->pluck('component_id');
            $analyzableComponents = Component::whereIn('id', $ids)->get();
            $analyzableComponents = $analyzableComponents->push($root);


            /** @var Component $analyzableComponent */
            foreach ($analyzableComponents->sortByDesc('type_id') as $analyzableComponent)
            {
                $this->sendIndicators($root, $analyzableComponent, $qastaURL);

            }

            $root->last_run_quind = Carbon::now();
            $root->run_quind = 0;
            if ($root->run_client === 3)
            {
                $root->run_client = 1;
            }
            $root->save();

        }


    }

    public function sendIndicators(Component $root, Component $analyzableComponent, $qastaURL)
    {

        $analyzableComponent->calculateJobIndicator($root);

        $indValue = JobIndicatorValue::where('phase_id', 0)->where('component_id', $analyzableComponent->id)->get()->first();
        $values = JobIndicatorValue::where('phase_id', '!=', 0)->where('component_id', $analyzableComponent->id)->get();
        $jobIndicatorValueService = '/components/' . $analyzableComponent->id . '/ci-indicator-values';
        $jobAutomationValueService = '/components/' . $analyzableComponent->id . '/ci-automation-values';
        $indValue->ci_indicator_id = 1;

        $wrapper = new HTTPWrapper();
        $wrapper->post($qastaURL . $jobIndicatorValueService, $indValue);
        $wrapper->post($qastaURL . $jobAutomationValueService, $values);
    }


}
