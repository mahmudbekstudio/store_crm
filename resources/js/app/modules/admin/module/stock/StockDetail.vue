<template>
    <PageBox class="module-progressrate">
        <p>
            <v-btn color="primary" :to="{ name: 'stock.list'}">Summary</v-btn>
            <v-btn :color="wh_no === '1' ? 'default' : 'primary'" :to="{ name: 'stock.detail1'}">W/H 1</v-btn>
            <v-btn :color="wh_no === '2' ? 'default' : 'primary'" :to="{ name: 'stock.detail2'}">W/H 2</v-btn>
            <v-btn :color="wh_no === '3' ? 'default' : 'primary'" :to="{ name: 'stock.detail3'}">W/H 3</v-btn>
            <v-btn :color="wh_no === '4' ? 'default' : 'primary'" :to="{ name: 'stock.detail4'}">W/H 4</v-btn>
            <v-btn :color="wh_no === '5' ? 'default' : 'primary'" :to="{ name: 'stock.detail5'}">W/H 5</v-btn>
            <v-btn :color="wh_no === '6' ? 'default' : 'primary'" :to="{ name: 'stock.detail6'}">W/H 6</v-btn>
            <v-btn :color="wh_no === '7' ? 'default' : 'primary'" :to="{ name: 'stock.detail7'}">W/H 7</v-btn>
        </p>
        <p>
            <File v-model="files" :extList="extensions"></File>
            <v-btn @click="submitSelectedFile" color="default" :disabled="!files.length || isLoading"
                   :loading="isLoading">{{ $t('progressrate.submit') }}
            </v-btn>
            <v-btn text color="default" @click="filterShow=!filterShow">Filter</v-btn>
        </p>
        <div v-show="filterShow">
            <v-container class="grey lighten-5">
                <v-row no-gutters>
                    <v-col cols="12" sm="4">
                        <v-select
                                :value="filter.item.value"
                                @input="filterChanged($event, 'item')"
                                :items="['All', ...filter.item.list]"
                                label="Item"
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
                :items-per-page="5"
        >
            <template v-slot:no-data>
                <div class="text-center">No Data</div>
            </template>

            <template v-slot:item.item="props">
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

            <template v-slot:item.unit="props">
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

            <template v-slot:item.total_a="props">
                <v-edit-dialog
                        :return-value.sync="props.item.total_a"
                        @save="fieldSave(props.item.id, 'total_a')"
                        large
                > {{ props.item.total_a }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'total_a') || props.item.total_a"
                                @input="changeField(props.item.id, 'total_a', $event)"

                                label="Total (A)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.total_b="props">
                <v-edit-dialog
                        :return-value.sync="props.item.total_b"
                        @save="fieldSave(props.item.id, 'total_b')"
                        large
                > {{ props.item.total_b }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'total_b') || props.item.total_b"
                                @input="changeField(props.item.id, 'total_b', $event)"

                                label="Total (B)"
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
                changedFields: {},
                wh_no: 0,
                filterShow: false,
                files: [],
                extensions: ['xlsx'],
                isLoading: false,
                headers: [
                    {
                        text: 'Id',
                        align: 'center',
                        value: 'id',
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
                ],
            }
        },
        computed: {
            items() {
                return this.$store.state.stock.detail.filter(item => {
                    if (
                        this.filter.item.value !== 'All' &&
                        this.filter.item.value !== item.item
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
            this.changeWh();
        },
        watch: {
            '$route'() {
                this.changeWh();
            }
        },
        methods: {
            changeWh() {
                let routeName = this.$router.currentRoute.name;
                this.wh_no = routeName.replace('stock.detail', '');

                this.$store.commit('stock/changeDetail', []);
                this.$options.service.detailInit(this.wh_no, '', columns => {
                    console.log('columns', columns);
                    for (let key in columns.in) {
                        console.log(columns.in[key]);
                        this.headers.push(columns.in[key]);
                    }

                    this.headers.push({
                        text: 'Total (A)',
                        align: 'center',
                        value: 'total_a'
                    });

                    for (let key in columns.out) {
                        console.log(columns.out[key]);
                        this.headers.push(columns.out[key]);
                    }

                    this.headers.push({
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
                    });
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
                    this.$options.service.changeFieldDetail(id, key, this.changedFields[id][key], true, this.wh_no);
                }
                this.changedFields = {};
            },
            submitSelectedFile() {
                this.isLoading = true;
                this.$options.service.submit(this.files, () => {
                    this.files = [];
                    this.isLoading = false;
                }, true, this.wh_no);
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
            File
        }
    }
</script>