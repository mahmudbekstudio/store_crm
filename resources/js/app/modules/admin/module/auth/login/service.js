import http from '../../../service/Http';
import app from '../../../service/App'
import logger from '../../../service/Logger';


import api from './api';
import store from './store';

export default class Service {

    constructor() {
        //
    }

    submit() {
        this.loading(true);
        http(api.login)
            .callback(store.state.login.form.email, store.state.login.form.password)
            .send()
            .then(response => {
                if(response.data.result) {
                    store.commit('login/changeForm', {email: '', password: ''});
                    app.login(response.data.token);
                } else {
                    store.commit('login/changeErrors', {email: ' ', password: ' '});
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
                logger.error('api.login', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    loading(isStart) {
        app.loading(isStart);
        store.commit('login/changeIsLoading', isStart);
    }
}
