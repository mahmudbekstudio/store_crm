import http from '../../../service/Http';
import app from '../../../service/App'
import logger from '../../../service/Logger';


import api from './api';
import store from './store';

export default class Service {

    constructor() {
        //
    }

    init() {
        this.loading(true);
        http(api.list)
            .send()
            .then(response => {
                logger.info('user.list', response);
                store.commit('userList/changeList', response.data.list);
            })
            .catch(error => {
                logger.error('user.list', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    delete(id) {
        this.loading(true);
        http(api.delete)
            .callback(id)
            .send()
            .then(response => {
                if(response.data.result) {
                    this.init();
                } else {
                    app.errorMessage(response.data.message);
                }
            })
            .catch(error => {
                logger.error('user.delete', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    loading(isStart) {
        app.loading(isStart);
        store.commit('userList/changeIsLoading', isStart);
    }
}
