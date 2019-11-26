<template>
    <PageBox class="module-progressrate">
        <!--p>
            <v-btn color="primary" :to="{ name: 'progressrate.list'}">List</v-btn>
            <v-btn color="primary" :to="{ name: 'progressrate.detail'}">Detail</v-btn>
            <v-btn color="default" :to="{ name: 'progressrate.checkList'}">Check list</v-btn>
        </p-->

        <p>
            <File v-if="$store.state.view.website.user.role === 'admin'" v-model="files" :extList="extensions"></File>
            <v-btn v-if="$store.state.view.website.user.role === 'admin'" @click="submitSelectedFile" color="default" :disabled="!files.length || isLoading" :loading="isLoading">{{ $t('progressrate.submit') }}</v-btn>
            <v-btn text color="default" @click="filterShow=!filterShow">Filter</v-btn>
            <v-dialog
                    v-if="$store.state.view.website.user.role === 'admin'"
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
                                :items="filter.region.list"
                                label="Region"
                                :multiple="true"
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
                                :value="filter.quantity_teacher_desk.value"
                                @input="filterChanged($event, 'quantity_teacher_desk')"
                                :items="['All', ...filter.quantity_teacher_desk.list]"
                                label="Q`ty of Desk Teacher (EA)"
                        ></v-select>
                        <v-select
                                :value="filter.quantity_student_desk.value"
                                @input="filterChanged($event, 'quantity_student_desk')"
                                :items="['All', ...filter.quantity_student_desk.list]"
                                label="Q`ty of Desk Student (EA)"
                        ></v-select>
                        <v-select
                                :value="filter.size_ecc_length.value"
                                @input="filterChanged($event, 'size_ecc_length')"
                                :items="['All', ...filter.size_ecc_length.list]"
                                label="Size of ECC Length (M)"
                        ></v-select>
                        <v-select
                                :value="filter.size_ecc_width.value"
                                @input="filterChanged($event, 'size_ecc_width')"
                                :items="['All', ...filter.size_ecc_width.list]"
                                label="Size of ECC Width (M)"
                        ></v-select>
                        <v-select
                                :value="filter.power_socket_l.value"
                                @input="filterChanged($event, 'power_socket_l')"
                                :items="['All', ...filter.power_socket_l.list]"
                                label="Power sockets L:(EA)"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-select
                                :value="filter.power_socket_r.value"
                                @input="filterChanged($event, 'power_socket_r')"
                                :items="['All', ...filter.power_socket_r.list]"
                                label="Power sockets R:(EA)"
                        ></v-select>
                        <v-select
                                :value="filter.power_socket_f.value"
                                @input="filterChanged($event, 'power_socket_f')"
                                :items="['All', ...filter.power_socket_f.list]"
                                label="Power sockets F:(EA)"
                        ></v-select>
                        <v-select
                                :value="filter.power_socket_b.value"
                                @input="filterChanged($event, 'power_socket_b')"
                                :items="['All', ...filter.power_socket_b.list]"
                                label="Power sockets B:(EA)"
                        ></v-select>
                        <v-select
                                :value="filter.circuit_breaker.value"
                                @input="filterChanged($event, 'circuit_breaker')"
                                :items="['All', ...filter.circuit_breaker.list]"
                                label="Circuit Breaker"
                        ></v-select>
                        <v-select
                                :value="filter.internet.value"
                                @input="filterChanged($event, 'internet')"
                                :items="['All', ...filter.internet.list]"
                                label="Internet"
                        ></v-select>
                    </v-col>
                </v-row>
            </v-container>
        </div>

        <v-data-table
                :headers="headers"
                :items="items"
                class="elevation-1 custom-table"
                :footer-props="{itemsPerPageOptions:[30,45,60,-1]}"
                :fixed-header="true"
                :height="420"
        >
            <template v-slot:no-data>
                <div class="text-center">No Data</div>
            </template>

            <template v-if="$store.state.view.website.user.role === 'admin'" v-slot:item.region="props">
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

            <template v-if="$store.state.view.website.user.role === 'admin'" v-slot:item.district="props">
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

            <template v-if="$store.state.view.website.user.role === 'admin'" v-slot:item.school="props">
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

            <template v-if="$store.state.view.website.user.role === 'admin'" v-slot:item.teacher_computer="props">
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

            <template v-if="$store.state.view.website.user.role === 'admin'" v-slot:item.student_computer="props">
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

            <template v-if="$store.state.view.website.user.role === 'admin'" v-slot:item.quantity_teacher_desk="props">
                <v-edit-dialog
                        :return-value.sync="props.item.quantity_teacher_desk"
                        @save="fieldSave(props.item.id, 'quantity_teacher_desk')"
                        large
                > {{ props.item.quantity_teacher_desk }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'quantity_teacher_desk') || props.item.quantity_teacher_desk"
                                @input="changeField(props.item.id, 'quantity_teacher_desk', $event)"

                                label="Q`ty of Desk Teacher (EA)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-if="$store.state.view.website.user.role === 'admin'" v-slot:item.quantity_student_desk="props">
                <v-edit-dialog
                        :return-value.sync="props.item.quantity_student_desk"
                        @save="fieldSave(props.item.id, 'quantity_student_desk')"
                        large
                > {{ props.item.quantity_student_desk }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'quantity_student_desk') || props.item.quantity_student_desk"
                                @input="changeField(props.item.id, 'quantity_student_desk', $event)"

                                label="Q`ty of Desk Student (EA)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-if="$store.state.view.website.user.role === 'admin'" v-slot:item.size_ecc_length="props">
                <v-edit-dialog
                        :return-value.sync="props.item.size_ecc_length"
                        @save="fieldSave(props.item.id, 'size_ecc_length')"
                        large
                > {{ props.item.size_ecc_length }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'size_ecc_length') || props.item.size_ecc_length"
                                @input="changeField(props.item.id, 'size_ecc_length', $event)"

                                label="Size of ECC Length (M)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-if="$store.state.view.website.user.role === 'admin'" v-slot:item.size_ecc_width="props">
                <v-edit-dialog
                        :return-value.sync="props.item.size_ecc_width"
                        @save="fieldSave(props.item.id, 'size_ecc_width')"
                        large
                > {{ props.item.size_ecc_width }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'size_ecc_width') || props.item.size_ecc_width"
                                @input="changeField(props.item.id, 'size_ecc_width', $event)"

                                label="Size of ECC Width (M)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-if="$store.state.view.website.user.role === 'admin'" v-slot:item.power_socket_l="props">
                <v-edit-dialog
                        :return-value.sync="props.item.power_socket_l"
                        @save="fieldSave(props.item.id, 'power_socket_l')"
                        large
                > {{ props.item.power_socket_l }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'power_socket_l') || props.item.power_socket_l"
                                @input="changeField(props.item.id, 'power_socket_l', $event)"

                                label="Power sockets L:(EA)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-if="$store.state.view.website.user.role === 'admin'" v-slot:item.power_socket_r="props">
                <v-edit-dialog
                        :return-value.sync="props.item.power_socket_r"
                        @save="fieldSave(props.item.id, 'power_socket_r')"
                        large
                > {{ props.item.power_socket_r }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'power_socket_r') || props.item.power_socket_r"
                                @input="changeField(props.item.id, 'power_socket_r', $event)"

                                label="Power sockets R:(EA)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-if="$store.state.view.website.user.role === 'admin'" v-slot:item.power_socket_f="props">
                <v-edit-dialog
                        :return-value.sync="props.item.power_socket_f"
                        @save="fieldSave(props.item.id, 'power_socket_f')"
                        large
                > {{ props.item.power_socket_f }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'power_socket_f') || props.item.power_socket_f"
                                @input="changeField(props.item.id, 'power_socket_f', $event)"

                                label="Power sockets F:(EA)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-if="$store.state.view.website.user.role === 'admin'" v-slot:item.power_socket_b="props">
                <v-edit-dialog
                        :return-value.sync="props.item.power_socket_b"
                        @save="fieldSave(props.item.id, 'power_socket_b')"
                        large
                > {{ props.item.power_socket_b }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'power_socket_b') || props.item.power_socket_b"
                                @input="changeField(props.item.id, 'power_socket_b', $event)"

                                label="Power sockets B:(EA)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-if="$store.state.view.website.user.role === 'admin'" v-slot:item.circuit_breaker="props">
                <v-edit-dialog
                        :return-value.sync="props.item.circuit_breaker"
                        @save="fieldSave(props.item.id, 'circuit_breaker')"
                        large
                > {{ props.item.circuit_breaker }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'circuit_breaker') || props.item.circuit_breaker"
                                @input="changeField(props.item.id, 'circuit_breaker', $event)"

                                label="Circuit Breaker"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-if="$store.state.view.website.user.role === 'admin'" v-slot:item.internet="props">
                <v-edit-dialog
                        :return-value.sync="props.item.internet"
                        @save="fieldSave(props.item.id, 'internet')"
                        large
                > {{ props.item.internet }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'internet') || props.item.internet"
                                @input="changeField(props.item.id, 'internet', $event)"

                                label="Internet"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-if="$store.state.view.website.user.role === 'admin'" v-slot:item.remark="props">
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
                newRecordExceptFields: ['no'],
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
                        text: 'Q`ty of Desk Teacher (EA)',
                        align: 'center',
                        value: 'quantity_teacher_desk',
                    },
                    {
                        text: 'Q`ty of Desk Student (EA)',
                        align: 'center',
                        value: 'quantity_student_desk',
                    },
                    {
                        text: 'Size of ECC Length (M)',
                        align: 'center',
                        value: 'size_ecc_length',
                    },
                    {
                        text: 'Size of ECC Width (M)',
                        align: 'center',
                        value: 'size_ecc_width',
                    },
                    {
                        text: 'Power sockets L:(EA)',
                        align: 'center',
                        value: 'power_socket_l',
                    },
                    {
                        text: 'Power sockets R:(EA)',
                        align: 'center',
                        value: 'power_socket_r',
                    },
                    {
                        text: 'Power sockets F:(EA)',
                        align: 'center',
                        value: 'power_socket_f',
                    },
                    {
                        text: 'Power sockets B:(EA)',
                        align: 'center',
                        value: 'power_socket_b',
                    },
                    {
                        text: 'Circuit Breaker',
                        align: 'center',
                        value: 'circuit_breaker',
                    },
                    {
                        text: 'Internet',
                        align: 'center',
                        value: 'internet',
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
                return this.$store.state.progressrate.checkList.filter(item => {
                    if (
                        this.filter.region.value.length &&
                        this.filter.region.value.indexOf(item.region) === -1
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
                        this.filter.quantity_teacher_desk.value !== 'All' &&
                        this.filter.quantity_teacher_desk.value !== item.quantity_teacher_desk
                    ) {
                        return false;
                    }

                    if (
                        this.filter.quantity_student_desk.value !== 'All' &&
                        this.filter.quantity_student_desk.value !== item.quantity_student_desk
                    ) {
                        return false;
                    }

                    if (
                        this.filter.size_ecc_length.value !== 'All' &&
                        this.filter.size_ecc_length.value !== item.size_ecc_length
                    ) {
                        return false;
                    }

                    if (
                        this.filter.size_ecc_width.value !== 'All' &&
                        this.filter.size_ecc_width.value !== item.size_ecc_width
                    ) {
                        return false;
                    }

                    if (
                        this.filter.power_socket_l.value !== 'All' &&
                        this.filter.power_socket_l.value !== item.power_socket_l
                    ) {
                        return false;
                    }

                    if (
                        this.filter.power_socket_r.value !== 'All' &&
                        this.filter.power_socket_r.value !== item.power_socket_r
                    ) {
                        return false;
                    }

                    if (
                        this.filter.power_socket_f.value !== 'All' &&
                        this.filter.power_socket_f.value !== item.power_socket_f
                    ) {
                        return false;
                    }

                    if (
                        this.filter.power_socket_b.value !== 'All' &&
                        this.filter.power_socket_b.value !== item.power_socket_b
                    ) {
                        return false;
                    }

                    if (
                        this.filter.circuit_breaker.value !== 'All' &&
                        this.filter.circuit_breaker.value !== item.circuit_breaker
                    ) {
                        return false;
                    }

                    if (
                        this.filter.internet.value !== 'All' &&
                        this.filter.internet.value !== item.internet
                    ) {
                        return false;
                    }

                    return true;
                });
            },
            filter() {
                return this.$store.state.progressrate.filterCheckList;
            }
        },
        created() {
            this.$options.service.checkListInit();
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
                this.$options.service.addRecord(this.newRecordFields, true, () => {
                    this.addRowPopup = false;
                });
            },
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
                    this.$options.service.changeFieldCheckList(id, key, this.changedFields[id][key], true);
                }
                this.changedFields = {};
            },
            submitSelectedFile() {
                this.isLoading = true;
                this.$options.service.submit(this.files, () => {
                    this.files = [];
                    this.isLoading = false;
                }, 'check-list');
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
                this.$store.commit('progressrate/changeFilterCheckList', newFilter);
                console.log(val);
            }
        },
        components: {
            PageBox,
            File
        }
    }
</script>