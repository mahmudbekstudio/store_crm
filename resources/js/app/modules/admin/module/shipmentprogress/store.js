import store from '../../plugin/store'

store.registerModule('shipmentprogress', {
    namespaced: true,

    state: {
        submitDisabled: true,
        isLoading: false,
        list: [],
        errors: '',
        filter: {
            item: {list: [], value: []},
            unit: {list: [], value: 'All'},
            contract: {list: [], value: 'All'},
            total: {list: [], value: 'All'},
            balance: {list: [], value: 'All'},
        }
    },

    mutations: {
        changeSubmitDisabled(state, val) {
            state.submitDisabled = !!val;
        },
        changeList(state, list) {
            for (let i = 0; i < list.length; i++) {
                if (list[i]['item'] && state.filter.item.list.indexOf(list[i]['item']) === -1) {
                    state.filter.item.list.push(list[i]['item']);
                }

                if (list[i]['unit'] && state.filter.unit.list.indexOf(list[i]['unit']) === -1) {
                    state.filter.unit.list.push(list[i]['unit']);
                }

                if (list[i]['contract'] && state.filter.contract.list.indexOf(list[i]['contract']) === -1) {
                    state.filter.contract.list.push(list[i]['contract']);
                }

                if (list[i]['total'] && state.filter.total.list.indexOf(list[i]['total']) === -1) {
                    state.filter.total.list.push(list[i]['total']);
                }

                if (list[i]['balance'] && state.filter.balance.list.indexOf(list[i]['balance']) === -1) {
                    state.filter.balance.list.push(list[i]['balance']);
                }
            }
            state.filter.item.list.sort();
            state.filter.unit.list.sort();
            state.filter.contract.list.sort();
            state.filter.total.list.sort();
            state.filter.balance.list.sort();
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
            for (let key in state.filter) {
                state.filter[key].value = 'All';
            }
        }
    },

    actions: {
        //
    }
});

export default store
