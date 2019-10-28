<template>
    <div class="dialog text-xs-center">
        <v-dialog
                v-model="showDialog"
                :attach="attach"
                :content-class="contentClass"
                :dark="dark"
                :disabled="disabled"
                :full-width="fullWidth"
                :fullscreen="fullscreen"
                :hide-overlay="hideOverlay"
                :lazy="lazy"
                :light="light"
                :max-width="maxWidth"
                :no-click-animation="noClickAnimation"
                :origin="origin"
                :persistent="persistent"
                :return-value="returnValue"
                :scrollable="scrollable"
                :transition="transition"
                :width="width"
        >
            <template slot="activator"><slot name="activator"></slot></template>
            <v-card>
                <v-card-title
                        class="headline grey lighten-2"
                        primary-title
                >
                    <slot name="title">Dialog</slot>
                    <v-spacer></v-spacer>
                    <v-btn
                            small
                            fab
                            dark
                            color="primary"
                            outlined
                            class="close-btn"
                            @click="closeDialog"
                            v-show="closeBtn"
                    >
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>

                <v-card-text>
                    <slot></slot>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <slot name="actions">
                        <v-btn
                                color="primary"
                                text
                                @click="closeDialog"
                        >
                            ok
                        </v-btn>
                    </slot>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                showDialog: false
            }
        },
        props: {
            closeBtn: {
                type: Boolean,
                default: true
            },
            show: {
                type: Boolean,
                default: false
            },
            attach:  null,
            contentClass: null,
            dark: {
                type: Boolean,
                default: false
            },
            disabled: {
                type: Boolean,
                default: false
            },
            fullWidth: {
                type: Boolean,
                default: false
            },
            fullscreen: {
                type: Boolean,
                default: false
            },
            hideOverlay: {
                type: Boolean,
                default: false
            },
            lazy: {
                type: Boolean,
                default: false
            },
            light: {
                type: Boolean,
                default: false
            },
            maxWidth: {
                type: String | Number,
                default: null
            },
            noClickAnimation: {
                type: Boolean,
                default: false
            },
            origin: {
                type: String,
                default: 'center center'
            },
            persistent: {
                type: Boolean,
                default: false
            },
            returnValue: null,
            scrollable: {
                type: Boolean,
                default: false
            },
            transition: {
                type: String | Boolean,
                default: 'dialog-transition'
            },
            width: {
                type: String | Number,
                default: 'auto'
            }
        },
        watch: {
            show(to, from) {
                this.showDialog = to;
            },
            showDialog(to, from) {
                to ? this.$emit('onOpen') : this.$emit('onClose');
            }
        },
        methods: {
            closeDialog: function () {
                this.showDialog = false;
            }
        }
    }
</script>
<style scoped lang="scss">
    .dialog {}

    .close-btn {
        margin: 0;
    }
</style>