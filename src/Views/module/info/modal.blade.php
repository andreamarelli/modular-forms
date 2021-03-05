<?php
/** @var Mixed $definitions */

?>

@if($definitions['module_info']!==null)

    @if($definitions['module_info_type']==='modal')

        {{-- modal anchor --}}
        <span data-toggle="modal" data-target="#info_popup_{{ $definitions['module_key'] }}"
              class="module-info_modal-anchor fa-stack">
            <i class="fa fa-circle fa-2x fa-stack-1x"></i>
            <i class="fa fa-info-circle fa-stack-2x contextual_info"></i>
        </span>

        <!-- Modal -->
        <div id="info_popup_{{ $definitions['module_key'] }}" class="module-info_modal modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <span class="fa fa-fw fa-info-circle contextual_info"></span>
                            {{ $definitions['module_code'] }} - {{ $definitions['module_title'] }}
                        </h5>
                    </div>
                    <div class="modal-body">
                        <span>{{ $definitions['module_info'] }}</span>
                    </div>
                </div>
            </div>
        </div>

    @endif

@endif
