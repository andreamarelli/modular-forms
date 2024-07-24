import {createApp, ref} from 'vue';
import tooltip from "../templates/tooltip.vue";
import dialogBox from "../templates/dialog_box.vue";
import destroyButton from "../components/destroyFormButton.vue";

export default class FormList {

    constructor(input_data = {}) {

        const options = {

            name: 'FormList',

        }

        const app = createApp(
            options || {},
            input_data || {}
        );

        // Register components
        app.component('tooltip', tooltip);
        app.component('dialogBox', dialogBox);
        app.component('destroyButton', destroyButton);

        return app;
    }

}
