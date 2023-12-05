<floatingDialog>
    <template slot="dialog-anchor">
        <x-modular-forms::button.generic class="small red"
                                         :text="AndreaMarelli\ModularForms\Helpers\Template::icon('trash')"
                                         :tooltip="ucfirst(trans('modular-forms::common.delete'))"
        ></x-modular-forms::button.generic>
    </template>
    <template slot="dialog-content">

        <div class="with_header_and_footer">
            <div class="header">
                @lang('modular-forms::common.confirm_deletion')
            </div>
            <div class="body">

            </div>
            <div class="footer">
                <x-modular-forms::button.generic role="closeDialog" class="green"
                                                 :text="ucfirst(trans('modular-forms::common.cancel'))"
                ></x-modular-forms::button.generic>
                <x-modular-forms::button.form.destroy class="red" :controller="$controller" :item="$item"
                                                      :text="\AndreaMarelli\ModularForms\Helpers\Template::icon('trash', 'white') . ' ' . ucfirst(trans('modular-forms::common.confirm'))"
                ></x-modular-forms::button.form.destroy>
            </div>
        </div>

    </template>
</floatingDialog>
