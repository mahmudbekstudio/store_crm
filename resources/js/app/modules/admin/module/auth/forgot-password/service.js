import http from '../../../service/Http';
import app from '../../../service/App';
import i18n from '../../../plugin/i18n';
import logger from '../../../service/Logger';


import api from './api';
import store from './store';

export default class Service {

    constructor() {
        //
    }

    submit() {
        this.loading(true);
        http(api.resetPassword)
            .callback(store.state.resetPassword.form.email)
            .send()
            .then(response => {
                if(response.data.result) {
                    store.commit('resetPassword/changeForm', {email: '', password: ''});
                    app.successMessage(i18n.t('translations.words.success'));
                } else {
                    store.commit('resetPassword/changeErrors', {email: ' ', password: ' '});
                    let errorMsgs = [];

                    for(let val in response.data.message) {
                        if(response.data.message.hasOwnProperty(val)) {
                            errorMsgs.push(response.data.message[val]);
                        }
                    }

                    app.errorMessage(errorMsgs.join('<br />'));
                }
            })
            .catch(error => {
                logger.error('api.resetPassword', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    loading(isStart) {
        app.loading(isStart);
        store.commit('resetPassword/changeIsLoading', isStart);
    }
}
