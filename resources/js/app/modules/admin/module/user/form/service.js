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
                logger.info('user.item', response);
                const formItem = {
                    firstName: response.data.item.first_name,
                    lastName: response.data.item.last_name,
                    email: response.data.item.email,
                    status: response.data.item.status,
                    role: response.data.item.role
                };
                store.commit('userForm/changeItem', formItem);
                if(typeof callback === 'function') {
                    callback(formItem);
                }
            })
            .catch(error => {
                logger.error('user.item', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    getParams() {
        this.loading(true);
        http(api.params)
            .send()
            .then(response => {
                let list = {
                    roles: [],
                    statuses: []
                };

                for(let key in response.data.roles) {
                    list.roles.push({text: response.data.roles[key], value: key});
                }

                for(let key in response.data.statuses) {
                    list.statuses.push({text: response.data.statuses[key], value: key});
                }

                logger.info('params.list', list);
                store.commit('userForm/changeParams', list);
            })
            .catch(error => {
                logger.error('params.list', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    edit(id, form, callback) {
        this.loading(true);
        http(api.update)
            .callback(id, form)
            .send()
            .then(response => {
                if(response.data.result) {
                    app.openMessage('Saved');

                    if(typeof callback === 'function') {
                        callback(response);
                    }
                } else {
                    let messages = [];
                    for(let key in response.data.message) {
                        messages.push(response.data.message[key][0]);
                    }
                    app.errorMessage(messages);
                }
            })
            .catch(error => {
                logger.error('user.edit', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    add(form, callback) {
        this.loading(true);
        http(api.add)
            .callback(form)
            .send()
            .then(response => {
                if(response.data.result) {
                    app.openMessage('Saved');

                    if(typeof callback === 'function') {
                        callback(response);
                    }
                } else {
                    let messages = [];
                    for(let key in response.data.message) {
                        messages.push(response.data.message[key][0]);
                    }
                    app.errorMessage(messages);
                }
            })
            .catch(error => {
                logger.error('user.edit', error);
                app.errorMessage('Error');
            })
            .then(() => {
                this.loading(false);
            });
    }

    loading(isStart) {
        app.loading(isStart);
        store.commit('userList/changeIsLoading', isStart);
    }
}
