@props(['$title'])

<div class="accordion-item">

    <div class="accordion-item-header">
        <div class="accordion-item-header-title" onclick="window.ModularForms.Mixins.Accordion.toggle(event)">
            {{ $title }}
        </div>
    </div>

    <div class="accordion-item-body">
        <div class="accordion-item-body-content">
            {{ $slot }}
        </div>
    </div>

</div>
