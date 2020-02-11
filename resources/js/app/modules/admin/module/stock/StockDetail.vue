<template>
    <PageBox class="module-progressrate">
        <!--p>
            <v-btn color="primary" :to="{ name: 'stock.list'}">Summary</v-btn>
            <v-btn :color="wh_no === '1' ? 'default' : 'primary'" :to="{ name: 'stock.detail1'}">W/H 1</v-btn>
            <v-btn :color="wh_no === '2' ? 'default' : 'primary'" :to="{ name: 'stock.detail2'}">W/H 2</v-btn>
            <v-btn :color="wh_no === '3' ? 'default' : 'primary'" :to="{ name: 'stock.detail3'}">W/H 3</v-btn>
            <v-btn :color="wh_no === '4' ? 'default' : 'primary'" :to="{ name: 'stock.detail4'}">W/H 4</v-btn>
            <v-btn :color="wh_no === '5' ? 'default' : 'primary'" :to="{ name: 'stock.detail5'}">W/H 5</v-btn>
            <v-btn :color="wh_no === '6' ? 'default' : 'primary'" :to="{ name: 'stock.detail6'}">W/H 6</v-btn>
            <v-btn :color="wh_no === '7' ? 'default' : 'primary'" :to="{ name: 'stock.detail7'}">W/H 7</v-btn>
        </p-->
        <p>
            <File v-if="$store.state.view.website.user.role === 'admin'" v-model="files" :extList="extensions"></File>
            <v-btn v-if="$store.state.view.website.user.role === 'admin'" @click="submitSelectedFile" color="default" :disabled="!files.length || isLoading"
                   :loading="isLoading">{{ $t('progressrate.submit') }}
            </v-btn>
            <v-btn text color="default" @click="filterShow=!filterShow">Filter</v-btn>
            <span v-if="$store.state.view.website.user.role === 'admin'" class="d-inline-block"><v-switch v-model="isEditMode" label="Edit" color="primary"></v-switch></span>
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
            <v-dialog
                    v-if="$store.state.view.website.user.role === 'admin'"
                    v-model="editInColumnPopup"
                    width="500"
            >
                <template v-slot:activator="{ on }">
                    <v-btn
                            color="default"
                            v-on="on"
                    >
                        Add column
                    </v-btn>
                </template>

                <v-card>
                    <v-card-title
                            class="headline grey lighten-2"
                            primary-title
                    >
                        Add column
                    </v-card-title>

                    <v-card-text>
                        <draggable tag="ul" :list="inColumnsList" draggable=".list-group-item" class="list-group draggable-list" handle=".handle">
                            <li
                                    class="list-group-item"
                                    v-for="(element, idx) in inColumnsList"
                                    :key="element.value"
                            >
                                <v-icon class="handle">mdi-menu</v-icon>
                                <v-text-field class="name-input" v-model="element.text"></v-text-field>
                                <v-icon class="close" @click="removeInColumn(idx)">mdi-close</v-icon>
                            </li>
                            <button slot="footer" @click="addInColumn">Add</button>
                        </draggable>
                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                                color="primary"
                                text
                                @click="saveEditInColumn"
                        >
                            Save
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <v-dialog
                    v-if="false && $store.state.view.website.user.role === 'admin'"
                    v-model="editOutColumnPopup"
                    width="500"
            >
                <template v-slot:activator="{ on }">
                    <v-btn
                            color="default"
                            v-on="on"
                    >
                        Add out column
                    </v-btn>
                </template>

                <v-card>
                    <v-card-title
                            class="headline grey lighten-2"
                            primary-title
                    >
                        Add column
                    </v-card-title>

                    <v-card-text>
                        <draggable tag="ul" :list="outColumnsList" draggable=".list-group-item" class="list-group draggable-list" handle=".handle">
                            <li
                                    class="list-group-item"
                                    v-for="(element, idx) in outColumnsList"
                                    :key="element.value"
                            >
                                <v-icon class="handle">mdi-menu</v-icon>
                                <v-text-field class="name-input" v-model="element.text"></v-text-field>
                                <v-icon class="close" @click="removeOutColumn(idx)">mdi-close</v-icon>
                            </li>
                            <button slot="footer" @click="addOutColumn">Add</button>
                        </draggable>
                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                                color="primary"
                                text
                                @click="saveEditOutColumn"
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
                                :value="filter.item.value"
                                @input="filterChanged($event, 'item')"
                                :items="filter.item.list"
                                label="Item"
                                :multiple="true"
                        ></v-select>
                        <v-select
                                :value="filter.unit.value"
                                @input="filterChanged($event, 'unit')"
                                :items="['All', ...filter.unit.list]"
                                label="Unit"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-select
                                :value="filter.total_a.value"
                                @input="filterChanged($event, 'total_a')"
                                :items="['All', ...filter.total_a.list]"
                                label="Total (A)"
                        ></v-select>
                        <v-select
                                :value="filter.total_b.value"
                                @input="filterChanged($event, 'total_b')"
                                :items="['All', ...filter.total_b.list]"
                                label="Total (B)"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-select
                                :value="filter.total_ab.value"
                                @input="filterChanged($event, 'total_ab')"
                                :items="['All', ...filter.total_ab.list]"
                                label="Total (A - B)"
                        ></v-select>
                    </v-col>
                </v-row>
            </v-container>
        </div>
        <v-data-table
                :headers="headers"
                :items="items"
                class="elevation-1"
                @click:row="clickRow"
                v-model="selected"
                :footer-props="{itemsPerPageOptions:[30,45,60,-1]}"
                :fixed-header="true"
                :height="420"
        >
            <template v-slot:no-data>
                <div class="text-center">No Data</div>
            </template>

            <template v-slot:item.item="props" v-if="$store.state.view.website.user.role === 'admin'">
                <v-edit-dialog
                        :return-value.sync="props.item.item"
                        @save="fieldSave(props.item.id, 'item')"
                        large
                > {{ props.item.item }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'item') || props.item.item"
                                @input="changeField(props.item.id, 'item', $event)"

                                label="Item"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.unit="props" v-if="$store.state.view.website.user.role === 'admin'">
                <v-edit-dialog
                        :return-value.sync="props.item.unit"
                        @save="fieldSave(props.item.id, 'unit')"
                        large
                > {{ props.item.unit }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'unit') || props.item.unit"
                                @input="changeField(props.item.id, 'unit', $event)"

                                label="Unit"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.remark="props" v-if="$store.state.view.website.user.role === 'admin'">
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

            <template v-for="inItem of inColumnsCells" v-slot:[inItem.key]="props" v-if="$store.state.view.website.user.role === 'admin'">
                <v-edit-dialog
                        :return-value.sync="props.item[inItem.name]"
                        @save="fieldSave(props.item.id, inItem.name)"
                        large
                > {{ props.item[inItem.name] }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, inItem.name) || props.item[inItem.name]"
                                @input="changeField(props.item.id, inItem.name, $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-for="item of outColumnsCells" v-slot:[item.key]="props" v-if="$store.state.view.website.user.role === 'admin'">
                <v-edit-dialog
                        :return-value.sync="props.item[item.name]"
                        @save="fieldSave(props.item.id, item.name)"
                        large
                > {{ props.item[item.name] }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, item.name) || props.item[item.name]"
                                @input="changeField(props.item.id, item.name, $event)"
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
    import draggable from 'vuedraggable'
    import PageBox from '../../view/partial/PageBox';
    import File from '../../component/File';
    import Service from './service';

    const defaultHeaders = [
        {
            text: 'No',
            align: 'center',
            value: 'no',
            width: 50
        },
        {
            text: 'Item',
            align: 'center',
            value: 'item'
        },
        {
            text: 'Unit',
            align: 'center',
            value: 'unit'
        }
    ];

    export default {
        service: new Service(),
        data() {
            return {
                outColumnsCells: [],
                inColumnsCells: [],
                addRowPopup: false,
                inColumnsList: [],
                editInColumnPopup: false,
                outColumnsList: [],
                editOutColumnPopup: false,
                isEditMode: false,
                selected: [],
                changedFields: {},
                wh_no: 0,
                filterShow: false,
                files: [],
                extensions: ['xlsx'],
                isLoading: false,
                headers: [],
                newRecordFields: [],
                newRecordExceptFields: ['no', 'total_ab'],
                columns: []
            }
        },
        computed: {
            items() {
                return this.$store.state.stock.detail.filter(item => {
                    if(parseInt(item.id) === 0) {
                        return this.isEditMode;
                    }

                    if(this.isEditMode || parseInt(item.id) === -1) {
                        return false;
                    }

                    if (
                        this.filter.item.value.length &&
                        this.filter.item.value.indexOf(item.item) === -1
                    ) {
                        return false;
                    }

                    if (
                        this.filter.unit.value !== 'All' &&
                        this.filter.unit.value !== item.unit
                    ) {
                        return false;
                    }

                    if (
                        this.filter.total_a.value !== 'All' &&
                        this.filter.total_a.value !== item.total_a
                    ) {
                        return false;
                    }

                    if (
                        this.filter.total_b.value !== 'All' &&
                        this.filter.total_b.value !== item.total_b
                    ) {
                        return false;
                    }

                    if (
                        this.filter.total_ab.value !== 'All' &&
                        this.filter.total_ab.value !== item.total_ab
                    ) {
                        return false;
                    }

                    return true;
                });
            },
            filter() {
                return this.$store.state.stock.detailFilter;
            }
        },
        created() {
            for(let i = 6; i <= 350; i++) {
                this.outColumnsCells.push({key: 'item.out_column_' + i, name: 'out_column_' + i});
            }
            for(let i = 1; i <= 350; i++) {
                this.inColumnsCells.push({key: 'item.in_column_' + i, name: 'in_column_' + i});
            }
            this.changeWh();
        },
        watch: {
            '$route'() {
                this.changeWh();
            },
            isEditMode() {
                this.changeColumns();
            },
            columns(val) {
                this.inColumnsList = val.in || [];
                this.outColumnsList = val.out || [];
            },
            headers(val) {
                this.newRecordFields = [];
                for(let key in val) {
                    if(this.newRecordExceptFields.indexOf(val[key].value) === -1) {
                        this.newRecordFields.push({
                            label: val[key].text,
                            value: ''
                        });
                    }
                }
            }
        },
        methods: {
            saveNewColumn() {
                this.$options.service.addRecord(this.newRecordFields, this.wh_no, columns => {
                    console.log('columns', columns);
                    this.columns = columns;
                    this.changeColumns();
                    this.addRowPopup = false;
                });
            },
            saveEditInColumn() {
                this.$options.service.changeColumn(this.inColumnsList, this.wh_no, true, columns => {
                    console.log('columns', columns);
                    this.columns = columns;
                    this.changeColumns();
                    this.editInColumnPopup = false;
                });
            },
            removeInColumn(idx) {
                this.inColumnsList.splice(idx, 1);
            },
            addInColumn() {
                this.inColumnsList.push({
                    "text":"",
                    "align":"center",
                    "width":"115px",
                    "value":"column_" + (new Date()).getTime(),
                    "sortable":false
                });
            },
            saveEditOutColumn() {
                this.$options.service.changeColumn(this.outColumnsList, this.wh_no, false, columns => {
                    console.log('columns', columns);
                    this.columns = columns;
                    this.changeColumns();
                    this.editOutColumnPopup = false;
                });
            },
            removeOutColumn(idx) {
                this.outColumnsList.splice(idx, 1);
            },
            addOutColumn() {
                this.outColumnsList.push({
                    "text":"",
                    "align":"center",
                    "width":"115px",
                    "value":"column_" + (new Date()).getTime(),
                    "sortable":false
                });
            },
            clickRow(item) {
                this.$logger.info('clickrow', item);
                const index = this.selected.indexOf(item);
                if(index > -1) {
                    this.selected.splice(index, 1);
                } else {
                    this.selected.push(item);
                }
            },
            changeColumns() {
                let columns = this.columns;
                this.headers = [];
                if(!this.isEditMode) {
                    for (let key in defaultHeaders) {
                        this.headers.push(defaultHeaders[key]);
                    }
                }

                for (let key in columns.in) {
                    console.log(columns.in[key]);
                    let item = Object.assign({}, columns.in[key]);

                    if(this.isEditMode) {
                        item.text = '';
                    }

                    this.headers.push(item);
                }

                if(!this.isEditMode) {
                    /*this.headers.push({
                        text: 'Total (A)',
                        align: 'center',
                        value: 'total_a'
                    });*/
                }

                for (let key in columns.out) {
                    console.log(columns.out[key]);
                    let item = Object.assign({}, columns.out[key]);

                    if(this.isEditMode) {
                        item.text = '';
                    }

                    this.headers.push(item);
                }

                if(!this.isEditMode) {
                    /*this.headers.push({
                        text: 'Total (B)',
                        align: 'center',
                        value: 'total_b'
                    });

                    this.headers.push({
                        text: 'Total (A-B)',
                        align: 'center',
                        value: 'total_ab'
                    });

                    this.headers.push({
                        text: 'Remark',
                        align: 'center',
                        value: 'remark'
                    });*/
                }
            },
            changeWh() {
                let routeName = this.$router.currentRoute.name;
                this.wh_no = routeName.replace('stock.detail', '');

                this.$store.commit('stock/changeDetail', []);


                this.$options.service.detailInit(this.wh_no, '', columns => {
                    console.log('columns', columns);
                    this.columns = columns;
                    this.changeColumns();
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
                    this.$options.service.changeFieldDetail(id, key, this.changedFields[id][key], true, this.wh_no, columns => {
                        console.log('columns', columns);
                        this.columns = columns;
                        this.changeColumns();
                    });
                }
                this.changedFields = {};
            },
            submitSelectedFile() {
                this.isLoading = true;
                this.$options.service.submit(this.files, () => {
                    this.files = [];
                    this.isLoading = false;
                }, true, this.wh_no, columns => {
                    console.log('columns', columns);
                    this.columns = columns;
                    this.changeColumns();
                });
            },
            filterChanged(val, key) {
                const newFilter = Object.assign({}, this.filter);
                newFilter[key].value = val;
                this.$store.commit('stock/changeDetailFilter', newFilter);
                console.log(val);
            },
            getField(id, key) {
                if (this.changedFields[id] && this.changedFields[id][key]) {
                    return this.changedFields[id][key];
                }
                return null;
            },
        },
        components: {
            PageBox,
            File,
            draggable
        }
    }
</script>
