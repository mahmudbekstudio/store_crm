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
        <AlertDialog :show="alert.show" @onClose="alertClosed">{{ alert.text }}</AlertDialog>
        <ConfirmDialog :show="confirm.show" @onSelect="confirmSelected">{{ confirm.text }}</ConfirmDialog>
    </div>
</template>
<script>
    import {mapState} from 'vuex';
    import viewConfig from '../../config/view';
    import AlertDialog from '../../component/alert-dialog';
    import ConfirmDialog from '../../component/confirm-dialog';
    import app from '../../service/App';

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
            }),
            alert: function () {
                return this.$store.state.view.alert;
            },
            confirm: function () {
                return this.$store.state.view.confirm;
            },
        },
        methods: {
            alertClosed: function () {
                app.closeAlert();
            },
            confirmSelected: function (type) {
                app.callConfirm(type);
                app.closeConfirm();
            }
        },
        components: {
            AlertDialog,
            ConfirmDialog,
        },
        watch: {
            'snackbar.slot' (newVal) {
                this.$logger.info('snackbar text', newVal);
            }
        }
    }
</script>
