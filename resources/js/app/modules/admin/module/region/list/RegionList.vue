<template>
    <PageBox :actions="actionsList">
        <v-data-table
                :headers="headers"
                :items="items"
                class="elevation-1"
                :footer-props="{itemsPerPageOptions:[30,45,60,-1]}"
                :fixed-header="true"
                :height="420"
        >
            <template v-slot:item.action="{ item }">
                <!--v-icon
                        class="mr-2"
                        @click="editItem(item)"
                >
                    mdi-square-edit-outline
                </v-icon>
                <v-icon
                        class="mr-2"
                        @click="deleteItem(item)"
                >
                    mdi-delete-outline
                </v-icon-->
            </template>
            <template v-slot:no-data>
                <div class="text-center">No Data</div>
            </template>
        </v-data-table>
    </PageBox>
</template>
<script>
    import PageBox from '../../../view/partial/PageBox';
    import { getPageBoxAction } from '../../../helper';
    import Service from './service';

    export default {
        service: new Service(),
        components: {
            PageBox
        },
        data: () => ({
            dialog: false,
            actionsList: [],
            headers: [
                {
                    text: 'Id',
                    align: 'left',
                    sortable: false,
                    value: 'id',
                    width: 50
                },
                {
                    text: 'Name',
                    align: 'left',
                    sortable: false,
                    value: 'name',
                },
                { text: 'Actions', value: 'action', sortable: false, width: 100 },
            ],
        }),

        computed: {
            items() {
                return this.$store.state.regionList.list;
            },
        },

        created () {
            this.$options.service.init();
            /*this.actionsList.push(getPageBoxAction('New', '', {color: 'primary'}, {
                click: () => {
                    this.$router.push({name: 'region.add'})
                }
            }));*/
        },

        methods: {
            editItem (item) {
                this.$router.push({name: 'region.edit', params: { id: item.id } });
            },

            deleteItem (item) {
                this.$options.service.delete(item.id);
            },
        },
    }
</script>
