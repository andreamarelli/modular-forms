<?php

namespace AndreaMarelli\ModularForms\View\Module;

use AndreaMarelli\ModularForms\Helpers\ModuleKey;
use AndreaMarelli\ModularForms\View\Module\Components\Actions\NotApplicable;
use AndreaMarelli\ModularForms\View\Module\Components\Actions\Observations;
use AndreaMarelli\ModularForms\View\Module\Components\Actions\PreLoadData;
use AndreaMarelli\ModularForms\View\Module\Components\Info;
use AndreaMarelli\ModularForms\View\Module\Components\LastUpdate;
use AndreaMarelli\ModularForms\View\Module\Components\Title;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\View\View;

class Container extends Component
{
    public Collection $collection;
    public array $records;
    public array $definitions;
    public array $vueData;
    public bool $noData = false;
    public ?string $default_model_view_name;
    public ?array $last_update;
    public ?array $validation;

    public const MODE_EDIT = 'edit';
    public const MODE_SHOW = 'show';
    public const MODE_PRINT = 'print';
    public const MODE_VALIDATE = 'validate';

    public string $title_view = Title::class;
    public string $info_view = Info::class;
    public string $last_update_view = LastUpdate::class;
    public string $not_applicable_view = NotApplicable::class;
    public string $preload_data_view = PreLoadData::class;
    public string $observations_view = Observations::class;

    /**
     * @throws \ReflectionException
     */
    public function __construct(
         public string $controller,
         public string $module,
         public int $formId,
         public string $mode
    ) {
        /** @var \AndreaMarelli\ModularForms\Models\Module $module */

        $this->collection = $module::getModule($formId);
        $this->records = $module::getModuleRecords($formId,  $this->collection);
        $this->definitions = $module::getDefinitions($formId);
        $this->vueData = $module::getVueData($formId, $this->records, $this->definitions);

        $this->last_update = $this->records['last_update'];
        $this->validation = $this->records['validation'] ?? null;

        $this->records = $this->records['records'];
        $this->controller = Str::startsWith($controller, 'App\Http')
            ? '\\'.$controller
            : $controller;
        $this->default_model_view_name = ModuleKey::KeyToView($this->definitions['module_key']);

        if($this->collection->isEmpty()){
            $this->noData = true;
            $this->collection = Collection::make([new $module()]);
        }
    }

    public function render(): View
    {
        if($this->mode === self::MODE_EDIT){
            return view('modular-forms::module.edit.container');
        } else {
            return view('modular-forms::module.show.container');
        }

    }
}
