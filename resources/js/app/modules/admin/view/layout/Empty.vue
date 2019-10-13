<template>
    <div class="empty-layout">
        <slot name="header"></slot>
        <v-content>
            <v-progress-linear class="progress" :active="isLoading" :fixed="true" :indeterminate="true"></v-progress-linear>
            <v-container
                    :class="{'fill-height': fillHeight}"
                    fluid
            >
                <slot></slot>
            </v-container>
        </v-content>
        <slot name="footer"></slot>
        <v-snackbar
                v-model="$store.state.view.snackbar.show"
                :color="$store.state.view.snackbar.color"
                :timeout="$store.state.view.snackbar.timeout"
                :absolut="viewConfig.snackbar.absolute"
                :auto-height="viewConfig.snackbar['auto-height']"
                :bottom="viewConfig.snackbar.bottom"
                :left="viewConfig.snackbar.left"
                :multi-line="viewConfig.snackbar['multi-line']"
                :right="viewConfig.snackbar.right"
                :top="viewConfig.snackbar.top"
                :vertical="viewConfig.snackbar.vertical"
        >
            <span v-html="$store.state.view.snackbar.slot"></span>

            <v-btn
                    v-show="$store.state.view.snackbar.showButton"
                    icon
                    @click="$store.dispatch('view/closeSnackbar')"
            >
                <v-icon>mdi-close-box-outline</v-icon>
            </v-btn>
        </v-snackbar>
    </div>
</template>
<script>
    import {mapState} from 'vuex';
    import viewConfig from '../../config/view';

    export default {
        data: function () {
            return {
                viewConfig: viewConfig
            }
        },
        created() {
            this.$vuetify.theme.dark = this.isDark;
        },
        computed: {
            ...mapState({
                isDark: state => state.view.isDark,
                fillHeight: state => state.view.containerFillHeight,
                isLoading: state => state.view.loading,
                snackbar: state => state.view.snackbar
            })
        },
        methods: {
            //
        },
        components: {
            //
        },
        watch: {
            'snackbar.slot' (newVal) {
                this.$logger.info('snackbar text', newVal);
            }
        }
    }
</script>
