<template>

    <div role="tooltip">
        <slot></slot>
        <div class="arrow"></div>
    </div>

</template>

<style lang="scss" scoped>

[role=tooltip] {
    display: none;
    width: max-content;
    position: absolute;
    top: 0;
    left: 0;

    .arrow {
        position: absolute;
        width: 8px;
        height: 8px;
        transform: rotate(45deg);
    }

}

</style>

<script>
export default {

    props: {
        anchorElemId: {
            type: String,
            default: null
        },
        onHover: {
            type: Boolean,
            default: true
        },
    },

    data (){
        return {
            tooltipElem: null,
            arrowElem: null,
        }
    },

    mounted(){

        // retrieving elements
        this.anchorElem = this.anchorElemId!==null
            ? document.querySelector('#' + this.anchorElemId)
            : this.$el.previousElementSibling; // if ID is not provided it assumes the anchor is the previous sibling element in DOM

        this.tooltipElem = this.$el;
        this.arrowElem = this.$el.querySelector('.arrow');

        // set event listener to toggle tooltip
        if(this.onHover){
            this.enableHoverListeners();
        }

    },

    methods: {

        /**
         * set event listener to toggle tooltip
         */
        enableHoverListeners(){
            [
                ['mouseenter', this.showTooltip],
                ['mouseleave', this.hideTooltip],
                ['focus', this.hideTooltip],
                ['blur', this.hideTooltip],
            ].forEach(([event, listener]) => {
                this.anchorElem.addEventListener(event, listener);
            });
        },

        /**
         * Initialize FloatingUI tooltip
         */
        setTooltipPosition(){
            let _this = this;

            window.FloatingUI.autoUpdate(_this.anchorElem, _this.tooltipElem, () => {

                const arrowWidth = _this.arrowElem.offsetWidth;
                const floatingOffset = Math.sqrt(2 * arrowWidth ** 2) / 2;

                window.FloatingUI.computePosition(_this.anchorElem, _this.tooltipElem, {
                    placement: 'top',
                    middleware: [
                        window.FloatingUI.flip(),
                        window.FloatingUI.shift({
                            padding: 5
                        }),
                        window.FloatingUI.offset({
                            mainAxis: floatingOffset,
                        }),
                        window.FloatingUI.arrow({element: this.arrowElem})
                    ],
                })
                .then(({x, y, placement, middlewareData}) => {

                    // Assign position to tooltip
                    Object.assign(_this.tooltipElem.style, {
                        left: `${x}px`,
                        top: `${y}px`,
                    });

                    // Assign position to arrow
                    if (middlewareData.arrow) {
                        const { x, y } = middlewareData.arrow;
                        const staticSide = {
                            top: 'bottom',
                            right: 'left',
                            bottom: 'top',
                            left: 'right',
                        }[placement.split('-')[0]];
                        Object.assign(_this.arrowElem.style, {
                            left: x != null ? `${x}px` : '',
                            top: y != null ? `${y}px` : '',
                            right: '',
                            bottom: '',
                            [staticSide]: `${-_this.arrowElem.offsetWidth / 2}px`,
                        });
                    }

                });

            });

        },

        /**
         * Show tooltip
         */
        showTooltip() {
            let _this = this;
            this.tooltipElem.style.display = 'block';
            this.setTooltipPosition();
            setTimeout(function(){
                _this.hideTooltip();
            }, 10000);
        },

        /**
         * Hide tooltip
         */
        hideTooltip() {
            this.tooltipElem.style.display = '';
        }

    }

}
</script>
