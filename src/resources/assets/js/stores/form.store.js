import { defineStore } from 'pinia'


export const useFormStore= defineStore('FormStore', {

    id: 'formStore',

    state: () => ({
        form_errors : [],
    }),

    getters: {},

    actions: {

        setInitialErrors(initial_errors){
            this.form_errors = initial_errors;
        },

        /**
         * Register an invalid module
         */
        registerInvalidModule: (module_error) => {
            this.form_errors.push(module_error);
        },

        /**
         * Register a module as fixed
         */
        registerFixedModule: (module_key) => {
            let _this = this;
            this.form_errors.forEach(function(item, index){
                if(item.key===module_key){
                    _this.form_errors.splice(index, 1);
                }
            });
        }

    }

})
