<template>
    <PageBox class="module-progressrate">
        <!--p>
            <v-btn color="default" :to="{ name: 'stock.list'}">Summary</v-btn>
            <v-btn color="primary" :to="{ name: 'stock.detail1'}">W/H 1</v-btn>
            <v-btn color="primary" :to="{ name: 'stock.detail2'}">W/H 2</v-btn>
            <v-btn color="primary" :to="{ name: 'stock.detail3'}">W/H 3</v-btn>
            <v-btn color="primary" :to="{ name: 'stock.detail4'}">W/H 4</v-btn>
            <v-btn color="primary" :to="{ name: 'stock.detail5'}">W/H 5</v-btn>
            <v-btn color="primary" :to="{ name: 'stock.detail6'}">W/H 6</v-btn>
            <v-btn color="primary" :to="{ name: 'stock.detail7'}">W/H 7</v-btn>
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

                        <v-select
                                :value="filter.wh_01_in.value"
                                @input="filterChanged($event, 'wh_01_in')"
                                :items="['All', ...filter.wh_01_in.list]"
                                label="W/H_01 In (A)"
                        ></v-select>
                        <v-select
                                :value="filter.wh_01_out.value"
                                @input="filterChanged($event, 'wh_01_out')"
                                :items="['All', ...filter.wh_01_out.list]"
                                label="W/H_01 Out (B)"
                        ></v-select>
                        <v-select
                                :value="filter.wh_01_total_ab.value"
                                @input="filterChanged($event, 'wh_01_total_ab')"
                                :items="['All', ...filter.wh_01_total_ab.list]"
                                label="W/H_01 Total (A-B)"
                        ></v-select>

                        <v-select
                                :value="filter.wh_02_in.value"
                                @input="filterChanged($event, 'wh_02_in')"
                                :items="['All', ...filter.wh_02_in.list]"
                                label="W/H_02 In (A)"
                        ></v-select>
                        <v-select
                                :value="filter.wh_02_out.value"
                                @input="filterChanged($event, 'wh_02_out')"
                                :items="['All', ...filter.wh_02_out.list]"
                                label="W/H_02 Out (B)"
                        ></v-select>
                        <v-select
                                :value="filter.wh_02_total_ab.value"
                                @input="filterChanged($event, 'wh_02_total_ab')"
                                :items="['All', ...filter.wh_02_total_ab.list]"
                                label="W/H_02 Total (A-B)"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-select
                                :value="filter.wh_03_in.value"
                                @input="filterChanged($event, 'wh_03_in')"
                                :items="['All', ...filter.wh_03_in.list]"
                                label="W/H_03 In (A)"
                        ></v-select>
                        <v-select
                                :value="filter.wh_03_out.value"
                                @input="filterChanged($event, 'wh_03_out')"
                                :items="['All', ...filter.wh_03_out.list]"
                                label="W/H_03 Out (B)"
                        ></v-select>
                        <v-select
                                :value="filter.wh_03_total_ab.value"
                                @input="filterChanged($event, 'wh_03_total_ab')"
                                :items="['All', ...filter.wh_03_total_ab.list]"
                                label="W/H_03 Total (A-B)"
                        ></v-select>

                        <v-select
                                :value="filter.wh_04_in.value"
                                @input="filterChanged($event, 'wh_04_in')"
                                :items="['All', ...filter.wh_04_in.list]"
                                label="W/H_04 In (A)"
                        ></v-select>
                        <v-select
                                :value="filter.wh_04_out.value"
                                @input="filterChanged($event, 'wh_04_out')"
                                :items="['All', ...filter.wh_04_out.list]"
                                label="W/H_04 Out (B)"
                        ></v-select>
                        <v-select
                                :value="filter.wh_04_total_ab.value"
                                @input="filterChanged($event, 'wh_04_total_ab')"
                                :items="['All', ...filter.wh_04_total_ab.list]"
                                label="W/H_04 Total (A-B)"
                        ></v-select>

                        <v-select
                                :value="filter.wh_05_in.value"
                                @input="filterChanged($event, 'wh_05_in')"
                                :items="['All', ...filter.wh_05_in.list]"
                                label="W/H_05 In (A)"
                        ></v-select>
                        <v-select
                                :value="filter.wh_05_out.value"
                                @input="filterChanged($event, 'wh_05_out')"
                                :items="['All', ...filter.wh_05_out.list]"
                                label="W/H_05 Out (B)"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-select
                                :value="filter.wh_05_total_ab.value"
                                @input="filterChanged($event, 'wh_05_total_ab')"
                                :items="['All', ...filter.wh_05_total_ab.list]"
                                label="W/H_05 Total (A-B)"
                        ></v-select>

                        <v-select
                                :value="filter.wh_06_in.value"
                                @input="filterChanged($event, 'wh_06_in')"
                                :items="['All', ...filter.wh_06_in.list]"
                                label="W/H_06 In (A)"
                        ></v-select>
                        <v-select
                                :value="filter.wh_06_out.value"
                                @input="filterChanged($event, 'wh_06_out')"
                                :items="['All', ...filter.wh_06_out.list]"
                                label="W/H_06 Out (B)"
                        ></v-select>
                        <v-select
                                :value="filter.wh_06_total_ab.value"
                                @input="filterChanged($event, 'wh_06_total_ab')"
                                :items="['All', ...filter.wh_06_total_ab.list]"
                                label="W/H_06 Total (A-B)"
                        ></v-select>

                        <v-select
                                :value="filter.wh_07_in.value"
                                @input="filterChanged($event, 'wh_07_in')"
                                :items="['All', ...filter.wh_07_in.list]"
                                label="W/H_07 In (A)"
                        ></v-select>
                        <v-select
                                :value="filter.wh_07_out.value"
                                @input="filterChanged($event, 'wh_07_out')"
                                :items="['All', ...filter.wh_07_out.list]"
                                label="W/H_07 Out (B)"
                        ></v-select>
                        <v-select
                                :value="filter.wh_07_total_ab.value"
                                @input="filterChanged($event, 'wh_07_total_ab')"
                                :items="['All', ...filter.wh_07_total_ab.list]"
                                label="W/H_07 Total (A-B)"
                        ></v-select>

                        <v-select
                                :value="filter.total_stock.value"
                                @input="filterChanged($event, 'total_stock')"
                                :items="['All', ...filter.total_stock.list]"
                                label="Total (Stock)"
                        ></v-select>
                    </v-col>
                </v-row>
            </v-container>
        </div>

        <v-data-table
                :headers="headers"
                :items="items"
                class="elevation-1 colored-table"
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
                filterShow: false,
                files: [],
                extensions: ['xlsx'],
                isLoading: false,
                headers: [
                    {
                        text: 'No',
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
                    },
                    {
                        text: 'W/H_01 In (A)',
                        align: 'center',
                        value: 'wh_01_in'
                    },
                    {
                        text: 'W/H_01 Out (B)',
                        align: 'center',
                        value: 'wh_01_out'
                    },
                    {
                        text: 'W/H_01 Total (A-B)',
                        align: 'center',
                        value: 'wh_01_total_ab'
                    },
                    {
                        text: 'W/H_02 In (A)',
                        align: 'center',
                        value: 'wh_02_in'
                    },
                    {
                        text: 'W/H_02 Out (B)',
                        align: 'center',
                        value: 'wh_02_out'
                    },
                    {
                        text: 'W/H_02 Total (A-B)',
                        align: 'center',
                        value: 'wh_02_total_ab'
                    },
                    /*{
                        text: 'W/H_03 In (A)',
                        align: 'center',
                        value: 'wh_03_in'
                    },
                    {
                        text: 'W/H_03 Out (B)',
                        align: 'center',
                        value: 'wh_03_out'
                    },
                    {
                        text: 'W/H_03 Total (A-B)',
                        align: 'center',
                        value: 'wh_03_total_ab'
                    },

                    {
                        text: 'W/H_04 In (A)',
                        align: 'center',
                        value: 'wh_04_in'
                    },
                    {
                        text: 'W/H_04 Out (B)',
                        align: 'center',
                        value: 'wh_04_out'
                    },
                    {
                        text: 'W/H_04 Total (A-B)',
                        align: 'center',
                        value: 'wh_04_total_ab'
                    },

                    {
                        text: 'W/H_05 In (A)',
                        align: 'center',
                        value: 'wh_05_in'
                    },
                    {
                        text: 'W/H_05 Out (B)',
                        align: 'center',
                        value: 'wh_05_out'
                    },
                    {
                        text: 'W/H_05 Total (A-B)',
                        align: 'center',
                        value: 'wh_05_total_ab'
                    },

                    {
                        text: 'W/H_06 In (A)',
                        align: 'center',
                        value: 'wh_06_in'
                    },
                    {
                        text: 'W/H_06 Out (B)',
                        align: 'center',
                        value: 'wh_06_out'
                    },
                    {
                        text: 'W/H_06 Total (A-B)',
                        align: 'center',
                        value: 'wh_06_total_ab'
                    },

                    {
                        text: 'W/H_07 In (A)',
                        align: 'center',
                        value: 'wh_07_in'
                    },
                    {
                        text: 'W/H_07 Out (B)',
                        align: 'center',
                        value: 'wh_07_out'
                    },
                    {
                        text: 'W/H_07 Total (A-B)',
                        align: 'center',
                        value: 'wh_07_total_ab'
                    },*/
                    {
                        text: 'Total (Stock)',
                        align: 'center',
                        value: 'total_stock'
                    }
                ],
            }
        },
        computed: {
            items() {
                return this.$store.state.stock.list.filter(item => {
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
                        this.filter.wh_01_in.value !== 'All' &&
                        this.filter.wh_01_in.value !== item.wh_01_in
                    ) {
                        return false;
                    }
                    if (
                        this.filter.wh_01_out.value !== 'All' &&
                        this.filter.wh_01_out.value !== item.wh_01_out
                    ) {
                        return false;
                    }
                    if (
                        this.filter.wh_01_total_ab.value !== 'All' &&
                        this.filter.wh_01_total_ab.value !== item.wh_01_total_ab
                    ) {
                        return false;
                    }

                    if (
                        this.filter.wh_02_in.value !== 'All' &&
                        this.filter.wh_02_in.value !== item.wh_02_in
                    ) {
                        return false;
                    }
                    if (
                        this.filter.wh_02_out.value !== 'All' &&
                        this.filter.wh_02_out.value !== item.wh_02_out
                    ) {
                        return false;
                    }
                    if (
                        this.filter.wh_02_total_ab.value !== 'All' &&
                        this.filter.wh_02_total_ab.value !== item.wh_02_total_ab
                    ) {
                        return false;
                    }

                    if (
                        this.filter.wh_03_in.value !== 'All' &&
                        this.filter.wh_03_in.value !== item.wh_03_in
                    ) {
                        return false;
                    }
                    if (
                        this.filter.wh_03_out.value !== 'All' &&
                        this.filter.wh_03_out.value !== item.wh_03_out
                    ) {
                        return false;
                    }
                    if (
                        this.filter.wh_03_total_ab.value !== 'All' &&
                        this.filter.wh_03_total_ab.value !== item.wh_03_total_ab
                    ) {
                        return false;
                    }

                    if (
                        this.filter.wh_04_in.value !== 'All' &&
                        this.filter.wh_04_in.value !== item.wh_04_in
                    ) {
                        return false;
                    }
                    if (
                        this.filter.wh_04_out.value !== 'All' &&
                        this.filter.wh_04_out.value !== item.wh_04_out
                    ) {
                        return false;
                    }
                    if (
                        this.filter.wh_04_total_ab.value !== 'All' &&
                        this.filter.wh_04_total_ab.value !== item.wh_04_total_ab
                    ) {
                        return false;
                    }

                    if (
                        this.filter.wh_05_in.value !== 'All' &&
                        this.filter.wh_05_in.value !== item.wh_05_in
                    ) {
                        return false;
                    }
                    if (
                        this.filter.wh_05_out.value !== 'All' &&
                        this.filter.wh_05_out.value !== item.wh_05_out
                    ) {
                        return false;
                    }
                    if (
                        this.filter.wh_05_total_ab.value !== 'All' &&
                        this.filter.wh_05_total_ab.value !== item.wh_05_total_ab
                    ) {
                        return false;
                    }

                    if (
                        this.filter.wh_06_in.value !== 'All' &&
                        this.filter.wh_06_in.value !== item.wh_06_in
                    ) {
                        return false;
                    }
                    if (
                        this.filter.wh_06_out.value !== 'All' &&
                        this.filter.wh_06_out.value !== item.wh_06_out
                    ) {
                        return false;
                    }
                    if (
                        this.filter.wh_06_total_ab.value !== 'All' &&
                        this.filter.wh_06_total_ab.value !== item.wh_06_total_ab
                    ) {
                        return false;
                    }

                    if (
                        this.filter.wh_07_in.value !== 'All' &&
                        this.filter.wh_07_in.value !== item.wh_07_in
                    ) {
                        return false;
                    }
                    if (
                        this.filter.wh_07_out.value !== 'All' &&
                        this.filter.wh_07_out.value !== item.wh_07_out
                    ) {
                        return false;
                    }
                    if (
                        this.filter.wh_07_total_ab.value !== 'All' &&
                        this.filter.wh_07_total_ab.value !== item.wh_07_total_ab
                    ) {
                        return false;
                    }

                    if (
                        this.filter.total_stock.value !== 'All' &&
                        this.filter.total_stock.value !== item.total_stock
                    ) {
                        return false;
                    }

                    return true;
                });
            },
            filter() {
                return this.$store.state.stock.filter;
            }
        },
        created() {
            this.$options.service.init(/*'Loading', columns => {
                console.log('columns', columns);
                for(let key in columns.in) {
                    console.log(columns.in[key]);
                    this.headers.push(columns.in[key]);
                }

                this.headers.push({
                    text: 'Total (A)',
                    align: 'center',
                    value: 'total_a'
                });

                for(let key in columns.out) {
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
            }*/);
        },
        methods: {
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
                this.$store.commit('stock/changeFilter', newFilter);
                console.log(val);
            }
        },
        components: {
            PageBox,
            File
        }
    }
</script>