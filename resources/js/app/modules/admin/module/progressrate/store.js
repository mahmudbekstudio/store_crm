import store from '../../plugin/store'

store.registerModule('progressrate', {
    namespaced: true,

    state: {
        submitDisabled: true,
        isLoading: false,
        list: [],
        detailList: [],
        checkList: [],
        errors: '',
        filterCheckList: {
            region: {list: [], value: []},
            district: {list: [], value: 'All'},
            school: {list: [], value: 'All'},
            teacher_computer: {list: [], value: 'All'},
            student_computer: {list: [], value: 'All'},
            quantity_teacher_desk: {list: [], value: 'All'},
            quantity_student_desk: {list: [], value: 'All'},
            size_ecc_length: {list: [], value: 'All'},
            size_ecc_width: {list: [], value: 'All'},
            power_socket_l: {list: [], value: 'All'},
            power_socket_r: {list: [], value: 'All'},
            power_socket_f: {list: [], value: 'All'},
            power_socket_b: {list: [], value: 'All'},
            circuit_breaker: {list: [], value: 'All'},
            internet: {list: [], value: 'All'},
        },
        filter: {
            region: {list: [], value: []},
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
            installed_quantity_pc: {list: [], value: 'All'},
        },
        filterMain: {
            region: {list: [], value: []},
            teacher_computer: {list: [], value: 'All'},
            student_computer: {list: [], value: 'All'},
            total_pc: {list: [], value: 'All'},
            survey: {list: [], value: 'All'},
            out_wh: {list: [], value: 'All'},
            site_arrival_inspection: {list: [], value: 'All'},
            oat_training: {list: [], value: 'All'},
            oac: {list: [], value: 'All'},
            mac: {list: [], value: 'All'},
            warranty_completion: {list: [], value: 'All'},
            installed_quantity_ecc: {list: [], value: 'All'},
            installed_quantity_pc: {list: [], value: 'All'},
            progress_rate_ecc: {list: [], value: 'All'},
            progress_rate_pc: {list: [], value: 'All'}
        }
    },

    mutations: {
        changeSubmitDisabled(state, val) {
            state.submitDisabled = !!val;
        },
        changeCheckList(state, list) {
            for (let i = 0; i < list.length; i++) {
                if (state.filterCheckList.region.list.indexOf(list[i]['region']) === -1) {
                    state.filterCheckList.region.list.push(list[i]['region']);
                }

                if (state.filterCheckList.district.list.indexOf(list[i]['district']) === -1) {
                    state.filterCheckList.district.list.push(list[i]['district']);
                }

                if (state.filterCheckList.school.list.indexOf(list[i]['school']) === -1) {
                    state.filterCheckList.school.list.push(list[i]['school']);
                }

                if (state.filterCheckList.teacher_computer.list.indexOf(list[i]['teacher_computer']) === -1) {
                    state.filterCheckList.teacher_computer.list.push(list[i]['teacher_computer']);
                }

                if (state.filterCheckList.student_computer.list.indexOf(list[i]['student_computer']) === -1) {
                    state.filterCheckList.student_computer.list.push(list[i]['student_computer']);
                }

                if (state.filterCheckList.quantity_teacher_desk.list.indexOf(list[i]['quantity_teacher_desk']) === -1) {
                    state.filterCheckList.quantity_teacher_desk.list.push(list[i]['quantity_teacher_desk']);
                }

                if (state.filterCheckList.quantity_student_desk.list.indexOf(list[i]['quantity_student_desk']) === -1) {
                    state.filterCheckList.quantity_student_desk.list.push(list[i]['quantity_student_desk']);
                }

                if (state.filterCheckList.size_ecc_length.list.indexOf(list[i]['size_ecc_length']) === -1) {
                    state.filterCheckList.size_ecc_length.list.push(list[i]['size_ecc_length']);
                }

                if (state.filterCheckList.size_ecc_width.list.indexOf(list[i]['size_ecc_width']) === -1) {
                    state.filterCheckList.size_ecc_width.list.push(list[i]['size_ecc_width']);
                }

                if (state.filterCheckList.power_socket_l.list.indexOf(list[i]['power_socket_l']) === -1) {
                    state.filterCheckList.power_socket_l.list.push(list[i]['power_socket_l']);
                }

                if (state.filterCheckList.power_socket_r.list.indexOf(list[i]['power_socket_r']) === -1) {
                    state.filterCheckList.power_socket_r.list.push(list[i]['power_socket_r']);
                }

                if (state.filterCheckList.power_socket_f.list.indexOf(list[i]['power_socket_f']) === -1) {
                    state.filterCheckList.power_socket_f.list.push(list[i]['power_socket_f']);
                }

                if (state.filterCheckList.power_socket_b.list.indexOf(list[i]['power_socket_b']) === -1) {
                    state.filterCheckList.power_socket_b.list.push(list[i]['power_socket_b']);
                }

                if (state.filterCheckList.circuit_breaker.list.indexOf(list[i]['circuit_breaker']) === -1) {
                    state.filterCheckList.circuit_breaker.list.push(list[i]['circuit_breaker']);
                }

                if (state.filterCheckList.internet.list.indexOf(list[i]['internet']) === -1) {
                    state.filterCheckList.internet.list.push(list[i]['internet']);
                }
            }
            state.checkList = list;
        },
        changeDetailList(state, list) {
            for (let i = 0; i < list.length; i++) {
                if (state.filter.region.list.indexOf(list[i]['region']) === -1) {
                    state.filter.region.list.push(list[i]['region']);
                }

                if (state.filter.district.list.indexOf(list[i]['district']) === -1) {
                    state.filter.district.list.push(list[i]['district']);
                }

                if (state.filter.school.list.indexOf(list[i]['school']) === -1) {
                    state.filter.school.list.push(list[i]['school']);
                }

                if (state.filter.teacher_computer.list.indexOf(list[i]['teacher_computer']) === -1) {
                    state.filter.teacher_computer.list.push(list[i]['teacher_computer']);
                }

                if (state.filter.student_computer.list.indexOf(list[i]['student_computer']) === -1) {
                    state.filter.student_computer.list.push(list[i]['student_computer']);
                }

                if (state.filter.survey.list.indexOf(list[i]['survey']) === -1) {
                    state.filter.survey.list.push(list[i]['survey']);
                }

                if (state.filter.out_wh.list.indexOf(list[i]['out_wh']) === -1) {
                    state.filter.out_wh.list.push(list[i]['out_wh']);
                }

                if (state.filter.site_arrival_inspection.list.indexOf(list[i]['site_arrival_inspection']) === -1) {
                    state.filter.site_arrival_inspection.list.push(list[i]['site_arrival_inspection']);
                }

                if (state.filter.installation.list.indexOf(list[i]['installation']) === -1) {
                    state.filter.installation.list.push(list[i]['installation']);
                }

                if (state.filter.oat_training.list.indexOf(list[i]['oat_training']) === -1) {
                    state.filter.oat_training.list.push(list[i]['oat_training']);
                }

                if (state.filter.oac.list.indexOf(list[i]['oac']) === -1) {
                    state.filter.oac.list.push(list[i]['oac']);
                }

                if (state.filter.mac.list.indexOf(list[i]['mac']) === -1) {
                    state.filter.mac.list.push(list[i]['mac']);
                }

                if (state.filter.warranty_completion.list.indexOf(list[i]['warranty_completion']) === -1) {
                    state.filter.warranty_completion.list.push(list[i]['warranty_completion']);
                }

                if (state.filter.installed_quantity_ecc.list.indexOf(list[i]['installed_quantity_ecc']) === -1) {
                    state.filter.installed_quantity_ecc.list.push(list[i]['installed_quantity_ecc']);
                }

                if (state.filter.installed_quantity_pc.list.indexOf(list[i]['installed_quantity_pc']) === -1) {
                    state.filter.installed_quantity_pc.list.push(list[i]['installed_quantity_pc']);
                }
            }

            state.filter.region.list.sort();
            state.filter.district.list.sort();
            state.filter.school.list.sort();
            state.filter.teacher_computer.list.sort((a, b) => parseFloat(a) > parseFloat(b));
            state.filter.student_computer.list.sort((a, b) => parseFloat(a) > parseFloat(b));
            state.filter.survey.list.sort();
            state.filter.out_wh.list.sort();
            state.filter.site_arrival_inspection.list.sort();
            state.filter.installation.list.sort();
            state.filter.oat_training.list.sort();
            state.filter.oac.list.sort();
            state.filter.mac.list.sort();
            state.filter.warranty_completion.list.sort();
            state.filter.installed_quantity_ecc.list.sort((a, b) => parseFloat(a) > parseFloat(b));
            state.filter.installed_quantity_pc.list.sort((a, b) => parseFloat(a) > parseFloat(b));
            state.detailList = list;
        },
        changeList(state, list) {
            for (let i = 0; i < list.length; i++) {
                if (state.filterMain.region.list.indexOf(list[i]['region']) === -1) {
                    state.filterMain.region.list.push(list[i]['region']);
                }

                list[i]['teacher_computer'] = list[i]['teacher_computer'].format();
                if (state.filterMain.teacher_computer.list.indexOf(list[i]['teacher_computer']) === -1) {
                    state.filterMain.teacher_computer.list.push(list[i]['teacher_computer']);
                }

                list[i]['student_computer'] = list[i]['student_computer'].format();
                if (state.filterMain.student_computer.list.indexOf(list[i]['student_computer']) === -1) {
                    state.filterMain.student_computer.list.push(list[i]['student_computer']);
                }

                list[i]['total_pc'] = list[i]['total_pc'].format();
                if (state.filterMain.total_pc.list.indexOf(list[i]['total_pc']) === -1) {
                    state.filterMain.total_pc.list.push(list[i]['total_pc']);
                }

                list[i]['survey'] = list[i]['survey'].format();
                if (state.filterMain.survey.list.indexOf(list[i]['survey']) === -1) {
                    state.filterMain.survey.list.push(list[i]['survey']);
                }

                list[i]['out_wh'] = list[i]['out_wh'].format();
                if (state.filterMain.out_wh.list.indexOf(list[i]['out_wh']) === -1) {
                    state.filterMain.out_wh.list.push(list[i]['out_wh']);
                }

                list[i]['site_arrival_inspection'] = list[i]['site_arrival_inspection'].format();
                if (state.filterMain.site_arrival_inspection.list.indexOf(list[i]['site_arrival_inspection']) === -1) {
                    state.filterMain.site_arrival_inspection.list.push(list[i]['site_arrival_inspection']);
                }

                list[i]['oat_training'] = list[i]['oat_training'].format();
                if (state.filterMain.oat_training.list.indexOf(list[i]['oat_training']) === -1) {
                    state.filterMain.oat_training.list.push(list[i]['oat_training']);
                }

                list[i]['oac'] = list[i]['oac'].format();
                if (state.filterMain.oac.list.indexOf(list[i]['oac']) === -1) {
                    state.filterMain.oac.list.push(list[i]['oac']);
                }

                list[i]['mac'] = list[i]['mac'].format();
                if (state.filterMain.mac.list.indexOf(list[i]['mac']) === -1) {
                    state.filterMain.mac.list.push(list[i]['mac']);
                }

                list[i]['warranty_completion'] = list[i]['warranty_completion'].format();
                if (state.filterMain.warranty_completion.list.indexOf(list[i]['warranty_completion']) === -1) {
                    state.filterMain.warranty_completion.list.push(list[i]['warranty_completion']);
                }

                list[i]['installed_quantity_ecc'] = list[i]['installed_quantity_ecc'].format();
                if (state.filterMain.installed_quantity_ecc.list.indexOf(list[i]['installed_quantity_ecc']) === -1) {
                    state.filterMain.installed_quantity_ecc.list.push(list[i]['installed_quantity_ecc']);
                }

                list[i]['installed_quantity_pc'] = list[i]['installed_quantity_pc'].format();
                if (state.filterMain.installed_quantity_pc.list.indexOf(list[i]['installed_quantity_pc']) === -1) {
                    state.filterMain.installed_quantity_pc.list.push(list[i]['installed_quantity_pc']);
                }

                if (state.filterMain.progress_rate_ecc.list.indexOf(list[i]['progress_rate_ecc']) === -1) {
                    state.filterMain.progress_rate_ecc.list.push(list[i]['progress_rate_ecc']);
                }

                if (state.filterMain.progress_rate_pc.list.indexOf(list[i]['progress_rate_pc']) === -1) {
                    state.filterMain.progress_rate_pc.list.push(list[i]['progress_rate_pc']);
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
            for (let key in state.filter) {
                state.filter[key].value = 'All';
            }
        },
        changeFilterCheckList(state, val) {
            state.filterCheckList = val;
        },
        resetFilterCheckList(state) {
            for (let key in state.filterCheckList) {
                state.filterCheckList[key].value = 'All';
            }
        },
        changeMainFilter(state, val) {
            state.filterMain = val;
        },
        resetMainFilter(state) {
            for (let key in state.filterMain) {
                state.filterMain[key].value = 'All';
            }
        }
    },

    actions: {
        //
    }
});

export default store
