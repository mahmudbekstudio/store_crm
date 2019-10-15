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
                logger.info('region.list', response);
                store.commit('regionList/changeList', response.data.list);
            })
            .catch(error => {
                logger.error('region.list', error);
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
                this.init();
            })
            .catch(error => {
                logger.error('region.delete', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    loading(isStart) {
        app.loading(isStart);
        store.commit('regionList/changeIsLoading', isStart);
    }
}
