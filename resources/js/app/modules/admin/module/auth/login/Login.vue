<template>
    <v-col
            cols="12"
            sm="8"
            md="4"
    >
        <v-card class="elevation-12">
            <v-toolbar
                    color="primary"
                    dark
                    flat
            >
                <v-toolbar-title>{{ $t('auth.login.login_form') }}</v-toolbar-title>
                <div class="flex-grow-1"></div>
            </v-toolbar>
            <v-form>
                <v-card-text>
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
                            prepend-icon="mdi-email-outline"
                            type="text"
                    ></v-text-field>

                    <v-text-field
                            ref="password"
                            v-model="form.password"
                            :rules="rules.password"
                            :error-messages="errors.password"
                            :label="$t('translations.words.password')"
                            prepend-icon="mdi-textbox-password"
                            :append-icon="!showpassword ? 'mdi-eye-off' : 'mdi-eye'"
                            :min="minPasswordLength"
                            :type="showpassword ? 'text' : 'password'"
                            @click:append="showpassword = !showpassword"
                            required
                            :disabled="isLoading"
                            @keyup.enter="submit"
                    ></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <span>
                        <router-link :to="{ name: 'auth.forgot-password'}">{{$t('auth.forgot-password.forgot_password')}}</router-link><br />
                        <router-link :to="{ name: 'auth.register'}">{{$t('translations.words.register')}}</router-link>
                    </span>
                    <div class="flex-grow-1"></div>
                    <v-btn color="primary" @click.prevent="submit" :disabled="submitDisabled || isLoading">{{ $t('translations.words.login') }}</v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-col>
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
                minPasswordLength: constants.VALIDATION_MIN_PASSWORD_LENGTH,
                rules: {
                    email: [
                        validation.required(i18n.t('translations.words.email')),
                        validation.isEmail(i18n.t('translations.words.email'))
                        // () => !!this.form.email || 'This field is required',
                        // () => constants.VALIDATION_EMAIL.test(this.form.email) || 'E-mail is not valid'
                    ],
                    password: [
                        validation.required('Password'),
                        validation.min('Password', constants.VALIDATION_MIN_PASSWORD_LENGTH)
                        // () => !!this.form.password || 'This field is required',
                        // () => this.form.password.length >= this.minPasswordLength || 'Password must be equal or more then ' + this.minPasswordLength + ' chars'
                    ]
                }
            }
        },
        created() {
            //
        },
        computed: {
            ...mapState({
                form: state => state.login.form,
                submitDisabled: state => state.login.submitDisabled,
                errors: state => state.login.errors,
                isLoading: state => state.login.isLoading
            }),
        },
        watch: {
            form: {
                handler: function() {
                    if(this.$store.state.login.errors.email || this.$store.state.login.errors.password) {
                        this.$store.commit('login/changeErrors', {email: '', password: ''});
                    }

                    this.$store.commit('login/changeSubmitDisabled', !this.$refs.email || !this.$refs.password || !this.$refs.email.validate() || !this.$refs.password.validate())
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
