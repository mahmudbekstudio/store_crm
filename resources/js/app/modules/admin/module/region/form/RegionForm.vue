<template>
    <PageBox :actions="actionsList" :footerActions="footerActionsList">
        <v-form
                ref="form"
                v-model="valid"
        >
            <v-text-field
                    v-model="name"
                    :rules="nameRules"
                    label="Name"
                    required
            ></v-text-field>
        </v-form>
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
            footerActionsList: [],
            isEdit: false,

            // form
            valid: true,
            name: '',
            nameRules: [
                v => !!v || 'Name is required',
            ]
        }),

        watch: {
            valid(newVal, oldVal) {
                this.$logger.info('valid', newVal, oldVal);
                this.changeSaveButton(!newVal);
            }
        },

        computed: {
            item() {
                return this.$store.state.regionForm.item;
            },
        },

        created () {
            if(this.$router.currentRoute.params.id) {
                this.isEdit = true;
                this.$options.service.init(this.$router.currentRoute.params.id, (item) => {
                    this.name = item.name;
                });
            }

            this.actionsList.push(getPageBoxAction('Back', '', {color: 'default'}, {
                click: () => {
                    this.$router.push({name: 'region.list'})
                }
            }));
            this.changeSaveButton();
        },

        methods: {
            changeSaveButton(isDisabled = false) {
                this.footerActionsList[0] = getPageBoxAction('Save', '', {color: 'primary', disabled: isDisabled}, {
                    click: () => {
                        if(!this.isEdit) {
                            this.$options.service.add(this.name, () => {
                                this.goToBack();
                            });
                        } else {
                            this.$options.service.edit(this.item.id, this.name, () => {
                                this.goToBack();
                            });
                        }
                    }
                });
            },
            goToBack() {
                this.$router.push({name: 'region.list'});
            },
        },
    }
</script>
