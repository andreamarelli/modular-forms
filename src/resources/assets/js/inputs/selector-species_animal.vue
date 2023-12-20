<template>

    <selectorDialog
        :parent-id=id
        :search-url=searchUrl
        :enable-free-text=enableFreeText
    >

        <!-- dialog anchor -->
        <template v-slot:selector-anchor>
            <div class="field-preview">
                {{ anchorLabel }}
            </div>
        </template>

        <!-- api search - result search filters -->
        <template v-slot:selector-api-search-result-filters>
            <i>{{ Locale.getLabel('modular-forms::common.filter_results') }}: </i>&nbsp;&nbsp;
            {{ Locale.getLabel('modular-forms::entities.biodiversity.taxonomy.class') }}
            <select v-model=filterByClass @change="filterList(true)" class="field-edit filterByClass">
                <option v-for="option in classes">
                    {{ option }}
                </option>
            </select>
            {{ Locale.getLabel('modular-forms::entities.biodiversity.taxonomy.order') }}
            <select v-model=filterByOrder @change="filterList(false)" class="field-edit filterByOrder">
                <option v-for="option in orderByClass()">
                    {{ option }}
                </option>
            </select>
        </template>

        <!-- api search - result header -->
        <template v-slot:selector-api-search-result-header>
            <th>{{ Locale.getLabel('modular-forms::entities.biodiversity.species', 1) }}</th>
            <th>{{ Locale.getLabel('modular-forms::entities.biodiversity.red_list_category') }}</th>
            <th>{{ Locale.getLabel('modular-forms::entities.biodiversity.red_list') }}</th>
        </template>

        <!-- api search - result items -->
        <template v-slot:selector-api-search-result-item="{ item }">
            <td><span class="result_left" v-html="getSpeciesDescription(item)"></span></td>
            <td><redlist_category :category=item.iucn_redlist_category></redlist_category></td>
            <td><a target="_blank" :href="'http://www.iucnredlist.org/details/'+item.iucn_redlist_id+'/0'"><img style="display: inline-block" :src="assetPath + 'images/iucn_red_list.png'" alt="IUCN RedList"/></a></td>
        </template>

    </selectorDialog>

</template>

<style lang="scss" scoped>
    .result_left{
        text-align: left;
    }
    .field-edit.filterByClass,
    .field-edit.filterByOrder{
        width: 200px;
        margin: 0 5px;
    }
</style>

<script>
export default {

    components: {
        'redlist_category': window.ModularForms.Template.redlist_category
    },

    mixins: [
        window.ModularForms.MixinsVue.values
    ],

    props: {
        searchUrl: {
            type: String,
            default: null
        },
        enableFreeText: {
            type: Boolean,
            default: false,
        },
    },

    data (){
        return {
            Locale: window.Locale,
            assetPath: window.ModularForms.assetPath,
            searchComponent: null,
            inputValue: null,
            filterByClass: null,
            filterByOrder: null,
            orders: [],
            classes: []
        }
    },

    computed:{
        anchorLabel(){
            if(this.inputValue!==null && typeof this.inputValue == "object"){
                return this.getScientificName(this.inputValue);
            } else if(this.value!==null && this.value.split("|").length>3){
                let taxonomy = this.value.split("|");
                return taxonomy[4] + ' ' + taxonomy[5]
            } else {
                return this.value;
            }
        }
    },

    mounted (){
        this.searchComponent = this.$children[0].$children[0].$children[0];
    },

    methods: {

        getScientificName(item) {
            return item.genus + ' ' + item.species;
        },

        getFullTaxonomy(item) {
            return item.phylum + '|' + item.class + '|' + item.order + '|' + item.family + '|' + item.genus + '|' + item.species
        },

        getSpeciesDescription(item) {
            let description = '<div>' + item.class + ' ' + item.order + ' ' + item.family + ' <b>' + item.genus + ' ' + item.species + '</b>' + '</div>';
            if (this.hasCommonNames(item)) {
                description += '<div class="common_names"><b><i>' + Locale.getLabel('modular-forms::entities.biodiversity.common_names') + ':</i></b><br />';
                if (item.common_name_en !== null && item.common_name_en.toLowerCase() !== 'null') {
                    description += '<div><span class="flag-icon flag-icon-gb"></span> ' + item.common_name_en.replace(/\,/g, ', ') + '</div>'
                }
                if (item.common_name_fr !== null && item.common_name_fr.toLowerCase() !== 'null') {
                    description += '<div><span class="flag-icon flag-icon-fr"></span> ' + item.common_name_fr.replace(/\,/g, ', ') + '</div>'
                }
                if (item.common_name_sp !== null && item.common_name_sp.toLowerCase() !== 'null') {
                    description += '<div><span class="flag-icon flag-icon-es"></span> ' + item.common_name_sp.replace(/\,/g, ', ') + '</div>'
                }
                description += '</div>';
            }
            return description;
        },

        hasCommonNames(item) {
            return (item.common_name_en !== null || item.common_name_fr !== null || item.common_name_sp !== null);
        },

        afterSearch(response){
            this.orders = response['data']['orders'];
            this.classes = response['data']['classes'];
            this.filterByOrder = null;
            this.filterByClass = null;
        },

        orderByClass(){
            return this.filterByClass!=null
                ? this.orders[this.filterByClass]
                : [];
        },

        filterList(alsoResetOrder){
            if(alsoResetOrder){
                this.filterByOrder = null;
            }
            this.filterByOrder = typeof this.filterByOrder === "undefined" ? null : this.filterByOrder;

            let filters = {
                'class': this.filterByClass,
                'order': this.filterByOrder,
            };
            this.searchComponent.filterShowList(filters);
        },

        getSelectedValue(value){
            return this.getFullTaxonomy(value);
        }

    }



}
</script>
