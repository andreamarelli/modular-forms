<template>

    <div>
        <span :class="[compact ? 'compact' : '', 'red-list_'+category]">
            {{ category }}
        </span>
        <tooltip
            :content=category_plain
        />
    </div>

</template>


<script>

    export default {

        data: function () {
            return {
                Locale: window.Locale
            }
        },

        props: {
            category: {
                type: String,
                default: null
            },
            compact:{
                type: Boolean,
                default: false
            }
        },

        computed: {
            category_plain(){
                return Locale.getLabel('modular-forms::entities.biodiversity.red_list_categories.'+this.category)
            }
        }

    }

</script>
