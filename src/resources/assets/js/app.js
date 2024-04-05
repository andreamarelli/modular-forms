import {createApp} from 'vue';
import tooltip from "./templates/tooltip.vue";

export default class App{

    constructor(options) {
        const app = createApp(options || {});

        // Register components
        app.component('tooltip', tooltip);

        return app;
    }

}
