import {
    createApp,
    ref,
    unref,
    computed,
    onMounted,
    toRaw,
    watch,
    reactive,
    onBeforeMount,
    getCurrentInstance,
    nextTick
} from "vue";
import {createPinia} from "pinia";

// Components
import tooltip from "../templates/tooltip.vue";
import dialogBox from "../templates/dialog_box.vue";

// Input Components
import simpleText from "../inputs/simple-text.vue";
import simpleTextarea from "../inputs/simple-textarea.vue";
import simpleUrl from "../inputs/simple-url.vue";
import simpleEmail from "../inputs/simple-email.vue";
import rating from "../inputs/rating.vue";
import dropdown from "../inputs/dropdown.vue";
import simpleDate from "../inputs/simple-date.vue";
import simpleNumeric from "../inputs/simple-numeric.vue";
import toggle from "../inputs/toggle.vue";
import checkbox from "../inputs/checkbox.vue";
import selectorSpeciesAnimal from "../inputs/selector-species_animal.vue";
import uploadFile from "../inputs/upload.vue";
import textEditor from "../inputs/text-editor.vue";

// Composables and Stores
import {useFormStore} from "../stores/FormStore.js";
import {useDataStatus} from "./composables/module.data_status.js";
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
                warning_on_save: String,
                action_url: String
            },

            setup(props, context) {

                let container = null;

                // Define ref/reactive and local variables
                let records = reactive(props.records);
                let records_backup = JSON.parse(JSON.stringify(toRaw(records)));
                let status = ref('init'); // "init" state avoid watch() on records during initialization
                let empty_record = props.empty_record;
                let last_update = props.last_update;

                // Inject common fields values into empty record
                Object.keys(empty_record).forEach(function (key) {
                    if(props.common_fields.map((f => f['name'])).includes(key)) {
                        empty_record[key] = records[0][key];
                    }
                });

                // import Composables
                const {accordionTitle, recordIsInGroup, numRecordsInGroup, addItem, deleteItem} = useArrangeRecords({
                    module_type: unref(props.module_type),
                    group_key_field: unref(props.group_key_field),
                    accordion_title_field: unref(props.accordion_title_field),
                    records: unref(records),
                    empty_record: unref(empty_record)
                });
                const {initialize: initializeDataStatus, isNotApplicable, isNotAvailable, toggle: toggleDataStatus } = useDataStatus({
                    enable_not_applicable: props.enable_not_applicable,
                    empty_record: empty_record,
                    records: records
                });
                const {
                    reset: resetModule,
                    save: saveModule,
                    error_messages,
                    recordChangedCallback,
                    mountedCallback,
                    resetModuleCallback,
                    saveModuleDoneCallback,
                    saveModuleFailCallback,
                    saveModuleAlwaysCallback
                } = useSave({
                    records: records,
                    records_backup: records_backup,
                    status: status,
                    last_update: last_update,
                    form_id: unref(props.form_id),
                    module_key: unref(props.module_key),
                    action_url: props.action_url,
                });

                // Set initial status (former vue2 "created" lifecycle hook)
                initializeDataStatus();

                // Watch for changes in records
                watch(records, (value) => {
                    console.log('records changed');
                    if (status.value !== 'init') {
                        status.value = status.value !== 'changed' ? 'changed' : status.value;
                    }
                });

                onMounted(() => {

                    status.value = 'idle';

                    const instance = getCurrentInstance();
                    nextTick().then(() => {
                        container = instance.appContext.app._container;
                        console.log(instance);
                        console.log(instance.appContext.app);
                        console.log(container);
                        console.log(container.querySelector('.module-body'));

                        console.log('-- context --');
                        console.log(context);
                        console.log(context.slots);
                        console.log('--------------');
                    });

                });

                // #################################################
                // ##################   Methods   ##################
                // #################################################

                function toggleNotApplicable(){
                    toggleDataStatus('not_applicable');
                }

                function toggleNotAvailable(){
                    toggleDataStatus('not_available');
                }


                return {
                    status,
                    records,
                    last_update,
                    error_messages,

                    // objects from or related to composables
                    isNotApplicable,
                    isNotAvailable,
                    toggleNotAvailable,
                    toggleNotApplicable,
                    saveModule,
                    resetModule,
                    recordIsInGroup,
                    numRecordsInGroup,
                    accordionTitle,
                    addItem,
                    deleteItem,

                    // TODO: review
                    recordChangedCallback,
                    mountedCallback,
                    resetModuleCallback,
                    saveModuleDoneCallback,
                    saveModuleFailCallback,
                    saveModuleAlwaysCallback,

                    // TODO: remove
                    records_backup
                }
            }
        };

        // Create the app
        return this.createApp(options, input_data);
    }

    /**
     * Create the app
     * @param options
     * @param input_data
     * @returns {*}
     */
    createApp(options, input_data) {

        return createApp(options, input_data)

            // register common components
            .component('tooltip', tooltip)
            .component('dialogBox', dialogBox)

            // register input components
            .component('simpleText', simpleText)
            .component('simpleTextarea', simpleTextarea)
            .component('simpleUrl', simpleUrl)
            .component('simpleEmail', simpleEmail)
            .component('rating', rating)
            .component('dropdown', dropdown)
            .component('simpleDate', simpleDate)
            .component('simpleNumeric', simpleNumeric)
            .component('toggle', toggle)
            .component('checkbox', checkbox)
            .component('selector-species_animal', selectorSpeciesAnimal)
            .component('upload', uploadFile)
            .component('textEditor', textEditor)

            // use Pinia
            .use(createPinia());
    }


}
