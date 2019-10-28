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
                        align: 'left',
                        value: 'id',
                        width: 50
                    },
                    {
                        text: 'Date',
                        align: 'left',
                        value: 'date',
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
                        text: 'From user',
                        align: 'left',
                        value: 'from_user_name',
                    },
                    {
                        text: 'User phone',
                        align: 'left',
                        value: 'from_user_phone',
                    },
                    {
                        text: 'Received user',
                        align: 'left',
                        value: 'received_user_name',
                    },
                    {
                        text: 'PC',
                        align: 'left',
                        value: 'product1',
                    },
                    {
                        text: 'Mouse',
                        align: 'left',
                        value: 'product2',
                    },
                    {
                        text: 'Keyboard',
                        align: 'left',
                        value: 'product3',
                    },
                    {
                        text: 'Monitor',
                        align: 'left',
                        value: 'product4',
                    },
                    {
                        text: 'Laser printer',
                        align: 'left',
                        value: 'product5',
                    },
                    {
                        text: 'AVR',
                        align: 'left',
                        value: 'product6',
                    },
                    {
                        text: 'Network switch',
                        align: 'left',
                        value: 'product7',
                    },
                    {
                        text: 'Comment',
                        align: 'left',
                        value: 'comment',
                    },
                    {
                        text: 'Replacement part',
                        align: 'left',
                        value: 'replacement_part',
                    },
                    {
                        text: 'Recovery',
                        align: 'left',
                        value: 'recovery',
                    },
                    {
                        text: 'Replacement pc',
                        align: 'left',
                        value: 'replacement_pc',
                    },
                    {
                        text: 'Done',
                        align: 'left',
                        value: 'date_done',
                    },
                    {
                        text: 'Manager',
                        align: 'left',
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
