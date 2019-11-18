import store from '../plugin/store';
import auth from './Auth';
import router from '../plugin/routes';
import * as constants from '../constants';
import viewConfig from '../config/view';
import http from './Http';
import logger from './Logger';
import { SNACKBAR_COLORS } from '../constants';
import navigation from '../config/navigation';

class App {
    install(Vue) {
        Vue.prototype.$app = this
    }

    settings(successCallback) {
        if (store.state.view.website) {
            if (typeof successCallback === 'function') {
                successCallback();
            }
        } else {
            this.checkInit(successCallback);
        }
    }

    checkInit(successCallback = null) {
        if (store.state.view.website) {
            store.commit('view/websiteInit');
        } else {
            http('default.website')
                .send()
                .then(response => {
                    if(typeof response.data === 'undefined' || typeof response.data.result === 'undefined') {
                        return false;
                    } else if(response.data.result === false) {
                        this.openMessage(response.data.message, SNACKBAR_COLORS.error);
                        this.logout();
                        return false;
                    }

                    logger.info('default.website', response);
                    store.commit('view/changeWebsite', response.data.settings);

                    if (!response.data.settings.user.hasOwnProperty('id')) {
                        store.commit('storage/clear');
                    }

                    if (typeof successCallback === 'function') {
                        successCallback();
                    }
                })
                .catch(error => {
                    logger.error('default.website', error);
                    router.push({name: viewConfig.page.notFound});
                })
                .then(() => {
                    store.commit('view/websiteInit');
                });
        }
    }

    loading(isStart) {
        store.commit('view/changeLoading', !!isStart);
    }

    openLoadingDialog(text = 'Please wait ...') {
        store.dispatch('view/openLoadingDialog', text);
    }

    closeLoadingDialog() {
        store.dispatch('view/closeLoadingDialog');
    }

    login(token, redirect = true) {
        const user = auth.login(token);
        this.checkInit(() => {
            window.location.reload();
            /*if(navigation[user.role]) {
                router.push({name: navigation[user.role][0].route.name});
                return;
            }
            redirect && router.push({name: viewConfig.page.default});*/
        });
    }

    logout() {
        auth.logout();
        router.push({name: viewConfig.page.login});
    }

    snackbar(params) {
        store.dispatch('view/openSnackbar', params);
    }

    openMessage(text, color = constants.SNACKBAR_COLORS.info, timeout = viewConfig.snackbar.timeout) {
        if (typeof text !== 'string') {
            let textsList = [];

            for (let key in text) {
                textsList.push(text[key]);
            }

            text = textsList.join('<br />');
        }

        this.snackbar({
            color: color,
            slot: text,
            timeout: timeout
        })
    }

    infoMessage(text, timeout = viewConfig.snackbar.timeout) {
        this.openMessage(text, constants.SNACKBAR_COLORS.info, timeout);
    }

    successMessage(text, timeout = viewConfig.snackbar.timeout) {
        this.openMessage(text, constants.SNACKBAR_COLORS.success, timeout);
    }

    errorMessage(text, timeout = viewConfig.snackbar.timeout) {
        this.openMessage(text, constants.SNACKBAR_COLORS.error, timeout);
    }

    closeMessage() {
        store.dispatch('view/closeSnackbar');
    }

    openAlert(text) {
        store.dispatch('view/openAlert', text);
    }

    closeAlert() {
        store.dispatch('view/closeAlert');
    }

    openConfirm(text, yesCallback, noCallback = null) {
        store.dispatch('view/openConfirm', {
            text: text,
            yesCallback: () => {
                yesCallback && yesCallback();
                this.closeConfirm()
            },
            noCallback: () => {
                noCallback && noCallback();
                this.closeConfirm()
            }
        });
    }

    callConfirm(type) {
        return type ? store.state.view.confirm.yesCallback() : store.state.view.confirm.noCallback();
    }

    closeConfirm() {
        store.dispatch('view/closeConfirm');
    }
}

export default new App();
