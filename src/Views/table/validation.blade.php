<div v-if="item.valid===false"
           data-toggle="tooltip" data-placement="top" data-original-title="{{ ucfirst(trans('common.form_error')) }}">
    <i class="fas fa-exclamation-triangle contextual_danger fa-2x"></i>
</div>