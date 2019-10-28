<template>
    <div class="confirm-dialog">
        <Dialog
                :show="show"
                @onOpen="opened"
                @onClose="closed"
                :max-width="600"
                :persistent="true"
                :close-btn="false"
        >
            <template slot="title">Confirm</template>
            <slot></slot>
            <template slot="actions">
                <v-btn
                        color="primary"
                        flat
                        @click="select(true)"
                >
                    Yes
                </v-btn>
                <v-btn
                        color="primary"
                        flat
                        @click="select(false)"
                >
                    No
                </v-btn>
            </template>
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
            },
            select: function (type) {
                this.$emit('onSelect', type);
            }
        },
        components: {
            Dialog
        }
    }
</script>
<style scoped lang="scss">
    .confirm-dialog {}
</style>