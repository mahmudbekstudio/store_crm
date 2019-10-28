<template>
    <div class="alert-dialog">
        <Dialog
                :show="show"
                @onOpen="opened"
                @onClose="closed"
                :max-width="500"
        >
            <template slot="title">Alert</template>
            <slot></slot>
        </Dialog>
    </div>
</template>
<script>
    import Dialog from './dialog';
    export default {
        props: {
            show: {
                type: Boolean,
                default: false
            }
        },
        methods: {
            opened: function () {
                this.$emit('onOpen');
            },
            closed: function () {
                this.$emit('onClose');
            }
        },
        components: {
            Dialog
        }
    }
</script>
<style scoped lang="scss">
    .alert-dialog {}
</style>