import store from '../../plugin/store'

store.registerModule('defect', {
    namespaced: true,

    state: {
        submitDisabled: true,
        isLoading: false,
        list: [],
        errors: '',
        filter: {
            date: {list: [], value: 'All'},
            region: {list: [], value: []},
            district: {list: [], value: 'All'},
            school: {list: [], value: 'All'},
            from_user: {list: [], value: 'All'},
            user_phone: {list: [], value: 'All'},
            received_user: {list: [], value: 'All'},
            product1: {list: ['O'], value: 'All'},
            product2: {list: ['O'], value: 'All'},
            product3: {list: ['O'], value: 'All'},
            product4: {list: ['O'], value: 'All'},
            product5: {list: ['O'], value: 'All'},
            product6: {list: ['O'], value: 'All'},
            product7: {list: ['O'], value: 'All'},
            replacement_part: {list: ['O'], value: 'All'},
            recovery: {list: ['O'], value: 'All'},
            replacement_pc: {list: ['O'], value: 'All'},
            done: {list: [], value: 'All'},
            manager: {list: [], value: 'All'},
        }
    },

    mutations: {
        changeSubmitDisabled(state, val) {
            state.submitDisabled = !!val;
        },
        changeList(state, list) {
            for(let i = 0; i < list.length; i++) {
                if(state.filter.date.list.indexOf(list[i]['date']) === -1) {
                    state.filter.date.list.push(list[i]['date']);
                }

                if(state.filter.region.list.indexOf(list[i]['region']) === -1) {
                    state.filter.region.list.push(list[i]['region']);
                }

                if(state.filter.district.list.indexOf(list[i]['district']) === -1) {
                    state.filter.district.list.push(list[i]['district']);
                }

                if(state.filter.school.list.indexOf(list[i]['school']) === -1) {
                    state.filter.school.list.push(list[i]['school']);
                }

                if(state.filter.from_user.list.indexOf(list[i]['from_user_name']) === -1) {
                    state.filter.from_user.list.push(list[i]['from_user_name']);
                }

                if(state.filter.user_phone.list.indexOf(list[i]['from_user_phone']) === -1) {
                    state.filter.user_phone.list.push(list[i]['from_user_phone']);
                }

                if(state.filter.received_user.list.indexOf(list[i]['received_user_name']) === -1) {
                    state.filter.received_user.list.push(list[i]['received_user_name']);
                }

                if(state.filter.done.list.indexOf(list[i]['date_done']) === -1) {
                    state.filter.done.list.push(list[i]['date_done']);
                }

                if(state.filter.manager.list.indexOf(list[i]['manager_name']) === -1) {
                    state.filter.manager.list.push(list[i]['manager_name']);
                }
            }
            state.list = list;
        },
        changeErrors(state, errors) {
            state.errors = errors;
        },
        changeIsLoading(state, val) {
            state.isLoading = !!val;
        },
        changeFilter(state, val) {
            state.filter = val;
        },
        resetFilter(state) {
            for(let key in state.filter) {
                state.filter[key].value = 'All';
            }
        }
    },

    actions: {
        //
    }
});

export default store