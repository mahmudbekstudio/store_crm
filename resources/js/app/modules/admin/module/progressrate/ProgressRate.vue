<template>
    <PageBox class="module-progressrate">
        <!--p>
            <v-btn color="default" :to="{ name: 'progressrate.list'}">List</v-btn>
            <v-btn color="primary" :to="{ name: 'progressrate.detail'}">Detail</v-btn>
            <v-btn color="primary" :to="{ name: 'progressrate.checkList'}">Check list</v-btn>
        </p-->

        <p>
            <!--File v-model="files" :extList="extensions"></File>
            <v-btn @click="submitSelectedFile" color="default" :disabled="!files.length || isLoading"
                   :loading="isLoading">{{ $t('progressrate.submit') }}
            </v-btn-->
            <v-btn text color="default" @click="filterShow=!filterShow">Filter</v-btn>
        </p>

        <div v-show="filterShow">
            <v-container class="grey lighten-5">
                <v-row no-gutters>
                    <v-col cols="12" sm="4">
                        <v-select
                                :value="filter.region.value"
                                @input="filterChanged($event, 'region')"
                                :items="['All', ...filter.region.list]"
                                label="Region"
                        ></v-select>
                        <v-select
                                :value="filter.teacher_computer.value"
                                @input="filterChanged($event, 'teacher_computer')"
                                :items="['All', ...filter.teacher_computer.list]"
                                label="Teacher computer"
                        ></v-select>
                        <v-select
                                :value="filter.student_computer.value"
                                @input="filterChanged($event, 'student_computer')"
                                :items="['All', ...filter.student_computer.list]"
                                label="Student computer"
                        ></v-select>
                        <v-select
                                :value="filter.total_pc.value"
                                @input="filterChanged($event, 'total_pc')"
                                :items="['All', ...filter.total_pc.list]"
                                label="Total PC"
                        ></v-select>
                        <v-select
                                :value="filter.survey.value"
                                @input="filterChanged($event, 'survey')"
                                :items="['All', ...filter.survey.list]"
                                label="Survey"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-select
                                :value="filter.out_wh.value"
                                @input="filterChanged($event, 'out_wh')"
                                :items="['All', ...filter.out_wh.list]"
                                label="Out W/H"
                        ></v-select>
                        <v-select
                                :value="filter.site_arrival_inspection.value"
                                @input="filterChanged($event, 'site_arrival_inspection')"
                                :items="['All', ...filter.site_arrival_inspection.list]"
                                label="Site Arrival Inspection"
                        ></v-select>
                        <v-select
                                :value="filter.oat_training.value"
                                @input="filterChanged($event, 'oat_training')"
                                :items="['All', ...filter.oat_training.list]"
                                label="OAT/Training"
                        ></v-select>
                        <v-select
                                :value="filter.oac.value"
                                @input="filterChanged($event, 'oac')"
                                :items="['All', ...filter.oac.list]"
                                label="OAC"
                        ></v-select>
                        <v-select
                                :value="filter.mac.value"
                                @input="filterChanged($event, 'mac')"
                                :items="['All', ...filter.mac.list]"
                                label="MAC"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-select
                                :value="filter.warranty_completion.value"
                                @input="filterChanged($event, 'warranty_completion')"
                                :items="['All', ...filter.warranty_completion.list]"
                                label="Warranty Competition"
                        ></v-select>
                        <v-select
                                :value="filter.installed_quantity_ecc.value"
                                @input="filterChanged($event, 'installed_quantity_ecc')"
                                :items="['All', ...filter.installed_quantity_ecc.list]"
                                label="Installed Q-ty of Ecc"
                        ></v-select>
                        <v-select
                                :value="filter.installed_quantity_pc.value"
                                @input="filterChanged($event, 'installed_quantity_pc')"
                                :items="['All', ...filter.installed_quantity_pc.list]"
                                label="Installed Q-ty of PC"
                        ></v-select>
                        <v-select
                                :value="filter.progress_rate_ecc.value"
                                @input="filterChanged($event, 'progress_rate_ecc')"
                                :items="['All', ...filter.progress_rate_ecc.list]"
                                label="Progress Rate ECC"
                        ></v-select>
                        <v-select
                                :value="filter.progress_rate_pc.value"
                                @input="filterChanged($event, 'progress_rate_pc')"
                                :items="['All', ...filter.progress_rate_pc.list]"
                                label="Progress Rate PC(T+S)"
                        ></v-select>
                    </v-col>
                </v-row>
            </v-container>
        </div>

        <v-data-table
                :headers="headers"
                :items="items"
                class="elevation-1"
                :items-per-page="5"
        >
            <template v-slot:no-data>
                <div class="text-center">No Data</div>
            </template>
        </v-data-table>
    </PageBox>
