<?php
/** @var \AndreaMarelli\ModularForms\Models\Form $item */
/** @var string $url */

    $validationErrors = $item->validateFormRules();
    $validationErrors = [
        ['step' => 'step1', 'title' => 'hello world']
    ];

?>
<div id="form_global_errors_bar">

     <div class="module-errors" v-show="has_errors">
        <div class="title">
            <div>
                <i class="fas fa-2x fa-exclamation-triangle"></i>
            </div>
            <div>
                {!! ucfirst(trans('modular-forms::common.form.global_errors')) !!}
            </div>
        </div>
        <ul class="errors">
            <li v-for="error in validation_errors">
                Module <a :href="'{{ $url }}/'+ error.step">@{{ error.title }}</a>
            </li>
        </ul>
    </div>

</div>

@push('scripts')
    <script type="module">

        (new window.ModularForms.ErrorsApp(
            {initial_errors: @json($validationErrors)}
        ))
            .mount('#form_global_errors_bar');

    </script>
@endpush
