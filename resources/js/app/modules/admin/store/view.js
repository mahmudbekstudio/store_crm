import viewSettings from '../config/view';
import * as constants from '../constants';

const defaultStates = {
    inited: false,
    website: null,
    drawer: true,
    title: viewSettings.title,
    layout: viewSettings.defaultLayout,
    footerInset: viewSettings.footerInset,
    isDark: viewSettings.isDark,
    isMini: viewSettings.isMini,
    containerFillHeight: false,
    loading: false,
    snackbar: {
        show: false,
        color: viewSettings.snackbar.color,
        showButton: viewSettings.snackbar.showButton,
        timeout: viewSettings.snackbar.timeout,
        slot: ''
    },
    alert: {
        show: false,
        text: ''
    },
    confirm: {
        show: false,
        text: '',
        yesCallback: () => {},
        noCallback: () => {}
    },
};

export default {
    namespaced: true,

    state: Object.assign({}, defaultStates),

    mutations: {
        changeDraawer(state, val) {
            state.drawer = val;
        },
        websiteInit(state) {
            state.inited = true;
        },
        changeWebsite(state, val) {
            state.website = val;
        },
        changeLayout(state, val) {
            state.layout = viewSettings.layoutsList.indexOf(val) > -1 ? val : viewSettings.defaultLayout;
        },
        changeFooterInset(state, val) {
            state.footerInset = !!val;
        },
        changeIsDark(state, val) {
            state.isDark = !!val;
        },
        changeContainerFillHeight(state, val) {
            state.containerFillHeight = !!val;
        },
        changePageTitle(state, val) {
            document.getElementsByTagName('title')[0].innerText = viewSettings.companyName + ' :: ' + val;
            state.title = val;
        },
        changeLoading(state, val) {
            state.loading = !!val;
        },
        changeSnackbar(state, val) {
            console.log('changeSnackbar', val);
            state.snackbar = {
                show: val.show || false,
                color: val.color && constants.SNACKBAR_COLORS[val.color] ? val.color : viewSettings.snackbar.color,
                showButton: typeof val.showButton !== 'undefined' ? val.showButton : viewSettings.snackbar.showButton,
                timeout: typeof val.timeout !== 'undefined' ? val.timeout : viewSettings.snackbar.timeout,
                slot: val.slot || ''
            };
        },
        changeAlert(state, val) {
            state.alert = {
                show: typeof val.show !== 'undefined' ? val.show : defaultStates.alert.show,
                text: typeof val.text !== 'undefined' ? val.text : defaultStates.alert.text
            };
        },

        changeConfirm(state, val) {
            state.confirm = {
                show: typeof val.show !== 'undefined' ? val.show : defaultStates.confirm.show,
                text: typeof val.text !== 'undefined' ? val.text : defaultStates.confirm.text,
                yesCallback: typeof val.yesCallback !== 'undefined' ? val.yesCallback : defaultStates.confirm.yesCallback,
                noCallback: typeof val.noCallback !== 'undefined' ? val.noCallback : defaultStates.confirm.noCallback
            };
        },
    },

    actions: {
        updateDrawer({commit}, val) {
            commit('changeDraawer', val);
        },
        toggleDrawer({commit, state}) {
            commit('changeDraawer', !state.drawer);
        },
        websiteInit({commit}) {
            commit('websiteInit');
        },
        openSnackbar({ commit }, val) {
            console.log('openSnackbar', val);
            commit('changeSnackbar', {
                show: true,
                color: val.color && constants.SNACKBAR_COLORS[val.color] ? val.color : viewSettings.snackbar.color,
                showButton: typeof val.showButton !== 'undefined' ? val.showButton : viewSettings.snackbar.showButton,
                timeout: typeof val.timeout !== 'undefined' ? val.timeout : viewSettings.snackbar.timeout,
                slot: val.slot || ''
            });
        },
        closeSnackbar({ commit }) {
            console.log('closeSnackbar');
            commit('changeSnackbar', {
                show: false,
                color: viewSettings.snackbar.color,
                showButton: viewSettings.snackbar.showButton,
                timeout: viewSettings.snackbar.timeout,
                slot: ''
            });
        },
        openAlert({ commit }, text) {
            commit('changeAlert', {show: true, text: text});
        },

        closeAlert({ commit }) {
            commit('changeAlert', {show: defaultStates.alert.show, text: defaultStates.alert.text});
        },

        openConfirm({ commit }, params) {
            commit('changeConfirm', {
                show: true,
                text: typeof params.text !== 'undefined' ? params.text : defaultStates.confirm.text,
                yesCallback: typeof params.yesCallback !== 'undefined' ? params.yesCallback : defaultStates.confirm.yesCallback,
                noCallback: typeof params.noCallback !== 'undefined' ? params.noCallback : defaultStates.confirm.noCallback
            });
        },

        closeConfirm({ commit }) {
            commit('changeConfirm', {
                show: defaultStates.confirm.show,
                text: defaultStates.confirm.text,
                yesCallback: defaultStates.confirm.yesCallback,
                noCallback: defaultStates.confirm.noCallback
            });
        },
    },

    getters: {
        //
    }
}