</template>
<script>
    import PageBox from '../../view/partial/PageBox';
    import File from '../../component/File';
    import Service from './service';

    export default {
        service: new Service(),
        data() {
            return {
                changedFields: {},
                filterShow: false,
                files: [],
                extensions: ['xlsx'],
                isLoading: false,
                headers: [
                    {
                        text: 'No',
                        align: 'center',
                        value: 'no',
                        width: 50
                    },
                    {
                        text: 'Region',
                        align: 'center',
                        value: 'region',
                    },
                    {
                        text: 'Teacher computer',
                        align: 'center',
                        value: 'teacher_computer',
                    },
                    {
                        text: 'Student computer',
                        align: 'center',
                        value: 'student_computer',
                    },
                    {
                        text: 'Total PC',
                        align: 'center',
                        value: 'total_pc',
                    },
                    {
                        text: 'Survey',
                        align: 'center',
                        value: 'survey',
                    },
                    {
                        text: 'Out W/H',
                        align: 'center',
                        value: 'out_wh',
                    },
                    {
                        text: 'Site Arrival Inspection',
                        align: 'center',
                        value: 'site_arrival_inspection',
                    },
                    {
                        text: 'OAT/Training',
                        align: 'center',
                        value: 'oat_training',
                    },
                    {
                        text: 'OAC',
                        align: 'center',
                        value: 'oac',
                    },
                    {
                        text: 'MAC',
                        align: 'center',
                        value: 'mac',
                    },
                    {
                        text: 'Warranty Competition',
                        align: 'center',
                        value: 'warranty_completion',
                    },
                    {
                        text: 'Installed Q-ty of Ecc',
                        align: 'center',
                        value: 'installed_quantity_ecc',
                    },
                    {
                        text: 'Installed Q-ty of PC',
                        align: 'center',
                        value: 'installed_quantity_pc',
                    },
                    {
                        text: 'Progress Rate ECC',
                        align: 'center',
                        value: 'progress_rate_ecc',
                    },
                    {
                        text: 'Progress Rate PC(T+S)',
                        align: 'center',
                        value: 'progress_rate_pc',
                    }
                ],
            }
        },
        computed: {
            items() {
                return this.$store.state.progressrate.list.filter(item => {
                    if (
                        this.filter.region.value !== 'All' &&
                        this.filter.region.value !== item.region
                    ) {
                        return false;
                    }

                    if (
                        this.filter.teacher_computer.value !== 'All' &&
                        this.filter.teacher_computer.value !== item.teacher_computer
                    ) {
                        return false;
                    }

                    if (
                        this.filter.student_computer.value !== 'All' &&
                        this.filter.student_computer.value !== item.student_computer
                    ) {
                        return false;
                    }

                    if (
                        this.filter.total_pc.value !== 'All' &&
                        this.filter.total_pc.value !== item.total_pc
                    ) {
                        return false;
                    }

                    if (
                        this.filter.survey.value !== 'All' &&
                        this.filter.survey.value !== item.survey
                    ) {
                        return false;
                    }

                    if (
                        this.filter.out_wh.value !== 'All' &&
                        this.filter.out_wh.value !== item.out_wh
                    ) {
                        return false;
                    }

                    if (
                        this.filter.site_arrival_inspection.value !== 'All' &&
                        this.filter.site_arrival_inspection.value !== item.site_arrival_inspection
                    ) {
                        return false;
                    }

                    if (
                        this.filter.oat_training.value !== 'All' &&
                        this.filter.oat_training.value !== item.oat_training
                    ) {
                        return false;
                    }

                    if (
                        this.filter.oac.value !== 'All' &&
                        this.filter.oac.value !== item.oac
                    ) {
                        return false;
                    }

                    if (
                        this.filter.mac.value !== 'All' &&
                        this.filter.mac.value !== item.mac
                    ) {
                        return false;
                    }

                    if (
                        this.filter.warranty_completion.value !== 'All' &&
                        this.filter.warranty_completion.value !== item.warranty_completion
                    ) {
                        return false;
                    }

                    if (
                        this.filter.installed_quantity_ecc.value !== 'All' &&
                        this.filter.installed_quantity_ecc.value !== item.installed_quantity_ecc
                    ) {
                        return false;
                    }

                    if (
                        this.filter.installed_quantity_pc.value !== 'All' &&
                        this.filter.installed_quantity_pc.value !== item.installed_quantity_pc
                    ) {
                        return false;
                    }

                    if (
                        this.filter.progress_rate_ecc.value !== 'All' &&
                        this.filter.progress_rate_ecc.value !== item.progress_rate_ecc
                    ) {
                        return false;
                    }

                    if (
                        this.filter.progress_rate_pc.value !== 'All' &&
                        this.filter.progress_rate_pc.value !== item.progress_rate_pc
                    ) {
                        return false;
                    }

                    return true;
                });
            },
            filter() {
                return this.$store.state.progressrate.filterMain;
            }
        },
        created() {
            this.$options.service.init();
        },
        methods: {
            changeField(id, key, val, send) {
                this.$logger.info(id, key, val);
                this.changedFields[id] = this.changedFields[id] || {};
                this.changedFields[id][key] = val;

                if (send) {
                    this.fieldSave(id, key);
                }
            },
            fieldSave(id, key) {
                if (typeof this.changedFields[id] !== 'undefined' && typeof this.changedFields[id][key] !== 'undefined') {
                    this.$logger.info('changed field', id, key, this.changedFields[id][key]);
                    this.$options.service.changeField(id, key, this.changedFields[id][key]);
                }
                this.changedFields = {};
            },
            submitSelectedFile() {
                this.isLoading = true;
                this.$options.service.submit(this.files, () => {
                    this.files = [];
                    this.isLoading = false;
                });
            },
            filterChanged(val, key) {
                const newFilter = Object.assign({}, this.filter);
                newFilter[key].value = val;
                this.$store.commit('progressrate/changeMainFilter', newFilter);
                console.log(val);
            }
        },
        components: {
            PageBox,
            File
        }
    }
</script>
