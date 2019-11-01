import http from '../../service/Http';
import app from '../../service/App'
import logger from '../../service/Logger';


import api from './api';
import store from './store';

export default class Service {

    constructor() {
        //
    }

    detailInit() {
        this.loading(true);
        http(api.detail)
            .send()
            .then(response => {
                logger.info('progressrate.detailList', response);
                store.commit('progressrate/changeDetailList', response.data.list);
            })
            .catch(error => {
                logger.error('progressrate.detailList', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    init() {
        /*this.loading(true);
        http(api.list)
          .send()
          .then(response => {
            logger.info('defect.list', response);
            store.commit('defect/changeList', response.data.list);
          })
          .catch(error => {
            logger.error('goods.list', error);
            app.errorMessage('Error');
          })
          .then(() => {
            this.loading(false);
          });*/
    }

    changeField(id, key, val, isDetail) {
        this.loading(true);
        http(api.changeField)
            .callback(id, key, val)
            .send()
            .then(response => {
                if (isDetail) {
                    this.detailInit();
                } else {
                    this.init();
                }
                app.openMessage('Updated');
            })
            .catch(error => {
                logger.error('defect.changeField', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    submit(files, callback, isDetail) {
        logger.info('submitted', files[0]);
        this.loading(true);
        http(api.submit)
            .callback(files[0])
            .send()
            .then(response => {
                if (isDetail) {
                    this.detailInit();
                } else {
                    this.init();
                }
                if (typeof callback === 'function') {
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
        store.commit('progressrate/changeIsLoading', isStart);
    }
}
