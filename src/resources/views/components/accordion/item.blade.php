<div {{ $attributes->merge(['class' => 'accordion-item']) }}>

    <div class="accordion-item-header">
        <div class="accordion-item-header-title" @if($isCollapsible) onclick="window.ModularForms.Mixins.Accordion.toggle(event)" @endif>
            {{ $title }}
        </div>
        <div>
            {{ $headerActions }}
        </div>
    </div>

    <div class="accordion-item-body">
        <div class="accordion-item-body-content">
            {{ $slot }}
        </div>
    </div>

</div>
