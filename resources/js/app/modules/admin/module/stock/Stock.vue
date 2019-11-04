<template>
    <PageBox class="module-progressrate">
        <p>
            <File v-model="files" :extList="extensions"></File>
            <v-btn @click="submitSelectedFile" color="default" :disabled="!files.length || isLoading"
                   :loading="isLoading">{{ $t('progressrate.submit') }}
            </v-btn>
            <!--v-btn text color="default" @click="filterShow=!filterShow">Filter</v-btn-->
        </p>

        <div v-show="filterShow">Filter</div>

        <v-data-table
                :headers="headers"
                :items="items"
                class="elevation-1"
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
                    {
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
                    },
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
                    /*if (
                        this.filter.region.value !== 'All' &&
                        this.filter.region.value !== item.region
                    ) {
                        return false;
                    }*/

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