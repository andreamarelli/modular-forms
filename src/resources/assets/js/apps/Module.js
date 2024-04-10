import {createApp, ref, toRef, computed, onMounted, toRefs, toRaw} from "vue";
import {createPinia} from "pinia";

import tooltip from "../templates/tooltip.vue"

import {useFormStore} from "../stores/FormStore.js";
import {useDataStatus} from "./composables/module.data_status.js";
import {useTransitions} from "./composables/module.transitions.js";
import {useArrangeRecords} from "./composables/module.arrange_records.js";

export default class Module {

    constructor(input_data = {}) {

        const options = {

            props: {
                module_key: String,
                module_type: String,
                common_fields: Object,
                groups: Object,
                group_key_field: String,
                predefined_values: Object,
                max_rows: Number,
                accordion_title_field: String,
                empty_record: Object,
                records: Object,
                last_update: Object,
                action: String,
                form_id: Number,
                enable_not_applicable: Boolean
            },

            setup(props) {

                // Make props reactive
                let empty_record = ref(props.empty_record);
                let records = ref(props.records);

                // Local refs/variables
                let status = ref('init'); // "init" state avoid watch() on records during initialization
                const records_backup = Object.assign({}, records.value);
                const container = ref(null);

                // import Composables
                const {common_fields_in_empty_record, arrange_by_group} = useArrangeRecords({
                    module_type: props.module_type,
                    common_fields: props.common_fields,
                    groups: props.groups,
                    group_key_field: props.group_key_field,
                    empty_record: empty_record,
                    records: records,
                });
                const {initialize: initializeDataStatus, isNotApplicable, isNotAvailable, toggle: toggleDataStatus } = useDataStatus({
                    enable_not_applicable: props.enable_not_applicable,
                    module_type: props.module_type,
                    common_fields: props.common_fields,
                    groups: props.groups,
                    empty_record: empty_record,
                    records: records,
                    arrange_by_group: arrange_by_group
                });
                const {beforeShowBar, showBar, hideBar} = useTransitions();

                // Set initial status (formed "created" lifecycle hook)
                empty_record.value = common_fields_in_empty_record();
                records.value = arrange_by_group();
                initializeDataStatus();


                // #################################################
                // ##################   Methods   ##################
                // #################################################

                function toggleNotApplicable(){
                    toggleDataStatus('not_applicable');
                }

                function toggleNotAvailable(){
                    toggleDataStatus('not_available');
                }

                function addItem(){}


                onMounted(() => {

                });

                return {
                    status,
                    records,
                    records_backup,

                    addItem,

                    // objects from or related to  composables
                    isNotApplicable,
                    isNotAvailable,
                    toggleNotAvailable,
                    toggleNotApplicable,
                    beforeShowBar,
                    showBar,
                    hideBar,
                }
            }
        };


        // Create the app
        return createApp(options, input_data)
            // register components
            .component('tooltip', tooltip)
            // use Pinia
            .use(createPinia());
    }

}
