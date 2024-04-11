import {createApp, ref, toRef, computed, onMounted, toRefs, toRaw, watch, reactive, nextTick} from "vue";
import {createPinia} from "pinia";

// Components
import tooltip from "../templates/tooltip.vue";
import simpleText from "../inputs/simple-text.vue";

// Composables and Stores
import {useFormStore} from "../stores/FormStore.js";
import {useDataStatus} from "./composables/module.data_status.js";
import {useTransitions} from "./composables/module.transitions.js";
import {useArrangeRecords} from "./composables/module.arrange_records.js";
import {useSave} from "./composables/module.save.js";

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
                enable_not_applicable: Boolean,
                warning_on_save: String
            },

            setup(props) {

                // refs / reactives / local variables
                let records = reactive(props.records);
                const records_backup = JSON.parse(JSON.stringify(toRaw(records)));
                const container = ref(null);
                let status = ref('init'); // "init" state avoid watch() on records during initialization
                let empty_record = props.empty_record;

                // Inject common fields values into empty record
                Object.keys(empty_record).forEach(function (key) {
                    if(props.common_fields.map((f => f['name'])).includes(key)) {
                        empty_record[key] = records[0][key];
                    }
                });

                // import Composables
                const {arrange_by_group} = useArrangeRecords({
                    module_type: props.module_type,
                    groups: props.groups,
                    group_key_field: props.group_key_field,
                    empty_record: empty_record,
                    records: records,
                });
                const {initialize: initializeDataStatus, isNotApplicable, isNotAvailable, toggle: toggleDataStatus } = useDataStatus({
                    enable_not_applicable: props.enable_not_applicable,
                    module_type: props.module_type,
                    groups: props.groups,
                    empty_record: empty_record,
                    records: records
                });
                const {beforeShowBar, showBar, hideBar} = useTransitions();
                // const { reset: resetModule, save: saveModule} = useSave();

                // Set initial status (formed "created" lifecycle hook)
                arrange_by_group();
                initializeDataStatus();

                // Watch for changes in records
                watch(records, (value) => {
                    if (status.value !== 'init') {
                        status.value = status.value !== 'changed' ? 'changed' : status.value;
                    }
                });

                onMounted(() => {

                    // await nextTick();
                    status.value = 'idle';
                });

                // #################################################
                // ##################   Methods   ##################
                // #################################################

                function resetModule(){
                    // Cannot replace entire reactive object with backup
                    // (https://vuejs.org/guide/essentials/reactivity-fundamentals.html#limitations-of-reactive)
                    // thus, need to iterate over each record and each field

                    // TODO: for GROUPS

                    let new_records = JSON.parse(JSON.stringify(records));
                    Object.entries(new_records).forEach(([index, record]) => {
                        Object.entries(record).forEach(([key, value]) => {
                            records[index][key] = records_backup[index][key];
                        });
                    });
                    status.value = 'idle';
                }
                function saveModule(){}

                function toggleNotApplicable(){
                    toggleDataStatus('not_applicable');
                }

                function toggleNotAvailable(){
                    toggleDataStatus('not_available');
                }

                function addItem(){}
                function deleteItem(){}




                return {
                    status,
                    records,

                    // objects from or related to  composables
                    isNotApplicable,
                    isNotAvailable,
                    toggleNotAvailable,
                    toggleNotApplicable,
                    saveModule,
                    resetModule,

                    beforeShowBar,
                    showBar,
                    hideBar,


                    addItem,
                    deleteItem,
                }
            }
        };


        // Create the app
        return createApp(options, input_data)
            // register components
            .component('tooltip', tooltip)
            .component('simpleText', simpleText)
            // use Pinia
            .use(createPinia());
    }

}
