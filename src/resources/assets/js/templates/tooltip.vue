<template>

    <div role="tooltip">
        <div class="tooltip-content">
            <slot></slot>
        </div>
        <div class="tooltip-arrow"></div>
    </div>

</template>

<style lang="scss" scoped>

[role=tooltip] {
    display: none;
    width: max-content;
    position: absolute;
    top: 0;
    left: 0;

    .tooltip-arrow {
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
        onClick: {
            type: Boolean,
            default: false
        },
    },

    data (){
        return {
            tooltipElem: null,
            arrowElem: null,
            isVisible: false,
        }
    },

    mounted(){

        // retrieving elements
        this.anchorElem = this.anchorElemId!==null
            ? document.querySelector('#' + this.anchorElemId)
            : this.$el.previousElementSibling; // if ID is not provided it assumes the anchor is the previous sibling element in DOM

        this.tooltipElem = this.$el;
        this.arrowElem = this.$el.querySelector('.tooltip-arrow');

        // set event listeners
        if(this.onClick){
            this.enableClickListeners();
        } else {
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

        enableClickListeners(){
            let _this = this;
            // toggle on anchor click
            this.anchorElem.addEventListener('click', this.isVisible ? this.hideTooltip : this.showTooltip);
            if(this.isVisible){
                // close on click outside tooltip
                document.addEventListener('click', function(evt){
                    let clickedElem = evt.target;
                    if(clickedElem.closest('.tooltip-content') == null){
                        _this.hideTooltip();
                    }
                });
            }
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
            let content = this.tooltipElem.querySelector('.tooltip-content').textContent.trim();
            if(content !== ''){
                this.tooltipElem.style.display = 'block';
                this.setTooltipPosition();
                this.isVisible = true;
                setTimeout(function(){
                    _this.hideTooltip();
                }, 10000);
            }
        },

        /**
         * Hide tooltip
         */
        hideTooltip() {
            this.tooltipElem.style.display = '';
            this.isVisible = false;
        }

    }

}
</script>
