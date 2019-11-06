import store from '../../plugin/store'

store.registerModule('shipmentprogress', {
    namespaced: true,

    state: {
        submitDisabled: true,
        isLoading: false,
        list: [],
        errors: '',
        filter: {
            num: {list: [], value: 'All'},
            item: {list: [], value: 'All'},
            unit: {list: [], value: 'All'},
        }
    },

    mutations: {
        changeSubmitDisabled(state, val) {
            state.submitDisabled = !!val;
        },
        changeList(state, list) {
            for (let i = 0; i < list.length; i++) {
                /*if (state.filter.item.list.indexOf(list[i]['item']) === -1) {
                    state.filter.item.list.push(list[i]['item']);
                }

                if (state.filter.unit.list.indexOf(list[i]['unit']) === -1) {
                    state.filter.unit.list.push(list[i]['unit']);
                }

                for(let i = 1; i <= 7; i++) {
                    if (state.filter['wh_0' + i + '_in'].list.indexOf(list[i]['wh_0' + i + '_in']) === -1) {
                        state.filter['wh_0' + i + '_in'].list.push(list[i]['wh_0' + i + '_in']);
                    }

                    if (state.filter['wh_0' + i + '_out'].list.indexOf(list[i]['wh_0' + i + '_out']) === -1) {
                        state.filter['wh_0' + i + '_out'].list.push(list[i]['wh_0' + i + '_out']);
                    }

                    if (state.filter['wh_0' + i + '_total_ab'].list.indexOf(list[i]['wh_0' + i + '_total_ab']) === -1) {
                        state.filter['wh_0' + i + '_total_ab'].list.push(list[i]['wh_0' + i + '_total_ab']);
                    }
                }

                if (state.filter.total_stock.list.indexOf(list[i]['total_stock']) === -1) {
                    state.filter.total_stock.list.push(list[i]['total_stock']);
                }*/
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
