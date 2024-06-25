<template>

    <div>
        <span :class="[compact ? 'compact' : '', 'red-list_'+category]">
            {{ category }}
        </span>
        <tooltip>
            {{ category_plain }}
        </tooltip>
    </div>

</template>


<script setup>

    import {defineProps} from "vue";

    const Locale = window.ModularForms.Mixins.Locale;

    const props = defineProps({
        category: {
            type: String,
            default: null
        },
        compact:{
            type: Boolean,
            default: false
        }
    });

    const category_plain = Locale.getLabel('modular-forms::entities.biodiversity.red_list_categories.'+props.category)

</script>
