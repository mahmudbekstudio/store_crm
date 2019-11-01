<template>
    <PageBox class="module-progressrate">
        <router-link :to="{ name: 'progressrate.list'}"><< List</router-link>

        <div>
            <File v-model="files" :extList="extensions" btnTitle="Update"></File>
            <v-btn @click="submitSelectedFile" color="default" :disabled="!files.length || isLoading">{{ $t('progressrate.submit') }}</v-btn>
            <v-btn text color="default" @click="filterShow=!filterShow">Filter</v-btn>
        </div>

        <div v-show="filterShow">Filter</div>

        <v-data-table
                :headers="headers"
                :items="items"
                class="elevation-1"
        >
            <template v-slot:no-data>
                <div class="text-center">No Data</div>
            </template>

            <template v-slot:item.region="props">
                <v-edit-dialog
                        :return-value.sync="props.item.region"
                        @save="fieldSave(props.item.id, 'region')"
                        large
                > {{ props.item.region }}
                    <template v-slot:input>
                        <v-text-field
                                :value="props.item.region"
                                @input="changeField(props.item.id, 'region', $event)"

                                label="Region"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.district="props">
                <v-edit-dialog
                        :return-value.sync="props.item.district"
                        @save="fieldSave(props.item.id, 'district')"
                        large
                > {{ props.item.district }}
                    <template v-slot:input>
                        <v-text-field
                                :value="props.item.district"
                                @input="changeField(props.item.id, 'district', $event)"

                                label="District"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.school="props">
                <v-edit-dialog
                        :return-value.sync="props.item.school"
                        @save="fieldSave(props.item.id, 'school')"
                        large
                > {{ props.item.school }}
                    <template v-slot:input>
                        <v-text-field
                                :value="props.item.school"
                                @input="changeField(props.item.id, 'school', $event)"

                                label="School"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.teacher_computer="props">
                <v-edit-dialog
                        :return-value.sync="props.item.teacher_computer"
                        @save="fieldSave(props.item.id, 'teacher_computer')"
                        large
                > {{ props.item.teacher_computer }}
                    <template v-slot:input>
                        <v-text-field
                                :value="props.item.teacher_computer"
                                @input="changeField(props.item.id, 'teacher_computer', $event)"

                                label="Teacher computer"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.student_computer="props">
                <v-edit-dialog
                        :return-value.sync="props.item.student_computer"
                        @save="fieldSave(props.item.id, 'student_computer')"
                        large
                > {{ props.item.student_computer }}
                    <template v-slot:input>
                        <v-text-field
                                :value="props.item.student_computer"
                                @input="changeField(props.item.id, 'student_computer', $event)"

                                label="Student computer"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.survey="props">
                <v-edit-dialog
                        :return-value.sync="props.item.survey"
                        @save="fieldSave(props.item.id, 'survey')"
                        large
                > {{ props.item.survey }}
                    <template v-slot:input>
                        <v-text-field
                                :value="props.item.survey"
                                @input="changeField(props.item.id, 'survey', $event)"

                                label="Survey"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.out_wh="props">
                <v-edit-dialog
                        :return-value.sync="props.item.out_wh"
                        @save="fieldSave(props.item.id, 'out_wh')"
                        large
                > {{ props.item.out_wh }}
                    <template v-slot:input>
                        <v-text-field
                                :value="props.item.out_wh"
                                @input="changeField(props.item.id, 'out_wh', $event)"

                                label="Out of W/H"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.site_arrival_inspection="props">
                <v-edit-dialog
                        :return-value.sync="props.item.site_arrival_inspection"
                        @save="fieldSave(props.item.id, 'site_arrival_inspection')"
                        large
                > {{ props.item.site_arrival_inspection }}
                    <template v-slot:input>
                        <v-text-field
                                :value="props.item.site_arrival_inspection"
                                @input="changeField(props.item.id, 'site_arrival_inspection', $event)"

                                label="Site Arrived Inspection"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.installation="props">
                <v-edit-dialog
                        :return-value.sync="props.item.installation"
                        @save="fieldSave(props.item.id, 'installation')"
                        large
                > {{ props.item.installation }}
                    <template v-slot:input>
                        <v-text-field
                                :value="props.item.installation"
                                @input="changeField(props.item.id, 'installation', $event)"

                                label="Installation"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.oat_training="props">
                <v-edit-dialog
                        :return-value.sync="props.item.oat_training"
                        @save="fieldSave(props.item.id, 'oat_training')"
                        large
                > {{ props.item.oat_training }}
                    <template v-slot:input>
                        <v-text-field
                                :value="props.item.oat_training"
                                @input="changeField(props.item.id, 'oat_training', $event)"

                                label="OAT/Training"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.oac="props">
                <v-edit-dialog
                        :return-value.sync="props.item.oac"
                        @save="fieldSave(props.item.id, 'oac')"
                        large
                > {{ props.item.oac }}
                    <template v-slot:input>
                        <v-text-field
                                :value="props.item.oac"
                                @input="changeField(props.item.id, 'oac', $event)"

                                label="OAC"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.mac="props">
                <v-edit-dialog
                        :return-value.sync="props.item.mac"
                        @save="fieldSave(props.item.id, 'mac')"
                        large
                > {{ props.item.mac }}
                    <template v-slot:input>
                        <v-text-field
                                :value="props.item.mac"
                                @input="changeField(props.item.id, 'mac', $event)"

                                label="MAC"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.warranty_completion="props">
                <v-edit-dialog
                        :return-value.sync="props.item.warranty_completion"
                        @save="fieldSave(props.item.id, 'warranty_completion')"
                        large
                > {{ props.item.warranty_completion }}
                    <template v-slot:input>
                        <v-text-field
                                :value="props.item.warranty_completion"
                                @input="changeField(props.item.id, 'warranty_completion', $event)"

                                label="Warranty Completion"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.remark="props">
                <v-edit-dialog
                        :return-value.sync="props.item.remark"
                        @save="fieldSave(props.item.id, 'remark')"
                        large
                > {{ props.item.remark }}
                    <template v-slot:input>
                        <v-text-field
                                :value="props.item.remark"
                                @input="changeField(props.item.id, 'remark', $event)"

                                label="Remark"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
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
                        text: 'Id',
                        align: 'left',
                        value: 'id',
                        width: 50
                    },
                    {
                        text: 'Region',
                        align: 'left',
                        value: 'region',
                    },
                    {
                        text: 'District',
                        align: 'left',
                        value: 'district',
                    },
                    {
                        text: 'School',
                        align: 'left',
                        value: 'school',
                    },
                    {
                        text: 'Teacher computer',
                        align: 'left',
                        value: 'teacher_computer',
                    },
                    {
                        text: 'Student computer',
                        align: 'left',
                        value: 'student_computer',
                    },
                    {
                        text: 'Survey',
                        align: 'left',
                        value: 'survey',
                    },
                    {
                        text: 'Out of W/H',
                        align: 'left',
                        value: 'out_wh',
                    },
                    {
                        text: 'Site Arrived Inspection',
                        align: 'left',
                        value: 'site_arrival_inspection',
                    },
                    {
                        text: 'Installation',
                        align: 'left',
                        value: 'installation',
                    },
                    {
                        text: 'OAT/Training',
                        align: 'left',
                        value: 'oat_training',
                    },
                    {
                        text: 'OAC',
                        align: 'left',
                        value: 'oac',
                    },
                    {
                        text: 'MAC',
                        align: 'left',
                        value: 'mac',
                    },
                    {
                        text: 'Warranty Completion',
                        align: 'left',
                        value: 'warranty_completion',
                    },
                    {
                        text: 'Q`ty of ECC',
                        align: 'left',
                        value: 'installed_quantity_ecc',
                    },
                    {
                        text: 'Q`ty of PC',
                        align: 'left',
                        value: 'installed_quantity_pc',
                    },
                    {
                        text: 'Remark',
                        align: 'left',
                        value: 'remark',
                    },
                ],
            }
        },
        computed: {
            items() {
                return this.$store.state.progressrate.detailList;//detailList
            }
        },
        created() {
            this.$options.service.detailInit();
        },
        methods: {
            changeField(id, key, val, send) {
                this.$logger.info(id, key, val);
                this.changedFields[id] = this.changedFields[id] || {};
                this.changedFields[id][key] = val;

                if(send) {
                    this.fieldSave(id, key);
                }
            },
            fieldSave(id, key) {
                if(typeof this.changedFields[id] !== 'undefined' && typeof this.changedFields[id][key] !== 'undefined') {
                    this.$logger.info('changed field', id, key, this.changedFields[id][key]);
                    this.$options.service.changeField(id, key, this.changedFields[id][key], true);
                }
                this.changedFields = {};
            },
            submitSelectedFile() {
                this.$options.service.submit(this.files, () => {
                    this.files = [];
                }, true);
            },
        },
        components: {
            PageBox,
            File
        }
    }
</script>
