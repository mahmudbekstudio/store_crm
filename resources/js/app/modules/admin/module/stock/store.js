import store from '../../plugin/store'

store.registerModule('stock', {
    namespaced: true,

    state: {
        submitDisabled: true,
        isLoading: false,
        list: [],
        errors: '',
        filter: {
            /*region: {list: [], value: 'All'},
            district: {list: [], value: 'All'},
            school: {list: [], value: 'All'},
            teacher_computer: {list: [], value: 'All'},
            student_computer: {list: [], value: 'All'},

            survey: {list: [], value: 'All'},
            out_wh: {list: [], value: 'All'},
            site_arrival_inspection: {list: [], value: 'All'},
            installation: {list: [], value: 'All'},
            oat_training: {list: [], value: 'All'},

            oac: {list: [], value: 'All'},
            mac: {list: [], value: 'All'},
            warranty_completion: {list: [], value: 'All'},
            installed_quantity_ecc: {list: [], value: 'All'},
            installed_quantity_pc: {list: [], value: 'All'},*/
        }
    },

    mutations: {
        changeSubmitDisabled(state, val) {
            state.submitDisabled = !!val;
        },
        changeList(state, list) {
            for (let i = 0; i < list.length; i++) {
                /*if (state.filterMain.region.list.indexOf(list[i]['region']) === -1) {
                    state.filterMain.region.list.push(list[i]['region']);
                }

                if (state.filterMain.teacher_computer.list.indexOf(list[i]['teacher_computer']) === -1) {
                    state.filterMain.teacher_computer.list.push(list[i]['teacher_computer']);
                }

                if (state.filterMain.student_computer.list.indexOf(list[i]['student_computer']) === -1) {
                    state.filterMain.student_computer.list.push(list[i]['student_computer']);
                }

                if (state.filterMain.total_pc.list.indexOf(list[i]['total_pc']) === -1) {
                    state.filterMain.total_pc.list.push(list[i]['total_pc']);
                }

                if (state.filterMain.survey.list.indexOf(list[i]['survey']) === -1) {
                    state.filterMain.survey.list.push(list[i]['survey']);
                }

                if (state.filterMain.out_wh.list.indexOf(list[i]['out_wh']) === -1) {
                    state.filterMain.out_wh.list.push(list[i]['out_wh']);
                }

                if (state.filterMain.site_arrival_inspection.list.indexOf(list[i]['site_arrival_inspection']) === -1) {
                    state.filterMain.site_arrival_inspection.list.push(list[i]['site_arrival_inspection']);
                }

                if (state.filterMain.oat_training.list.indexOf(list[i]['oat_training']) === -1) {
                    state.filterMain.oat_training.list.push(list[i]['oat_training']);
                }

                if (state.filterMain.oac.list.indexOf(list[i]['oac']) === -1) {
                    state.filterMain.oac.list.push(list[i]['oac']);
                }

                if (state.filterMain.mac.list.indexOf(list[i]['mac']) === -1) {
                    state.filterMain.mac.list.push(list[i]['mac']);
                }

                if (state.filterMain.warranty_completion.list.indexOf(list[i]['warranty_completion']) === -1) {
                    state.filterMain.warranty_completion.list.push(list[i]['warranty_completion']);
                }

                if (state.filterMain.installed_quantity_ecc.list.indexOf(list[i]['installed_quantity_ecc']) === -1) {
                    state.filterMain.installed_quantity_ecc.list.push(list[i]['installed_quantity_ecc']);
                }

                if (state.filterMain.installed_quantity_pc.list.indexOf(list[i]['installed_quantity_pc']) === -1) {
                    state.filterMain.installed_quantity_pc.list.push(list[i]['installed_quantity_pc']);
                }

                if (state.filterMain.progress_rate_ecc.list.indexOf(list[i]['progress_rate_ecc']) === -1) {
                    state.filterMain.progress_rate_ecc.list.push(list[i]['progress_rate_ecc']);
                }

                if (state.filterMain.progress_rate_pc.list.indexOf(list[i]['progress_rate_pc']) === -1) {
                    state.filterMain.progress_rate_pc.list.push(list[i]['progress_rate_pc']);
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
        },
    },

    actions: {
        //
    }
});

export default store
