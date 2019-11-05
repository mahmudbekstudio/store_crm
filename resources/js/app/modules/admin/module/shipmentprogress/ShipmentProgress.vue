<template>
    <PageBox class="module-progressrate">
        <p>
            <v-btn :color="shipmentNo === '' ? 'default' : 'primary'" :to="{ name: 'shipment-progress.list'}">Shipment progress</v-btn>
            <v-btn :color="shipmentNo === '2' ? 'default' : 'primary'" :to="{ name: 'shipment-progress.list2'}">Shipment progress AVR</v-btn>
        </p>
        <p>
            <File v-model="files" :extList="extensions"></File>
            <v-btn @click="submitSelectedFile" color="default" :disabled="!files.length || isLoading"
                   :loading="isLoading">{{ $t('shipmentprogress.submit') }}
            </v-btn>
            <!--v-btn text color="default" @click="filterShow=!filterShow">Filter</v-btn-->
        </p>
        <div v-show="filterShow"></div>
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
                shipmentNo: '',
                filterShow: false,
                files: [],
                extensions: ['xlsx'],
                isLoading: false,
                headers: [
                    {
                        text: 'No',
                        align: 'center',
                        value: 'num',
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
                        text: 'Contract',
                        align: 'center',
                        value: 'contract'
                    }
                ],
            }
        },
        computed: {
            items() {
                return this.$store.state.shipmentprogress.list.filter(item => {
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

                    return true;
                });
            },
            filter() {
                return this.$store.state.shipmentprogress.filter;
            }
        },
        created() {
            this.changeRoute();
        },
        watch: {
            '$route'() {
                this.changeRoute();
            }
        },
        methods: {
            changeRoute() {
                let routeName = this.$router.currentRoute.name;
                this.shipmentNo = routeName.replace('shipment-progress.list', '');
                this.$options.service.init(this.shipmentNo, '', columns => {
                    console.log('columns', columns);
                    for (let key in columns) {
                        this.headers.push(columns[key]);
                    }
                    this.headers.push({
                        text: 'Total',
                        align: 'center',
                        value: 'total'
                    });
                });
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
                this.$store.commit('shipmentprogress/changeFilter', newFilter);
                console.log(val);
            }
        },
        components: {
            PageBox,
            File
        }
    }
</script>