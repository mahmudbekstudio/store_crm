<template>
    <div class="component-file">
        <label class="file-label" v-show="!(value.length === 1 && !multiple)">
            <slot name="button">
                <v-btn color="default" @click.prevent="selectFile"><v-icon v-html="uploadIcon"></v-icon>{{title || defaultTitle}}</v-btn>
            </slot>
            <input class="hidden" :accept="accept.join(',')" type="file" id="file" ref="file" :multiple="multiple" v-on:change="handleFileUpload()"/>
        </label>
        <div :class="listClass">
            <template v-for="item in value" v-bind:item="item">
                <div class="file-item" :title="$t('defect.remove')" @click="removeItem(item)"><v-icon>mdi-file</v-icon> {{item.name}}</div>
            </template>
        </div>
    </div>
</template>
<script>
    import app from '../service/App';

    export default {
        data() {
            return {
                //
            };
        },
        props: {
            accept: {
                type: Array,
                default() {
                    return ['*/*'];
                }
            },
            extList: {
                type: Array,
                default: []
            },
            title: {
                type: String,
                default: ''
            },
            value: {
                type: Array,
                default: []
            },
            multiple: {
                type: Boolean,
                default: false
            },
            listClass: {
                type: String,
                default: 'items-list'
            }
        },
        computed: {
            uploadIcon() {
                return this.multiple ? 'mdi-upload-multiple' : 'mdi-upload'
            },
            defaultTitle() {
                return this.multiple ? 'Select files' : 'Select file'
            }
        },
        methods: {
            selectFile() {
                this.$refs.file.click();
            },
            handleFileUpload(){
                const result = [];
                let files = [];

                if(this.extList.length) {
                    let invalidFiles = [];
                    let invalidFileNames = [];

                    for(let i = 0; i < this.$refs.file.files.length; i++) {
                        const fileExt = this.$refs.file.files[i].name.split('.').pop();

                        if(this.extList.indexOf(fileExt) > -1) {
                            files.push(this.$refs.file.files[i]);
                        } else {
                            invalidFiles.push(this.$refs.file.files[i]);
                            invalidFileNames.push(this.$refs.file.files[i].name);
                        }
                    }

                    invalidFileNames.length && app.openAlert('Not selected file' + (invalidFileNames.length > 1 ? 's' : '') + ' "' + invalidFileNames.join(', ') + '"');
                } else {
                    files = this.$refs.file.files;
                }

                if(files.length) {
                    if(this.multiple) {
                        for(let i = 0; i < this.value.length; i++) {
                            result.push(this.value[i]);
                        }
                    }

                    for(let i = 0; i < files.length; i++) {
                        result.push(files[i]);
                    }

                    this.emitResult(result);
                }

                this.$refs.file.value = null;
            },
            emitResult(result) {
                this.$logger.info('selected files', result);
                this.$emit('input', result);
            },
            removeItem(selectedItem) {
                const result = this.value.filter(item => item !== selectedItem);
                this.emitResult(result);
            }
        }
    }
</script>