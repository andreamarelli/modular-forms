<?php
/** @var Mixed $definitions */

?>

@if(array_key_exists('enable_preload', $definitions) && $definitions['enable_preload']===true)

    <floating_dialog>

        <template slot="dialog-anchor">

            <button type="button" class="btn-nav small dontOpenDialog" onclick="openPreloadDialog()">
                @uclang('modular-forms::common.form.previous_years')
            </button>
            <tooltip>
                @uclang('modular-forms::common.form.previous_years')
            </tooltip>

        </template>

        <template slot="dialog-content">

            <div class="with_header_and_footer">

                <!-- dialog header -->
                <div class="header">
                    <div>
                        @uclang('modular-forms::common.form.preload')
                        <br />
                        <b>{{ $definitions['module_code'] }} - {{ $definitions['module_title'] }}</b>
                    </div>
                    <button type="button" class="close" onclick=closeDialog()><i class="fa fa-times black"></i></button>
                </div>

                <!-- dialog body -->
                <div class="body text-center">
                    <div class="preload_container"></div>
                </div>

            </div>

        </template>
    </floating_dialog>
@endif
