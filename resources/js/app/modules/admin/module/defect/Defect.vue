<template>
    <PageBox class="module-dashboard">
        <div>
            <File v-model="files" :extList="extensions" btnTitle="Update"></File>
            <v-btn @click="submitSelectedFile" color="default" :disabled="!files.length || isLoading">{{ $t('defect.submit') }}</v-btn>
            <v-btn text color="default" @click="filterShow=!filterShow">Filter</v-btn>
        </div>

        <div v-show="filterShow">
            <v-container class="grey lighten-5">
                <v-row no-gutters>
                    <v-col cols="12" sm="4">
                        <v-select
                                :value="filter.date.value"
                                @input="filterChanged($event, 'date')"
                                :items="['All', ...filter.date.list]"
                                label="Date"
                        ></v-select>
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
                                :value="filter.from_user.value"
                                @input="filterChanged($event, 'from_user')"
                                :items="['All', ...filter.from_user.list]"
                                label="From user"
                        ></v-select>
                        <v-select
                                :value="filter.user_phone.value"
                                @input="filterChanged($event, 'user_phone')"
                                :items="['All', ...filter.user_phone.list]"
                                label="User phone"
                        ></v-select>
                        <v-select
                                :value="filter.received_user.value"
                                @input="filterChanged($event, 'received_user')"
                                :items="['All', ...filter.received_user.list]"
                                label="Received user"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-select
                                :value="filter.product1.value"
                                @input="filterChanged($event, 'product1')"
                                :items="['All', ...filter.product1.list]"
                                label="PC"
                        ></v-select>
                        <v-select
                                :value="filter.product2.value"
                                @input="filterChanged($event, 'product2')"
                                :items="['All', ...filter.product2.list]"
                                label="Mouse"
                        ></v-select>
                        <v-select
                                :value="filter.product3.value"
                                @input="filterChanged($event, 'product3')"
                                :items="['All', ...filter.product3.list]"
                                label="Keyboard"
                        ></v-select>
                        <v-select
                                :value="filter.product4.value"
                                @input="filterChanged($event, 'product4')"
                                :items="['All', ...filter.product4.list]"
                                label="Monitor"
                        ></v-select>
                        <v-select
                                :value="filter.product5.value"
                                @input="filterChanged($event, 'product5')"
                                :items="['All', ...filter.product5.list]"
                                label="Laser printer"
                        ></v-select>
                        <v-select
                                :value="filter.product6.value"
                                @input="filterChanged($event, 'product6')"
                                :items="['All', ...filter.product6.list]"
                                label="AVR"
                        ></v-select>
                        <v-select
                                :value="filter.product7.value"
                                @input="filterChanged($event, 'product7')"
                                :items="['All', ...filter.product7.list]"
                                label="Network switch"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-select
                                :value="filter.replacement_part.value"
                                @input="filterChanged($event, 'replacement_part')"
                                :items="['All', ...filter.replacement_part.list]"
                                label="Replacement part"
                        ></v-select>
                        <v-select
                                :value="filter.recovery.value"
                                @input="filterChanged($event, 'recovery')"
                                :items="['All', ...filter.recovery.list]"
                                label="Recovery"
                        ></v-select>
                        <v-select
                                :value="filter.replacement_pc.value"
                                @input="filterChanged($event, 'replacement_pc')"
                                :items="['All', ...filter.replacement_pc.list]"
                                label="Replcaement PC"
                        ></v-select>
                        <v-select
                                :value="filter.done.value"
                                @input="filterChanged($event, 'done')"
                                :items="['All', ...filter.done.list]"
                                label="Done"
                        ></v-select>
                        <v-select
                                :value="filter.manager.value"
                                @input="filterChanged($event, 'manager')"
                                :items="['All', ...filter.manager.list]"
                                label="Manager"
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
            <template v-slot:item.date="props">
                <v-edit-dialog
                        :return-value.sync="props.item.date"
                        @save="fieldSave(props.item.id, 'date')"
                        large
                > {{ props.item.date }}
                    <template v-slot:input>
                        <v-menu
                                v-model="dateMenu[props.item.id + '_date']"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                full-width
                                max-width="290px"
                                min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                        :value="getField(props.item.id, 'date') || props.item.date"
                                        label="Date"
                                        hint="YYYY-MM-DD format"
                                        persistent-hint
                                        prepend-icon="mdi-calendar"
                                        v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                    :value="props.item.date"
                                    @input="changeField(props.item.id, 'date', $event);dateMenu[props.item.id + '_date']=false"
                                    no-title
                            ></v-date-picker>
                        </v-menu>
                    </template>
                </v-edit-dialog>
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
            <template v-slot:item.from_user_name="props">
                <v-edit-dialog
                        :return-value.sync="props.item.from_user_name"
                        @save="fieldSave(props.item.id, 'from_user_name')"
                        large
                > {{ props.item.from_user_name }}
                    <template v-slot:input>
                        <v-text-field
                                :value="props.item.from_user_name"
                                @input="changeField(props.item.id, 'from_user_name', $event)"

                                label="User name"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.from_user_phone="props">
                <v-edit-dialog
                        :return-value.sync="props.item.from_user_phone"
                        @save="fieldSave(props.item.id, 'from_user_phone')"
                        large
                > {{ props.item.from_user_phone }}
                    <template v-slot:input>
                        <v-text-field
                                :value="props.item.from_user_phone"
                                @input="changeField(props.item.id, 'from_user_phone', $event)"

                                label="User phone"
                                single-line
                                counter
                                v-mask="phoneMask"
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.received_user_name="props">
                <v-edit-dialog
                        :return-value.sync="props.item.received_user_name"
                        @save="fieldSave(props.item.id, 'received_user_name')"
                        large
                > {{ props.item.received_user_name }}
                    <template v-slot:input>
                        <v-text-field
                                :value="props.item.received_user_name"
                                @input="changeField(props.item.id, 'received_user_name', $event)"

                                label="Received user"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.product1="props">
                <v-edit-dialog
                        :return-value.sync="props.item.product1"
                        @save="fieldSave(props.item.id, 'product1')"
                        large
                > {{ props.item.product1 }}
                    <template v-slot:input>
                        <v-select
                                :value="props.item.product1"
                                @input="changeField(props.item.id, 'product1', $event)"
                                :items="['', 'O']"
                                label="PC"
                        ></v-select>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.product2="props">
                <v-edit-dialog
                        :return-value.sync="props.item.product2"
                        @save="fieldSave(props.item.id, 'product2')"
                        large
                > {{ props.item.product2 }}
                    <template v-slot:input>
                        <v-select
                                :value="props.item.product2"
                                @input="changeField(props.item.id, 'product2', $event)"
                                :items="['', 'O']"
                                label="Mouse"
                        ></v-select>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.product3="props">
                <v-edit-dialog
                        :return-value.sync="props.item.product3"
                        @save="fieldSave(props.item.id, 'product3')"
                        large
                > {{ props.item.product3 }}
                    <template v-slot:input>
                        <v-select
                                :value="props.item.product3"
                                @input="changeField(props.item.id, 'product3', $event)"
                                :items="['', 'O']"
                                label="Keyboard"
                        ></v-select>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.product4="props">
                <v-edit-dialog
                        :return-value.sync="props.item.product4"
                        @save="fieldSave(props.item.id, 'product4')"
                        large
                > {{ props.item.product4 }}
                    <template v-slot:input>
                        <v-select
                                :value="props.item.product4"
                                @input="changeField(props.item.id, 'product4', $event)"
                                :items="['', 'O']"
                                label="Monitor"
                        ></v-select>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.product5="props">
                <v-edit-dialog
                        :return-value.sync="props.item.product5"
                        @save="fieldSave(props.item.id, 'product5')"
                        large
                > {{ props.item.product5 }}
                    <template v-slot:input>
                        <v-select
                                :value="props.item.product5"
                                @input="changeField(props.item.id, 'product5', $event)"
                                :items="['', 'O']"
                                label="Laser printer"
                        ></v-select>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.product6="props">
                <v-edit-dialog
                        :return-value.sync="props.item.product6"
                        @save="fieldSave(props.item.id, 'product6')"
                        large
                > {{ props.item.product6 }}
                    <template v-slot:input>
                        <v-select
                                :value="props.item.product6"
                                @input="changeField(props.item.id, 'product6', $event)"
                                :items="['', 'O']"
                                label="AVR"
                        ></v-select>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.product7="props">
                <v-edit-dialog
                        :return-value.sync="props.item.product7"
                        @save="fieldSave(props.item.id, 'product7')"
                        large
                > {{ props.item.product7 }}
                    <template v-slot:input>
                        <v-select
                                :value="props.item.product7"
                                @input="changeField(props.item.id, 'product7', $event)"
                                :items="['', 'O']"
                                label="Network switch"
                        ></v-select>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.comment="props">
                <v-edit-dialog
                        :return-value.sync="props.item.comment"
                        @save="fieldSave(props.item.id, 'comment')"
                        large
                > {{ props.item.comment }}
                    <template v-slot:input>
                        <v-text-field
                                :value="props.item.comment"
                                @input="changeField(props.item.id, 'comment', $event)"

                                label="Comment"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.replacement_part="props">
                <v-edit-dialog
                        :return-value.sync="props.item.replacement_part"
                        @save="fieldSave(props.item.id, 'replacement_part')"
                        large
                > {{ props.item.replacement_part }}
                    <template v-slot:input>
                        <v-select
                                :value="props.item.replacement_part"
                                @input="changeField(props.item.id, 'replacement_part', $event)"
                                :items="['', 'O']"
                                label="Replacement part"
                        ></v-select>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.recovery="props">
                <v-edit-dialog
                        :return-value.sync="props.item.recovery"
                        @save="fieldSave(props.item.id, 'recovery')"
                        large
                > {{ props.item.recovery }}
                    <template v-slot:input>
                        <v-select
                                :value="props.item.recovery"
                                @input="changeField(props.item.id, 'recovery', $event)"
                                :items="['', 'O']"
                                label="Recovery"
                        ></v-select>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.replacement_pc="props">
                <v-edit-dialog
                        :return-value.sync="props.item.replacement_pc"
                        @save="fieldSave(props.item.id, 'replacement_pc')"
                        large
                > {{ props.item.replacement_pc }}
                    <template v-slot:input>
                        <v-select
                                :value="props.item.replacement_pc"
                                @input="changeField(props.item.id, 'replacement_pc', $event)"
                                :items="['', 'O']"
                                label="Replcaement pc"
                        ></v-select>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.date_done="props">
                <v-edit-dialog
                        :return-value.sync="props.item.date_done"
                        @save="fieldSave(props.item.id, 'date_done')"
                        large
                > {{ props.item.date_done }}
                    <template v-slot:input>
                        <v-menu
                                v-model="dateMenu[props.item.id + '_date_done']"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                full-width
                                max-width="290px"
                                min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                        :value="getField(props.item.id, 'date_done') || props.item.date_done"
                                        label="Date done"
                                        hint="YYYY-MM-DD format"
                                        persistent-hint
                                        prepend-icon="mdi-calendar"
                                        v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                    :value="props.item.date_done"
                                    @input="changeField(props.item.id, 'date_done', $event);dateMenu[props.item.id + '_date_done']=false"
                                    no-title
                            ></v-date-picker>
                        </v-menu>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.manager_name="props">
                <v-edit-dialog
                        :return-value.sync="props.item.manager_name"
                        @save="fieldSave(props.item.id, 'manager_name')"
                        large
                > {{ props.item.manager_name }}
                    <template v-slot:input>
                        <v-text-field
                                :value="props.item.manager_name"
                                @input="changeField(props.item.id, 'manager_name', $event)"

                                label="Manager"
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
    import {mask} from 'vue-the-mask'

    export default {
        directives: {mask},
        service: new Service(),
        data() {
            return {
                dateMenu: {},
                phoneMask: '+### (##) ###-##-##',
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
                        text: 'Date',
                        align: 'center',
                        value: 'date',
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
                        text: 'From user',
                        align: 'center',
                        value: 'from_user_name',
                    },
                    {
                        text: 'User phone',
                        align: 'center',
                        value: 'from_user_phone',
                    },
                    {
                        text: 'Received user',
                        align: 'center',
                        value: 'received_user_name',
                    },
                    {
                        text: 'PC',
                        align: 'center',
                        value: 'product1',
                    },
                    {
                        text: 'Mouse',
                        align: 'center',
                        value: 'product2',
                    },
                    {
                        text: 'Keyboard',
                        align: 'center',
                        value: 'product3',
                    },
                    {
                        text: 'Monitor',
                        align: 'center',
                        value: 'product4',
                    },
                    {
                        text: 'Laser printer',
                        align: 'center',
                        value: 'product5',
                    },
                    {
                        text: 'AVR',
                        align: 'center',
                        value: 'product6',
                    },
                    {
                        text: 'Network switch',
                        align: 'center',
                        value: 'product7',
                    },
                    {
                        text: 'Comment',
                        align: 'center',
                        value: 'comment',
                    },
                    {
                        text: 'Replacement part',
                        align: 'center',
                        value: 'replacement_part',
                    },
                    {
                        text: 'Recovery',
                        align: 'center',
                        value: 'recovery',
                    },
                    {
                        text: 'Replacement pc',
                        align: 'center',
                        value: 'replacement_pc',
                    },
                    {
                        text: 'Done',
                        align: 'center',
                        value: 'date_done',
                    },
                    {
                        text: 'Manager',
                        align: 'center',
                        value: 'manager_name',
                    },
                ],
            }
        },
        computed: {
            items() {
                return this.$store.state.defect.list.filter(item => {
                    if (
                        this.filter.date.value !== 'All' &&
                        this.filter.date.value !== item.date
                    ) {
                        return false;
                    }

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
                        this.filter.from_user.value !== 'All' &&
                        this.filter.from_user.value !== item.from_user_name
                    ) {
                        return false;
                    }

                    if (
                        this.filter.user_phone.value !== 'All' &&
                        this.filter.user_phone.value !== item.from_user_phone
                    ) {
                        return false;
                    }

                    if (
                        this.filter.received_user.value !== 'All' &&
                        this.filter.received_user.value !== item.received_user_name
                    ) {
                        return false;
                    }

                    if (
                        this.filter.product1.value !== 'All' &&
                        this.filter.product1.value !== item.product1
                    ) {
                        return false;
                    }

                    if (
                        this.filter.product2.value !== 'All' &&
                        this.filter.product2.value !== item.product2
                    ) {
                        return false;
                    }

                    if (
                        this.filter.product3.value !== 'All' &&
                        this.filter.product3.value !== item.product3
                    ) {
                        return false;
                    }

                    if (
                        this.filter.product4.value !== 'All' &&
                        this.filter.product4.value !== item.product4
                    ) {
                        return false;
                    }

                    if (
                        this.filter.product5.value !== 'All' &&
                        this.filter.product5.value !== item.product5
                    ) {
                        return false;
                    }

                    if (
                        this.filter.product6.value !== 'All' &&
                        this.filter.product6.value !== item.product6
                    ) {
                        return false;
                    }

                    if (
                        this.filter.product7.value !== 'All' &&
                        this.filter.product7.value !== item.product7
                    ) {
                        return false;
                    }

                    if (
                        this.filter.replacement_part.value !== 'All' &&
                        this.filter.replacement_part.value !== item.replacement_part
                    ) {
                        return false;
                    }

                    if (
                        this.filter.recovery.value !== 'All' &&
                        this.filter.recovery.value !== item.recovery
                    ) {
                        return false;
                    }

                    if (
                        this.filter.replacement_pc.value !== 'All' &&
                        this.filter.replacement_pc.value !== item.replacement_pc
                    ) {
                        return false;
                    }

                    if (
                        this.filter.done.value !== 'All' &&
                        this.filter.done.value !== item.date_done
                    ) {
                        return false;
                    }

                    if (
                        this.filter.manager.value !== 'All' &&
                        this.filter.manager.value !== item.manager_name
                    ) {
                        return false;
                    }

                    return true;
                });
            },
            filter() {
                return this.$store.state.defect.filter;
            }
        },
        created() {
            //this.$logger.log('test1', {a: 1});
            this.$options.service.init();
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
            getField(id, key) {
                if(this.changedFields[id] && this.changedFields[id][key]) {
                    return this.changedFields[id][key];
                }
                return null;
            },
            fieldSave(id, key) {
                if(typeof this.changedFields[id] !== 'undefined' && typeof this.changedFields[id][key] !== 'undefined') {
                    this.$logger.info('changed field', id, key, this.changedFields[id][key]);
                    this.$options.service.changeField(id, key, this.changedFields[id][key]);
                }
                this.changedFields = {};
            },
            submitSelectedFile() {
                this.$options.service.submit(this.files, () => {
                    this.files = [];
                });
            },
            filterChanged(val, key) {
                const newFilter = Object.assign({}, this.filter);
                newFilter[key].value = val;
                this.$store.commit('defect/changeFilter', newFilter);
                console.log(val);
            }
        },
        watch: {
            //
        },
        components: {
            PageBox,
            File
        }
    }
</script>
