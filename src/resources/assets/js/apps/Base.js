import {createApp} from 'vue';
import tooltip from "../templates/tooltip.vue";

export default class Base {

    constructor(options, input_data) {
        const app = createApp(
            options || {},
            input_data || {}
        );

        // Register components
        app.component('tooltip', tooltip);

        return app;
    }

}
