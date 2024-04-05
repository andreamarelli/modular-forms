import {createApp, ref, computed, watch, onBeforeMount} from 'vue';

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

                // store: window.ModularForms.formStore

                const validation_errors = ref(props.initial_errors);

                let has_errors = computed(() => {
                    return Object.entries(validation_errors.value).length >= 1;
                })

                watch(validation_errors, () => {
                    displayNonValidModules();
                });

                onBeforeMount(() => {
                    // let _this = this;
                    // registerInitialErrors();
                    // this.validation_errors = this.$store.state.validator.validation_errors;
                    // window.vueBus.$on('refresh_validation', function (module_key) {
                    //     fixedError(module_key);
                    // });
                });

                /**
                 * Highlight module with errors
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
                 * Register initial errors
                 */
                function registerInitialErrors(){
                    // let _this = this;
                    // this.initial_errors.forEach(function (item) {
                    //     _this.$store.commit('validator/registerInvalidModule', item);
                    // });
                }

                /**
                 * Set a module as fixed
                 * @param module_key
                 */
                function fixedError(module_key){
                    // let invalid_modules = this.validation_errors.map(a => a.key);
                    // if(invalid_modules.includes(module_key)){
                    //     this.$store.commit('validator/registerFixedModule', module_key);
                    // }
                }

                return {
                    validation_errors,
                    has_errors
                };
            }

        }, input_data);
    }

}
