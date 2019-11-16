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
                    callback(response.data.columns);
                }
                logger.info('shipmentprogress.list', response);
                store.commit('shipmentprogress/changeList', response.data.list);
                text && app.openMessage(text);
                !text && app.openMessage('Loaded');
            })
            .catch(error => {
                logger.error('shipmentprogress.list', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    changeField(id, key, val, isDetail, no, callback) {
        console.log(id, key, val);
        this.loading(true);
        app.openMessage('Saving');
        http(api.changeField)
            .callback(id, key, val, no)
            .send()
            .then(response => {
                this.init(no, '', callback);
            })
            .catch(error => {
                logger.error('stock.changeField', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    changeColumn(list, no, callback) {
        this.loading(true);
        app.openMessage('Saving');
        http(api.changeColumn)
            .callback(list, no)
            .send()
            .then(response => {
                this.init(no, '', callback);
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
                this.init(no, '', callback);
            })
            .catch(error => {
                logger.error('stock.addRecord', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    submit(files, callback, id, initCallback) {
        logger.info('submitted', files[0]);
        this.loading(true);
        http(api.submit)
            .callback(files[0], id)
            .send()
            .then(response => {
                this.init(id, initCallback);
                if (typeof callback === 'function') {
                    callback();
                }
                logger.info('shipmentprogress submit response', response);
                app.openMessage('Updated');
            })
            .catch(error => {
                logger.error('shipmentprogress.submit', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    loading(isStart) {
        app.loading(isStart);
        store.commit('shipmentprogress/changeIsLoading', isStart);
    }
}
