<template>
    <PageBox class="module-progressrate">
        <!--p>
            <v-btn color="primary" :to="{ name: 'progressrate.list'}">List</v-btn>
            <v-btn color="default" :to="{ name: 'progressrate.detail'}">Detail</v-btn>
            <v-btn color="primary" :to="{ name: 'progressrate.checkList'}">Check list</v-btn>
        </p-->

        <p>
            <File v-model="files" :extList="extensions"></File>
            <v-btn @click="submitSelectedFile" color="default" :disabled="!files.length || isLoading" :loading="isLoading">{{ $t('progressrate.submit') }}</v-btn>
            <v-btn text color="default" @click="filterShow=!filterShow">Filter</v-btn>

            <v-dialog
                    v-model="addRowPopup"
                    width="500"
            >
                <template v-slot:activator="{ on }">
                    <v-btn
                            color="default"
                            v-on="on"
                    >
                        Add record
                    </v-btn>
                </template>
                <v-card>
                    <v-card-title
                            class="headline grey lighten-2"
                            primary-title
                    >
                        Add record
                    </v-card-title>

                    <v-card-text>
                        <v-text-field
                                v-for="(item, index) in newRecordFields"
                                v-model="item.value"
                                :label="item.label"
                                :key="index"
                                type="text"
                        ></v-text-field>
                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                                color="primary"
                                text
                                @click="saveNewColumn"
                        >
                            Save
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
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
                                :value="filter.district.value"
                                @input="filterChanged($event, 'district')"
                                :items="['All', ...filter.district.list]"
                                label="District"
                        ></v-select>
                        <v-select
                                :value="filter.school.value"
                                @input="filterChanged($event, 'school')"
                                :items="['All', ...filter.school.list]"
                                label="School"
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
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-select
                                :value="filter.survey.value"
                                @input="filterChanged($event, 'survey')"
                                :items="['All', ...filter.survey.list]"
                                label="Survey"
                        ></v-select>
                        <v-select
                                :value="filter.out_wh.value"
                                @input="filterChanged($event, 'out_wh')"
                                :items="['All', ...filter.out_wh.list]"
                                label="Out of W/H"
                        ></v-select>
                        <v-select
                                :value="filter.site_arrival_inspection.value"
                                @input="filterChanged($event, 'site_arrival_inspection')"
                                :items="['All', ...filter.site_arrival_inspection.list]"
                                label="Site Arrived Inspection"
                        ></v-select>
                        <v-select
                                :value="filter.installation.value"
                                @input="filterChanged($event, 'installation')"
                                :items="['All', ...filter.installation.list]"
                                label="Installation"
                        ></v-select>
                        <v-select
                                :value="filter.oat_training.value"
                                @input="filterChanged($event, 'oat_training')"
                                :items="['All', ...filter.oat_training.list]"
                                label="OAT/Training"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4">
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
                        <v-select
                                :value="filter.warranty_completion.value"
                                @input="filterChanged($event, 'warranty_completion')"
                                :items="['All', ...filter.warranty_completion.list]"
                                label="Warranty Completion"
                        ></v-select>
                        <v-select
                                :value="filter.installed_quantity_ecc.value"
                                @input="filterChanged($event, 'installed_quantity_ecc')"
                                :items="['All', ...filter.installed_quantity_ecc.list]"
                                label="Q`ty of ECC"
                        ></v-select>
                        <v-select
                                :value="filter.installed_quantity_pc.value"
                                @input="filterChanged($event, 'installed_quantity_pc')"
                                :items="['All', ...filter.installed_quantity_pc.list]"
                                label="Q`ty of PC"
                        ></v-select>
                    </v-col>
                </v-row>
            </v-container>
        </div>

        <v-data-table
                :headers="headers"
                :items="items"
                class="elevation-1 custom-table"
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
                                :value="getField(props.item.id, 'region') || props.item.region"
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
                                :value="getField(props.item.id, 'district') || props.item.district"
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
                                :value="getField(props.item.id, 'school') || props.item.school"
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
                                :value="getField(props.item.id, 'teacher_computer') || props.item.teacher_computer"
                                @input="changeField(props.item.id, 'teacher_computer', $event, false, 'int')"

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
                                :value="getField(props.item.id, 'student_computer') || props.item.student_computer"
                                @input="changeField(props.item.id, 'student_computer', $event, false, 'int')"

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
                        <v-menu
                                v-model="dateMenu[props.item.id + '_survey']"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                full-width
                                max-width="290px"
                                min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                        :value="getField(props.item.id, 'survey') || props.item.survey"
                                        @input="changeField(props.item.id, 'survey', $event)"
                                        label="Survey"
                                        hint="YYYY-MM-DD format"
                                        persistent-hint
                                        prepend-icon="mdi-calendar"
                                        v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                    :value="props.item.survey"
                                    @input="changeField(props.item.id, 'survey', $event);dateMenu[props.item.id + '_survey']=false"
                                    no-title
                            ></v-date-picker>
                        </v-menu>
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
                        <v-menu
                                v-model="dateMenu[props.item.id + '_out_wh']"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                full-width
                                max-width="290px"
                                min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                        :value="getField(props.item.id, 'out_wh') || props.item.out_wh"
                                        @input="changeField(props.item.id, 'out_wh', $event)"
                                        label="Out of W/H"
                                        hint="YYYY-MM-DD format"
                                        persistent-hint
                                        prepend-icon="mdi-calendar"
                                        v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                    :value="props.item.out_wh"
                                    @input="changeField(props.item.id, 'out_wh', $event);dateMenu[props.item.id + '_out_wh']=false"
                                    no-title
                            ></v-date-picker>
                        </v-menu>
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
                        <v-menu
                                v-model="dateMenu[props.item.id + '_site_arrival_inspection']"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                full-width
                                max-width="290px"
                                min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                        :value="getField(props.item.id, 'site_arrival_inspection') || props.item.site_arrival_inspection"
                                        @input="changeField(props.item.id, 'site_arrival_inspection', $event)"
                                        label="Site Arrived Inspection"
                                        hint="YYYY-MM-DD format"
                                        persistent-hint
                                        prepend-icon="mdi-calendar"
                                        v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                    :value="props.item.site_arrival_inspection"
                                    @input="changeField(props.item.id, 'site_arrival_inspection', $event);dateMenu[props.item.id + '_site_arrival_inspection']=false"
                                    no-title
                            ></v-date-picker>
                        </v-menu>
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
                        <v-menu
                                v-model="dateMenu[props.item.id + '_installation']"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                full-width
                                max-width="290px"
                                min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                        :value="getField(props.item.id, 'installation') || props.item.installation"
                                        @input="changeField(props.item.id, 'installation', $event)"
                                        label="Installation"
                                        hint="YYYY-MM-DD format"
                                        persistent-hint
                                        prepend-icon="mdi-calendar"
                                        v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                    :value="props.item.installation"
                                    @input="changeField(props.item.id, 'installation', $event);dateMenu[props.item.id + '_installation']=false"
                                    no-title
                            ></v-date-picker>
                        </v-menu>
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
                        <v-menu
                                v-model="dateMenu[props.item.id + '_oat_training']"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                full-width
                                max-width="290px"
                                min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                        :value="getField(props.item.id, 'oat_training') || props.item.oat_training"
                                        @input="changeField(props.item.id, 'oat_training', $event)"
                                        label="OAT/Training"
                                        hint="YYYY-MM-DD format"
                                        persistent-hint
                                        prepend-icon="mdi-calendar"
                                        v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                    :value="props.item.oat_training"
                                    @input="changeField(props.item.id, 'oat_training', $event);dateMenu[props.item.id + '_oat_training']=false"
                                    no-title
                            ></v-date-picker>
                        </v-menu>
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
                        <v-menu
                                v-model="dateMenu[props.item.id + '_oac']"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                full-width
                                max-width="290px"
                                min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                        :value="getField(props.item.id, 'oac') || props.item.oac"
                                        @input="changeField(props.item.id, 'oac', $event)"
                                        label="OAC"
                                        hint="YYYY-MM-DD format"
                                        persistent-hint
                                        prepend-icon="mdi-calendar"
                                        v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                    :value="props.item.oac"
                                    @input="changeField(props.item.id, 'oac', $event);dateMenu[props.item.id + '_oac']=false"
                                    no-title
                            ></v-date-picker>
                        </v-menu>
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
                        <v-menu
                                v-model="dateMenu[props.item.id + '_mac']"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                full-width
                                max-width="290px"
                                min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                        :value="getField(props.item.id, 'mac') || props.item.mac"
                                        @input="changeField(props.item.id, 'mac', $event)"
                                        label="MAC"
                                        hint="YYYY-MM-DD format"
                                        persistent-hint
                                        prepend-icon="mdi-calendar"
                                        v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                    :value="props.item.mac"
                                    @input="changeField(props.item.id, 'mac', $event);dateMenu[props.item.id + '_mac']=false"
                                    no-title
                            ></v-date-picker>
                        </v-menu>
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
                        <v-menu
                                v-model="dateMenu[props.item.id + '_warranty_completion']"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                full-width
                                max-width="290px"
                                min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                        :value="getField(props.item.id, 'warranty_completion') || props.item.warranty_completion"
                                        @input="changeField(props.item.id, 'warranty_completion', $event)"
                                        label="Warranty Completion"
                                        hint="YYYY-MM-DD format"
                                        persistent-hint
                                        prepend-icon="mdi-calendar"
                                        v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                    :value="props.item.warranty_completion"
                                    @input="changeField(props.item.id, 'warranty_completion', $event);dateMenu[props.item.id + '_warranty_completion']=false"
                                    no-title
                            ></v-date-picker>
                        </v-menu>
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
                                :value="getField(props.item.id, 'remark') || props.item.remark"
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
                addRowPopup: false,
                newRecordFields: [],
                newRecordExceptFields: ['no', 'installed_quantity_ecc', 'installed_quantity_pc'],
                dateMenu: {},
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
                        text: 'District',
                        align: 'center',
                        value: 'district',
                    },
                    {
                        text: 'School',
                        align: 'center',
                        value: 'school',
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
                        text: 'Survey',
                        align: 'center',
                        value: 'survey',
                    },
                    {
                        text: 'Out of W/H',
                        align: 'center',
                        value: 'out_wh',
                    },
                    {
                        text: 'Site Arrived Inspection',
                        align: 'center',
                        value: 'site_arrival_inspection',
                    },
                    {
                        text: 'Installation',
                        align: 'center',
                        value: 'installation',
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
                        text: 'Warranty Completion',
                        align: 'center',
                        value: 'warranty_completion',
                    },
                    {
                        text: 'Q`ty of ECC',
                        align: 'center',
                        value: 'installed_quantity_ecc',
                    },
                    {
                        text: 'Q`ty of PC',
                        align: 'center',
                        value: 'installed_quantity_pc',
                    },
                    {
                        text: 'Remark',
                        align: 'center',
                        value: 'remark',
                    },
                ],
            }
        },
        computed: {
            items() {
                return this.$store.state.progressrate.detailList.filter(item => {
                    if (
                        this.filter.region.value !== 'All' &&
                        this.filter.region.value !== item.region
                    ) {
                        return false;
                    }

                    if (
                        this.filter.district.value !== 'All' &&
                        this.filter.district.value !== item.district
                    ) {
                        return false;
                    }

                    if (
                        this.filter.school.value !== 'All' &&
                        this.filter.school.value !== item.school
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
                        this.filter.installation.value !== 'All' &&
                        this.filter.installation.value !== item.installation
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
                    return true;
                });
            },
            filter() {
                return this.$store.state.progressrate.filter;
            }
        },
        created() {
            this.$options.service.detailInit();
            for(let key in this.headers) {
                if(this.newRecordExceptFields.indexOf(this.headers[key].value) === -1) {
                    this.newRecordFields.push({
                        label: this.headers[key].text,
                        value: ''
                    });
                }
            }
        },
        methods: {
            saveNewColumn() {
                this.$options.service.addRecord(this.newRecordFields, false, () => {
                    this.addRowPopup = false;
                });
            },
            changeField(id, key, val, send, isNumber) {
                this.$logger.info(id, key, val);
                this.changedFields[id] = this.changedFields[id] || {};
                this.changedFields[id][key] = val;

                if(isNumber) {
                    this.changedFields[id][key] = isNumber === 'int' ? parseInt(this.changedFields[id][key]) : parseFloat(this.changedFields[id][key]);
                }

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
                this.isLoading = true;
                this.$options.service.submit(this.files, () => {
                    this.files = [];
                    this.isLoading = false;
                }, true);
            },
            getField(id, key) {
                if(this.changedFields[id] && this.changedFields[id][key]) {
                    return this.changedFields[id][key];
                }
                return null;
            },
            filterChanged(val, key) {
                const newFilter = Object.assign({}, this.filter);
                newFilter[key].value = val;
                this.$store.commit('progressrate/changeFilter', newFilter);
                console.log(val);
            }
        },
        components: {
            PageBox,
            File
        }
    }
</script>
