import store from '../../plugin/store'

store.registerModule('stock', {
    namespaced: true,

    state: {
        submitDisabled: true,
        isLoading: false,
        list: [],
        detail: [],
        errors: '',
        detailFilter: {
            item: {list: [], value: []},
            unit: {list: [], value: 'All'},
            total_a: {list: [], value: 'All'},
            total_b: {list: [], value: 'All'},
            total_ab: {list: [], value: 'All'},
        },
        filter: {
            item: {list: [], value: []},
            unit: {list: [], value: 'All'},

            wh_01_in: {list: [], value: 'All'},
            wh_01_out: {list: [], value: 'All'},
            wh_01_total_ab: {list: [], value: 'All'},

            wh_02_in: {list: [], value: 'All'},
            wh_02_out: {list: [], value: 'All'},
            wh_02_total_ab: {list: [], value: 'All'},

            wh_03_in: {list: [], value: 'All'},
            wh_03_out: {list: [], value: 'All'},
            wh_03_total_ab: {list: [], value: 'All'},

            wh_04_in: {list: [], value: 'All'},
            wh_04_out: {list: [], value: 'All'},
            wh_04_total_ab: {list: [], value: 'All'},

            wh_05_in: {list: [], value: 'All'},
            wh_05_out: {list: [], value: 'All'},
            wh_05_total_ab: {list: [], value: 'All'},

            wh_06_in: {list: [], value: 'All'},
            wh_06_out: {list: [], value: 'All'},
            wh_06_total_ab: {list: [], value: 'All'},

            wh_07_in: {list: [], value: 'All'},
            wh_07_out: {list: [], value: 'All'},
            wh_07_total_ab: {list: [], value: 'All'},

            total_stock: {list: [], value: 'All'},
        }
    },

    mutations: {
        changeSubmitDisabled(state, val) {
            state.submitDisabled = !!val;
        },
        changeList(state, list) {
            for (let i = 0; i < list.length; i++) {
                if (state.filter.item.list.indexOf(list[i]['item']) === -1) {
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
                }
            }
            state.list = list;
        },
        changeDetail(state, list) {
            for (let i = 0; i < list.length; i++) {
                if (state.detailFilter.item.list.indexOf(list[i]['item']) === -1) {
                    state.detailFilter.item.list.push(list[i]['item']);
                }

                if (state.detailFilter.unit.list.indexOf(list[i]['unit']) === -1) {
                    state.detailFilter.unit.list.push(list[i]['unit']);
                }

                if (state.detailFilter.total_a.list.indexOf(list[i]['total_a']) === -1) {
                    state.detailFilter.total_a.list.push(list[i]['total_a']);
                }

                if (state.detailFilter.total_b.list.indexOf(list[i]['total_b']) === -1) {
                    state.detailFilter.total_b.list.push(list[i]['total_b']);
                }

                if (state.detailFilter.total_ab.list.indexOf(list[i]['total_ab']) === -1) {
                    state.detailFilter.total_ab.list.push(list[i]['total_ab']);
                }
            }

            state.detailFilter.item.list.sort();
            state.detailFilter.unit.list.sort();
            state.detailFilter.total_a.list.sort((a, b) => parseFloat(a) > parseFloat(b));
            state.detailFilter.total_b.list.sort((a, b) => parseFloat(a) > parseFloat(b));
            state.detailFilter.total_ab.list.sort((a, b) => parseFloat(a) > parseFloat(b));
            state.detail = list;
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
                state.filter[key].value = [];
            }
        },
        changeDetailFilter(state, val) {
            state.detailFilter = val;
        },
        resetDetailFilter(state) {
            for (let key in state.filter) {
                state.detailFilter[key].value = [];
            }
        },
    },

    actions: {
        //
    }
});

export default store
