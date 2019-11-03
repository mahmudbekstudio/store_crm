import http from '../../service/Http';
import app from '../../service/App'
import logger from '../../service/Logger';


import api from './api';
import store from './store';

export default class Service {

    constructor() {
        //
    }

    init(text) {
        this.loading(true);
        !text && app.openMessage('Loading');
        http(api.list)
            .send()
            .then(response => {
                logger.info('defect.list', response);
                store.commit('defect/changeList', response.data.list);
                text && app.openMessage(text);
                !text && app.openMessage('Loaded');
            })
            .catch(error => {
                logger.error('goods.list', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    changeField(id, key, val) {
        this.loading(true);
        app.openMessage('Saving');
        http(api.changeField)
            .callback(id, key, val)
            .send()
            .then(response => {
                this.init('Updated');
            })
            .catch(error => {
                logger.error('defect.changeField', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    submit(files, callback) {
        logger.info('submitted', files[0]);
        this.loading(true);
        app.openMessage('Uploading');
        http(api.submit)
            .callback(files[0])
            .send()
            .then(response => {
                this.init();
                if(typeof callback === 'function') {
                    callback();
                }
                logger.info('defect submit response', response);
                app.openMessage('Updated');
            })
            .catch(error => {
                logger.error('defect.submit', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    loading(isStart) {
        app.loading(isStart);
        store.commit('defect/changeIsLoading', isStart);
    }
}
