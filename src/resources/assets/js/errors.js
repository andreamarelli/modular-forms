import {createApp, ref, computed} from 'vue';

export default class ErrorsApp{

    constructor(input_data = {}) {
        return createApp({

            props: {
                initial_errors: {
                    type: Object,
                    default: () => {}
                }
            },

            setup(props){

                const validation_errors = ref(props.initial_errors);
                let has_errors = computed(() => {
                    return Object.entries(validation_errors.value).length >= 1;
                })

                return {
                    validation_errors,
                    has_errors
                };
            }

        }, input_data);
    }

}
