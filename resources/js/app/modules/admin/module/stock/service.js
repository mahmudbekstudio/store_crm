import http from '../../service/Http';
import app from '../../service/App'
import logger from '../../service/Logger';


import api from './api';
import store from './store';

export default class Service {

    constructor() {
        //
    }

    init(text, callback) {
        this.loading(true);
        !text && app.openMessage('Loading');
        http(api.list)
            .send()
            .then(response => {
                if (typeof callback === 'function') {
                    //callback(response.data.columns);
                }
                logger.info('stock.list', response);
                store.commit('stock/changeList', response.data.list);
                text && app.openMessage(text);
                !text && app.openMessage('Loaded');
            })
            .catch(error => {
                logger.error('stock.list', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    /*changeField(id, key, val, isDetail) {
        this.loading(true);
        app.openMessage('Saving');
        http(api.changeField)
            .callback(id, key, val)
            .send()
            .then(response => {
                if (isDetail) {
                    this.detailInit('Updated');
                } else {
                    this.init('Updated');
                }
            })
            .catch(error => {
                logger.error('defect.changeField', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }*/

    submit(files, callback, isDetail) {
        logger.info('submitted', files[0]);
        this.loading(true);
        http(api.submit)
            .callback(files[0])
            .send()
            .then(response => {
                this.init();
                if (typeof callback === 'function') {
                    callback();
                }
                logger.info('stock submit response', response);
                app.openMessage('Updated');
            })
            .catch(error => {
                logger.error('stock.submit', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    loading(isStart) {
        app.loading(isStart);
        store.commit('stock/changeIsLoading', isStart);
    }
}