import {createApp, ref, reactive, onMounted, inject} from 'vue';
import tooltip from "./templates/tooltip.vue";

export default class App{

    constructor() {
        const app = createApp({});

        // Register components
        app.component('tooltip', tooltip);

        return app;
    }

}
