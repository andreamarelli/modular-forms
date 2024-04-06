import {createApp, ref, computed, watch, onBeforeMount} from 'vue';
import {createPinia} from "pinia";
import {useFormStore} from "../stores/form.store.js";

export default class ErrorsApp{

    constructor(input_data = {}) {

        const options = {

            props: {
                initial_errors: {
                    type: Object,
                    default: () => {}
                }
            },

            setup(props){

                // store: window.ModularForms.formStore

                const validation_errors = ref(props.initial_errors);

                let has_errors = computed(() => {
                    return Object.entries(validation_errors.value).length >= 1;
                })

                watch(validation_errors, () => {
                    displayNonValidModules();
                });

                onBeforeMount(() => {
                    // Register initial errors in FormStore
                    useFormStore().setInitialErrors(props.initial_errors);
                    // TODO: replace listener (maybe making a store variable reactive)
                    // window.vueBus.$on('refresh_validation', function (module_key) {
                    //     fixedError(module_key);
                    // });
                });

                /**
                 * Display errors (non valid modules)
                 */
                function displayNonValidModules(){
                    let error_class = 'validation-error';
                    let invalid_modules = validation_errors.value.map(a => 'module_'+a.key);
                    let containers = document.querySelectorAll('.module-container');
                    containers.forEach(function (container) {
                        if(invalid_modules.includes(container.id)){
                            if(!container.classList.contains(error_class)){
                                container.classList.add(error_class);
                            }
                        } else {
                            if(container.classList.contains(error_class)){
                                container.classList.remove(error_class);
                            }
                        }
                    });
                }

                /**
                 * Mark module as fixed
                 * @param module_key
                 */
                function fixedError(module_key){
                    let invalid_modules = validation_errors.value.map(a => a.key);
                    if(invalid_modules.includes(module_key)){
                        useFormStore().registerFixedModule(module_key);
                    }
                }

                return {
                    validation_errors,
                    has_errors
                };
            }

        };

        return createApp(options, input_data)
            .use(createPinia());
    }

}
