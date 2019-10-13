<template>
    <v-flex sm8 md6 lg4 elevation-6>
        <v-toolbar class="blue darken-2">
            <v-toolbar-title class="white--text"><h4>{{$t('auth.register.registration')}}</h4></v-toolbar-title>
        </v-toolbar>
        <v-card>
            <v-card-text class="pt-4">
                <div>
                    <v-form ref="form">
                        <v-text-field
                                ref="email"
                                v-model="form.email"
                                :rules="rules.email"
                                :error-messages="errors.email"
                                :label="$t('translations.words.email')"
                                required
                                :disabled="isLoading"
                                @keyup.enter="submit"
                                autofocus
                                prepend-icon="person"
                                type="text"
                        ></v-text-field>
                        <v-text-field
                                ref="password"
                                v-model="form.password"
                                :rules="rules.password"
                                :error-messages="errors.password"
                                :label="$t('translations.words.password')"
                                prepend-icon="person"
                                :append-icon="showpassword ? 'visibility_off' : 'visibility'"
                                :min="minPasswordLength"
                                :type="showpassword ? 'text' : 'password'"
                                @click:append="showpassword = !showpassword"
                                required
                                :disabled="isLoading"
                                @keyup.enter="submit"
                        ></v-text-field>
                        <v-text-field
                                ref="password2"
                                v-model="form.password2"
                                :rules="rules.password2"
                                :error-messages="errors.password2"
                                :label="$t('translations.words.password2')"
                                prepend-icon="person"
                                :append-icon="showpassword2 ? 'visibility_off' : 'visibility'"
                                :min="minPasswordLength"
                                :type="showpassword2 ? 'text' : 'password'"
                                @click:append="showpassword2 = !showpassword2"
                                required
                                :disabled="isLoading"
                                @keyup.enter="submit"
                        ></v-text-field>
                        <v-layout justify-space-between>
                            <span>
                                <router-link :to="{ name: 'auth.login'}">{{ $t('translations.words.login') }}</router-link><br />
                                <router-link :to="{ name: 'auth.forgot-password'}">{{$t('auth.forgot-password.forgot_password')}}</router-link>
                            </span>
                            <v-btn color="primary" @click.prevent="submit" :disabled="submitDisabled || isLoading">{{$t('translations.words.send')}}</v-btn>
                        </v-layout>
                    </v-form>
                </div>
            </v-card-text>
        </v-card>
    </v-flex>
</template>
<script>
    import { mapState } from 'vuex';
    import validation from '../../../config/validation';
    import * as constants from '../../../constants';
    import Service from './service';
    import i18n from '../../../plugin/i18n';

    export default {
        service: new Service(),
        data() {
            return {
                showpassword: false,
                showpassword2: false,
                minPasswordLength: constants.VALIDATION_MIN_PASSWORD_LENGTH,
                rules: {
                    email: [
                        validation.required(i18n.t('translations.words.email')),
                        validation.isEmail(i18n.t('translations.words.email'))
                        // () => !!this.form.email || 'This field is required',
                        // () => constants.VALIDATION_EMAIL.test(this.form.email) || 'E-mail is not valid'
                    ],
                    password: [
                        validation.required(i18n.t('translations.words.password')),
                        validation.min(i18n.t('translations.words.password'), constants.VALIDATION_MIN_PASSWORD_LENGTH)
                        // () => !!this.form.password || 'This field is required',
                        // () => this.form.password.length >= this.minPasswordLength || 'Password must be equal or more then ' + this.minPasswordLength + ' chars'
                    ],
                    password2: [
                        validation.required(i18n.t('translations.words.password2')),
                        validation.min(i18n.t('translations.words.password2'), constants.VALIDATION_MIN_PASSWORD_LENGTH)
                        // () => !!this.form.password || 'This field is required',
                        // () => this.form.password.length >= this.minPasswordLength || 'Password must be equal or more then ' + this.minPasswordLength + ' chars'
                    ]
                }
            }
        },
        computed: {
            ...mapState({
                form: state => state.register.form,
                submitDisabled: state => state.register.submitDisabled,
                errors: state => state.register.errors,
                isLoading: state => state.register.isLoading
            }),
        },
        watch: {
            form: {
                handler: function() {
                    if(
                        this.$store.state.register.errors.email ||
                        this.$store.state.register.errors.password ||
                        this.$store.state.register.errors.password2
                    ) {
                        this.$store.commit('register/changeErrors', {email: '', password: '', password2: ''});
                    }

                    this.$store.commit('register/changeSubmitDisabled',
                        !this.$refs.email ||
                        !this.$refs.password ||
                        !this.$refs.password2 ||
                        !this.$refs.email.validate() ||
                        !this.$refs.password.validate() ||
                        !this.$refs.password2.validate()
                    )
                },
                deep: true
            }
        },
        methods: {
            submit() {
                if(this.submitDisabled || this.isLoading) {
                    return false;
                }

                this.$options.service.submit();
            }
        }
    }
</script>