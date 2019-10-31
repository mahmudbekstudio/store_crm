<template>
    <v-app-bar
            :clipped-left="$vuetify.breakpoint.lgAndUp"
            app
            color="blue darken-3 top-header"
            dark
    >
        <v-toolbar-title
                style="width: 300px"
                class="ml-0"
        >
            <v-app-bar-nav-icon @click.stop="toggleDrawer"></v-app-bar-nav-icon>
            <span class="hidden-sm-and-down company-name">{{ title }}</span>
        </v-toolbar-title>

        <div class="flex-grow-1"></div>


        <!--v-btn icon>
            <v-icon>mdi-apps</v-icon>
        </v-btn>
        <v-btn icon>
            <v-icon>mdi-bell</v-icon>
        </v-btn>
        <v-btn
                icon
                large
        >
            <v-avatar
                    size="32px"
                    item
            >
                <v-img
                        src="/img/logo.svg"
                        alt="Vuetify"
                >
                </v-img></v-avatar>
        </v-btn-->
        <!--<v-menu
                offset-y
                origin="center center"
        >
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" icon class="notification-btn">
                    <v-badge color="accent">
                        <template v-slot:badge>{{notificationsList.length}}</template>
                        <v-icon>mdi-bell</v-icon>
                    </v-badge>
                </v-btn>
            </template>
            <v-list v-if="notificationsList.length">
                <v-list-item
                        v-for="(item, index) in notificationsList"
                        :key="index"
                        @click=""
                        two-line
                >
                    <v-list-item-content>
                        <v-list-item-title>{{ item }}</v-list-item-title>
                        <v-list-item-subtitle>
                            Secondary line text Lorem ipsum dolor sit amet,
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-menu>-->

        <v-menu
                offset-y
                v-model="menuIsOpen"
                origin="center center"
        >
            <template v-slot:activator="{ on }">
                <div v-on="on" class="profile-menu">
                    <v-avatar

                            color="accent"
                            size="40"
                    >
                        <v-icon>mdi-account-outline</v-icon>
                    </v-avatar>
                    <div class="user-name hidden-xs-only">{{ fullname }}</div>
                    <v-icon class="user-arrow">{{menuArrow}}</v-icon>
                </div>
            </template>

            <v-list>
                <v-list-item class="hidden-sm-and-up text-center">
                    <v-list-item-title><i>{{ fullname }}</i></v-list-item-title>
                </v-list-item>
                <!--<v-list-item class="text-center" @click="clickProfile">
                    <v-list-item-title>Profile</v-list-item-title>
                </v-list-item>-->
                <v-list-item class="text-center" @click="clickLogout">
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>


    </v-app-bar>
</template>
<script>
    import {mapActions, mapState} from 'vuex';
    import viewConfig from '../../config/view';
    import http from '../../service/Http';
    import app from '../../service/App';

    export default {
        data: function () {
            return {
                menuIsOpen: false,
                notificationsList: []
            }
        },
        computed: {
            ...mapState({
                getDrawer: state => state.view.drawer,
                //title: state => state.view.title
            }),
            title() {
                return viewConfig.companyName;
            },
            fullname() {
                return 'testing Max';
            },
            menuArrow() {
                return !this.menuIsOpen ? 'mdi-arrow-down-drop-circle-outline' : 'mdi-arrow-up-drop-circle-outline';
            }
        },
        methods: {
            ...mapActions({
                'toggleDrawer': 'view/toggleDrawer'
            }),
            clickProfile() {
                this.$router.push({name: 'auth.profile'})
            },
            clickLogout() {
                http('auth.logout')
                    .callback()
                    .send()
                    .then(
                        response => {
                            this.$logger.info('auth.logout response', response.data.message);
                            app.openMessage(response.data.message);
                            app.logout();
                        }
                    )
                    .catch()
            }
        },
        watch: {
            //
        }
    }
</script>
<style scoped lang="scss"></style>
