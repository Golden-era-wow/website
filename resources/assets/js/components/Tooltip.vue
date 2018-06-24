<template>
    <span>
        <slot></slot>
    </span>
</template>

<script>
import Tooltip from 'tooltip.js'

export default {
    props: {
        value: {
            type: String,
            default: ""
        },

        trigger: {
            type: String,
            default: "hover"
        },

        position: {
            type: String,
            default: "Top"
        },

        visibleByDefault: {
            type: Boolean,
            default: false
        }
    },

    data () {
        return {
            instance: null
        }
    },

    mounted () {
        this.instance = new Tooltip(this.$el, {
            title: this.value,
            trigger: this.trigger,
            placement: this.position
        });

        if (this.visibleByDefault) {
            this.instance.show();
        }
    }
}
</script>

