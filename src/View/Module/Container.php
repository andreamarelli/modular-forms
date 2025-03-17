<?php

namespace ModularForms\View\Module;

use ModularForms\Enums\ModuleViewModes;
use ModularForms\Helpers\ModuleKey;
use ModularForms\Models\Module;
use ModularForms\View\Module\Components\Actions;
use ModularForms\View\Module\Components\Bars;
use ModularForms\View\Module\Components\LastUpdate;
use ModularForms\View\Module\Components\Observations;
use ModularForms\View\Module\Components\Script;
use ModularForms\View\Module\Components\Title;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\View\View;
use ReflectionException;

class Container extends Component
{
    public Collection $collection;
    public array $records;
    public array $definitions;
    public array $vueData;
    public bool $noData = false;
    public ?string $custom_view_name;
    public ?array $last_update;

    public string $title_view = Title::class;
    public string $info_bar_view = Bars\Info::class;
    public string $action_bar_view = Bars\Action::class;
    public string $last_update_view = LastUpdate::class;
    public string $not_applicable_view = Actions\NotApplicable::class;
    public string $custom_action_view = Actions\Custom::class;
    public string $observations_view = Observations::class;
    public string $script_view = Script::class;

    /**
     * @throws ReflectionException
     */
    public function __construct(
         public string $controller,
         public string $module,
         public ?int $formId,
         public string $mode
    ) {
        /** @var Module $module */

        $this->collection = $module::getModule($formId);
        $this->records = $module::getModuleRecords($formId,  $this->collection);
        $this->definitions = $module::getDefinitions($formId);
        $this->vueData = $module::getVueData($formId, $this->records, $this->definitions);

        $this->last_update = $this->records['last_update'];

        $this->records = $this->records['records'];
        $this->controller = Str::startsWith($controller, 'App\Http')
            ? '\\'.$controller
            : $controller;
        $this->custom_view_name = ModuleKey::KeyToView($this->definitions['module_key'], $this->mode);
        $this->vueData['action_url'] = $mode!==ModuleViewModes::SHOW && $mode!==ModuleViewModes::PRINT
            ? action([$controller, $formId!==null ? 'update' : 'store'], [$formId])
            : null;

        if($this->collection->isEmpty()){
            $this->noData = true;
            $this->collection = Collection::make([new $module()]);
        }
    }

    public function render(): View
    {
        if($this->mode === ModuleViewModes::EDIT){
            return view('modular-forms::module.edit.container');
        } else {
            return view('modular-forms::module.show.container');
        }

    }
}
