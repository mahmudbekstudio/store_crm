<template>
    <div class="page-header">
        <v-app-bar>

            <v-toolbar-title>{{ title }}</v-toolbar-title>

            <div class="flex-grow-1"></div>

            <v-btn v-for="(btn, i) in actions" class="hidden-sm-and-down" :key="i" v-on="btn.on" v-bind="btn.bind">
                <v-icon v-if="btn.icon">{{btn.icon}}</v-icon>
                {{btn.title}}
            </v-btn>

            <v-menu
                    left
                    bottom
            >
                <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on" class="hidden-md-and-up">
                        <v-icon>mdi-dots-vertical</v-icon>
                    </v-btn>
                </template>

                <v-list>
                    <v-list-item
                            v-for="(btn, i) in actions"
                            :key="i"
                            v-on="btn.on"
                            v-bind="btn.bind"
                    >
                        <v-list-item-icon v-if="btn.icon">
                            <v-icon v-text="btn.icon"></v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title v-text="btn.title"></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>
    </div>
</template>
<script>
    export default {
        props: {
            actions: {
                type: Array,
                default: []
            }
        },
        computed: {
            title: function () {
                return this.$store.state.view.title;
            }
        }
    }
</script>
<style scoped lang="scss"></style>
