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

    detailInit(id, text, callback) {
        this.loading(true);
        !text && app.openMessage('Loading');
        http(api.detail)
            .callback(id)
            .send()
            .then(response => {
                if (typeof callback === 'function') {
                    callback(response.data.columns);
                }
                logger.info('stock.detail', response);
                store.commit('stock/changeDetail', response.data.list);
                text && app.openMessage(text);
                !text && app.openMessage('Loaded');
            })
            .catch(error => {
                logger.error('stock.detail', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    changeFieldDetail(id, key, val, isDetail, no, callback) {
        console.log(id, key, val);
        this.loading(true);
        app.openMessage('Saving');
        http(api.changeField)
            .callback(id, key, val, no)
            .send()
            .then(response => {
                if (isDetail) {
                    this.detailInit(no, 'Updated', callback);
                } else {
                    this.init('Updated');
                }
            })
            .catch(error => {
                logger.error('stock.changeField', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    changeColumn(list, no, isIn, callback) {
        this.loading(true);
        app.openMessage('Saving');
        http(api.changeColumn)
            .callback(list, no, isIn)
            .send()
            .then(response => {
                this.detailInit(no, 'Updated', callback);
            })
            .catch(error => {
                logger.error('stock.changeColumn', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    addRecord(list, no, callback) {
        this.loading(true);
        app.openMessage('Saving');
        http(api.addRecord)
            .callback(list, no)
            .send()
            .then(response => {
                this.detailInit(no, '', callback);
            })
            .catch(error => {
                logger.error('stock.addRecord', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    submit(files, callback, isDetail, id, initCallback) {
        logger.info('submitted', files[0]);
        this.loading(true);
        http(api.submit)
            .callback(files[0], id)
            .send()
            .then(response => {
                if(isDetail) {
                    this.detailInit(id, '', initCallback);
                } else {
                    this.init();
                }
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
