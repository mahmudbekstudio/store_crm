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
                logger.info('school.item', response);
                store.commit('schoolForm/changeItem', response.data.item);
                if(typeof callback === 'function') {
                    callback(response.data.item);
                }
            })
            .catch(error => {
                logger.error('school.item', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    getRegions() {
        this.loading(true);
        http(api.regionsList)
            .send()
            .then(response => {
                let list = [];

                for(let item of response.data.list) {
                    list.push({text: item.name, value: item.id});
                }

                logger.info('regions.list', list);

                store.commit('schoolForm/changeRegions', list);
                if(typeof callback === 'function') {
                    callback(list);
                }
            })
            .catch(error => {
                logger.error('regions.list', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    edit(id, name, regionId, callback) {
        this.loading(true);
        http(api.update)
            .callback(id, name, regionId)
            .send()
            .then(response => {
                app.openMessage('Saved');

                if(typeof callback === 'function') {
                    callback(response);
                }
            })
            .catch(error => {
                logger.error('school.edit', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    add(name, regionId, callback) {
        this.loading(true);
        http(api.add)
            .callback(name, regionId)
            .send()
            .then(response => {
                app.openMessage('Saved');

                if(typeof callback === 'function') {
                    callback(response);
                }
            })
            .catch(error => {
                logger.error('school.edit', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    loading(isStart) {
        app.loading(isStart);
        store.commit('schoolList/changeIsLoading', isStart);
    }
}
