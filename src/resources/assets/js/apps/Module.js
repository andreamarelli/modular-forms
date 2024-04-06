import {createApp} from "vue";
import {createPinia} from "pinia";
import tooltip from "../templates/tooltip.vue";

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
            }

        };

        // Create the app
        const app = createApp(options, input_data);

        // Register components
        app.component('tooltip', tooltip);

        return app
            .use(createPinia());
    }

}
