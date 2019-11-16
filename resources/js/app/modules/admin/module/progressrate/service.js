import http from '../../service/Http';
import app from '../../service/App'
import logger from '../../service/Logger';


import api from './api';
import store from './store';

export default class Service {

    constructor() {
        //
    }

    detailInit(text) {
        this.loading(true);
        !text && app.openMessage('Loading');
        http(api.detail)
            .send()
            .then(response => {
                logger.info('progressrate.detailList', response);
                store.commit('progressrate/changeDetailList', response.data.list);
                text && app.openMessage(text);
                !text && app.openMessage('Loaded');
            })
            .catch(error => {
                logger.error('progressrate.detailList', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    checkListInit(text) {
        this.loading(true);
        !text && app.openMessage('Loading');
        http(api.checkList)
            .send()
            .then(response => {
                logger.info('progressrate.checkList', response);
                store.commit('progressrate/changeCheckList', response.data.list);
                text && app.openMessage(text);
                !text && app.openMessage('Loaded');
            })
            .catch(error => {
                logger.error('progressrate.checkList', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    addRecord(list, isCheckList, callback) {
        this.loading(true);
        app.openMessage('Saving');
        let route = isCheckList ? api.addRecordCheckList : api.addRecord;
        http(route)
            .callback(list)
            .send()
            .then(response => {
                if(isCheckList) {
                    this.checkListInit('Updated');
                } else {
                    this.detailInit('Updated');
                }
                if (typeof callback === 'function') {
                    callback();
                }
            })
            .catch(error => {
                logger.error('Error.addRecord', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    init(text) {
        this.loading(true);
        !text && app.openMessage('Loading');
        http(api.list)
            .send()
            .then(response => {
                logger.info('progressrate.list', response);
                store.commit('progressrate/changeList', response.data.list);
                text && app.openMessage(text);
                !text && app.openMessage('Loaded');
            })
            .catch(error => {
                logger.error('progressrate.list', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    changeField(id, key, val, isDetail) {
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
    }

    changeFieldCheckList(id, key, val, isDetail) {
        this.loading(true);
        app.openMessage('Saving');
        http(api.changeFieldCheckList)
            .callback(id, key, val)
            .send()
            .then(response => {
                this.checkListInit('Updated');
            })
            .catch(error => {
                logger.error('defect.changeFieldCheckList', error);
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
            .callback(files[0], isDetail)
            .send()
            .then(response => {
                if(isDetail && isDetail === 'check-list') {
                    this.checkListInit();
                } else if (isDetail) {
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
