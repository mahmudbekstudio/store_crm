<template>
    <PageBox class="module-dashboard">
        <div>
            <File v-model="files" :extList="extensions" btnTitle="Update"></File>
            <v-btn @click="submitSelectedFile" color="default" :disabled="!files.length || isLoading">{{ $t('defect.submit') }}</v-btn>
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
                return this.$store.state.defect.list;
            },
        },
        created() {
            //this.$logger.log('test1', {a: 1});
            this.$options.service.init();
        },
        methods: {
            submitSelectedFile() {
                this.$options.service.submit(this.files);
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
