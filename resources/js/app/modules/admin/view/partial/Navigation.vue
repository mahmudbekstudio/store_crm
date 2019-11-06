<template>
    <v-navigation-drawer
            v-model="drawer"
            :clipped="$vuetify.breakpoint.lgAndUp"
            :mini-variant="isMini"
            app
            class="navigation"
    >
        <v-list dense>
            <template v-for="(item, i) in items">
                <v-row
                        v-if="item.heading"
                        :key="i"
                        align="center"
                >
                    <v-col cols="6">
                        <v-subheader v-if="item.heading">
                            {{ item.heading }}
                        </v-subheader>
                    </v-col>
                    <v-col
                            cols="6"
                            class="text-center"
                    >
                        <v-btn
                                small
                                text
                        >edit</v-btn>
                    </v-col>
                </v-row>
                <v-divider
                        v-else-if="item.divider"
                        :key="i"
                        dark
                        class="my-4"
                ></v-divider>


                <v-list-group
                        v-else-if="item.children"
                        :key="i"
                        :value="selectedItem.split('::')[0] == i"
                >
                    <template v-slot:activator>
                        <v-list-item>
                            <v-list-item-action>
                                <v-icon>{{ item.icon }}</v-icon>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title>
                                    {{ item.text }}
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </template>
                    <v-list-item
                            v-for="(child, k) in item.children"
                            :key="i + '::' + k"
                            @click="clickItem(child, i + '::' + k)"
                            :class="{'v-list-item--active': selectedItem == (i + '::' + k)}"
                    >
                        <v-list-item-action v-if="child.icon">
                            <v-icon>{{ child.icon }}</v-icon>
                        </v-list-item-action>
                        <v-list-item-content class="navigation-child-text">
                            <v-list-item-title>
                                {{ child.text }}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-group>
                <v-list-item
                        v-else
                        :key="i"
                        @click="clickItem(item, i)"
                        :class="{'v-list-item--active': selectedItem == i}"
                >
                    <v-list-item-action>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>
                            {{ item.text }}
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </template>
        </v-list>
    </v-navigation-drawer>
</template>
<script>
    import {mapState, mapActions} from 'vuex';
    import navigationList from '../../config/navigation';
    import store from '../../store';

    export default {
        data() {
            return {
                items: store.storage.state.user && store.storage.state.user.role ? navigationList[store.storage.state.user.role]: [],
                selectedItem: '0',
            }
        },

        created() {
            console.log(this.items);
            for(let i = 0; i < this.items.length; i++) {
                if(this.items[i].children && this.items[i].children.length) {
                    for(let j = 0; j < this.items[i].children.length; j++) {
                        if(this.items[i].children[j].route && this.$router.currentRoute.name === this.items[i].children[j].route.name) {
                            this.selectedItem = i + '::' + j;
                            return;
                        }
                    }
                }
                if(this.items[i].route && this.$router.currentRoute.name === this.items[i].route.name) {
                    this.selectedItem = i;
                    return;
                }
            }
        },

        computed: {
            ...mapState({
                getDrawer: state => state.view.drawer,
                isMini: state => state.view.isMini
            }),
            drawer: {
                get() {
                    return this.getDrawer
                },
                set(newVal) {
                    this.$store.dispatch('view/updateDrawer', newVal);
                }
            }
        },
        methods: {
            /*...mapActions({
                updateDrawer: 'view/updateDrawer'
            })*/
            clickItem(item, selectedKey) {
                if(item.route && this.$router.currentRoute.name !== item.route.name) {
                    this.$logger.info('navigation item clicked = ' + selectedKey, item);
                    this.$router.push(item.route);
                    this.selectedItem = selectedKey;
                }
            }
        }
    }
</script>
