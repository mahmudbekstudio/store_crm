import http from '../../service/Http';
import app from '../../service/App'
import logger from '../../service/Logger';


import api from './api';
import store from './store';

export default class Service {

    constructor() {
        //
    }

    init(id, text, callback) {
        this.loading(true);
        !text && app.openMessage('Loading');
        http(api.list)
            .callback(id)
            .send()
            .then(response => {
                if (typeof callback === 'function') {
                    //callback(response.data.columns);
                }
                logger.info('document.list', response);
                store.commit('document/changeList', response.data.list);
                store.commit('document/changeParams', response.data.params);
                text && app.openMessage(text);
                !text && app.openMessage('Loaded');
            })
            .catch(error => {
                logger.error('document.list', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    submit(files, callback, district, id) {
        logger.info('submitted', files[0]);
        this.loading(true);
        http(api.submit)
            .callback(files[0], district, id)
            .send()
            .then(response => {
                this.init(id);
                if (typeof callback === 'function') {
                    callback();
                }
                logger.info('document submit response', response);
                app.openMessage('Updated');
            })
            .catch(error => {
                logger.error('document.submit', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    delete(id, callback, typeId) {
        this.loading(true);
        http(api.delete)
            .callback(id)
            .send()
            .then(response => {
                this.init(typeId);
                if (typeof callback === 'function') {
                    callback();
                }
                logger.info('document submit response', response);
                app.openMessage('Deleted');
            })
            .catch(error => {
                logger.error('document.submit', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    loading(isStart) {
        app.loading(isStart);
        store.commit('document/changeIsLoading', isStart);
    }
}