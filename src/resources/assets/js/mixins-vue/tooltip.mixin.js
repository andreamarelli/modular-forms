export default {

    data (){
        return {
            tooltipEnabled: false,
        }
    },

    methods:{

        addTooltip: function(){
            let _this = this;
            if(this.tooltipEnabled && this.value!==null){

                // $(this.container).tooltip({
                //     title: _this.value,
                //     trigger: 'hover'
                // });

                // Create tooltip DOM node and append in (in #tooltips_stack)
                let tooltip_id = 'tooltip_' + this.id;
                let tooltip_dom = document.createElement("div");
                tooltip_dom.setAttribute('id', tooltip_id);
                tooltip_dom.setAttribute('role', 'tooltip');
                // tooltip_dom.classList.add('tooltip');
                tooltip_dom.appendChild(document.createTextNode(this.value));
                document.querySelector('#tooltips_stack').appendChild(tooltip_dom);

                console.log(this.container, document.querySelector('#' + tooltip_id));


                window.Popper(this.container, document.querySelector('#' + tooltip_id), {
                    placement: 'top',
                });
            }
        },

        updateTooltip: function (value) {
            $(this.container).attr('data-original-title', value);
        },

    },

    watch: {
        value () {
            if(this.tooltipEnabled){
                this.updateTooltip(this.value);
            }
        }
    }
}
