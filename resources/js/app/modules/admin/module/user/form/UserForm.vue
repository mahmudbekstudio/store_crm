<template>
    <PageBox :actions="actionsList" :footerActions="footerActionsList">
        <v-form
                ref="form"
                v-model="valid"
        >
            <v-text-field
                    v-model="form.firstName.value"
                    :rules="form.firstName.rules"
                    :label="form.firstName.label"
            ></v-text-field>
            <v-text-field
                    v-model="form.lastName.value"
                    :rules="form.lastName.rules"
                    :label="form.lastName.label"
            ></v-text-field>
            <v-text-field
                    v-model="form.email.value"
                    :rules="form.email.rules"
                    :label="form.email.label"
            ></v-text-field>
            <v-text-field
                    v-model="form.password.value"
                    :rules="form.password.rules"
                    :label="form.password.label"
                    type="password"
            ></v-text-field>
            <v-text-field
                    v-model="form.password2.value"
                    :rules="form.password2.rules"
                    :label="form.password2.label"
                    type="password"
            ></v-text-field>
            <v-select
                    :items="form.status.items"
                    :label="form.status.label"
                    v-model="form.status.value"
                    :rules="form.status.rules"
            ></v-select>
            <v-select
                    :items="form.role.items"
                    :label="form.role.label"
                    v-model="form.role.value"
                    :rules="form.role.rules"
            ></v-select>
        </v-form>
    </PageBox>
</template>
<script>
    import PageBox from '../../../view/partial/PageBox';
    import { getPageBoxAction } from '../../../helper';
    import Service from './service';
    import configValidation from '../../../config/validation';
    import i18n from '../../../plugin/i18n';

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

            valid: true,
            form: {
                //
            }
        }),

        watch: {
            valid(newVal, oldVal) {
                this.$logger.info('valid', newVal, oldVal);
                this.changeSaveButton(!newVal);
            },
            params(val) {
                this.$logger.info('watch params', val);
                this.form.status.items = val.statuses;
                this.form.role.items = val.roles;
            }
        },

        computed: {
            item() {
                return this.$store.state.userForm.item;
            },
            params() {
                return {roles: this.$store.state.userForm.roles, statuses: this.$store.state.userForm.statuses};
            }
        },

        created () {
            this.form = {
                firstName: {
                    label: i18n.t('translations.words.first_name'),
                    value: '',
                    rules: [configValidation.required(i18n.t('translations.words.first_name'))]
                },
                lastName: {
                    label: i18n.t('translations.words.last_name'),
                    value: '',
                    rules: [configValidation.required(i18n.t('translations.words.last_name'))]
                },
                email: {
                    label: i18n.t('translations.words.email'),
                    value: '',
                    rules: [configValidation.required(i18n.t('translations.words.email')), configValidation.isEmail(i18n.t('translations.words.email'))]
                },
                password: {
                    label: i18n.t('translations.words.password'),
                    value: '',
                    rules: []
                },
                password2: {
                    label: i18n.t('translations.words.password2'),
                    value: '',
                    rules: []
                },
                status: {
                    label: i18n.t('translations.words.status'),
                    value: '',
                    items: [],
                    rules: [configValidation.required(i18n.t('translations.words.status'))]
                },
                role: {
                    label: i18n.t('translations.words.role'),
                    value: '',
                    items: [],
                    rules: [configValidation.required(i18n.t('translations.words.role'))]
                }};

            this.$options.service.getParams();
            
            if(this.$router.currentRoute.params.id) {
                this.isEdit = true;
                this.$options.service.init(this.$router.currentRoute.params.id, (item) => {
                    for(let i in item) {
                        this.form[i].value = item[i] + '';
                    }
                    this.$logger.info('init', this.form);
                });
            } else {
                this.form.password.rules.push(configValidation.required(i18n.t('translations.words.password')));
                this.form.password2.rules.push(configValidation.required(i18n.t('translations.words.password2')));
            }

            this.actionsList.push(getPageBoxAction('Back', '', {color: 'default'}, {
                click: () => {
                    this.goToBack();
                }
            }));
            this.changeSaveButton();
        },

        methods: {
            changeSaveButton(isDisabled = false) {
                this.footerActionsList[0] = getPageBoxAction('Save', '', {color: 'primary', disabled: isDisabled}, {
                    click: () => {
                        if(!this.isEdit) {
                            let form = {};

                            for(let key in this.form) {
                                form[key] = this.form[key].value;
                            }

                            this.$logger.info('form', form);
                            this.$options.service.add(form, () => {
                                this.goToBack();
                            });
                        } else {
                            let form = {};

                            for(let key in this.form) {
                                form[key] = this.form[key].value + '';
                            }
                            this.$logger.info('edit form', form);
                            this.$options.service.edit(this.$router.currentRoute.params.id, form, () => {
                                this.goToBack();
                            });
                        }
                    }
                });
            },
            goToBack() {
                this.$router.push({name: 'user.list'});
            },
        },
    }
</script>
