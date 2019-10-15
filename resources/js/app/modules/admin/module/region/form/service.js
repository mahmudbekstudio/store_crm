import http from '../../../service/Http';
import app from '../../../service/App'
import logger from '../../../service/Logger';


import api from './api';
import store from './store';

export default class Service {

    constructor() {
        //
    }

    init(id, callback) {
        this.loading(true);
        http(api.get)
            .callback(id)
            .send()
            .then(response => {
                logger.info('region.item', response);
                store.commit('regionForm/changeItem', response.data.item);
                if(typeof callback === 'function') {
                    callback(response.data.item);
                }
            })
            .catch(error => {
                logger.error('region.item', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    edit(id, name, callback) {
        this.loading(true);
        http(api.update)
            .callback(id, name)
            .send()
            .then(response => {
                app.openMessage('Saved');

                if(typeof callback === 'function') {
                    callback(response);
                }
            })
            .catch(error => {
                logger.error('region.edit', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    add(name, callback) {
        this.loading(true);
        http(api.add)
            .callback(name)
            .send()
            .then(response => {
                app.openMessage('Saved');

                if(typeof callback === 'function') {
                    callback(response);
                }
            })
            .catch(error => {
                logger.error('region.edit', error);
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
