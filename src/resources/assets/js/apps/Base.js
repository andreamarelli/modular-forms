import {createApp} from "vue";
import tooltip from "../templates/tooltip.vue";
import dialogBox from "../templates/dialog_box.vue";
import dropdown from "../inputs/dropdown.vue";

export default class Base {

    constructor(options, input_data) {
        const app = createApp(
            options || {},
            input_data || {}
        );

        // Register components
        app.component('tooltip', tooltip);
        app.component('dialogBox', dialogBox);
        app.component('dropdown', dropdown);

        return app;
    }

}
