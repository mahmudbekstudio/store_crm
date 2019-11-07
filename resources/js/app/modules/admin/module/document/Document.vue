<template>
    <PageBox class="module-document">
        <div>
            <select class="standart-select" v-model="seletedDistrict">
                <optgroup v-for="(districts, region) of params" :label="region">
                    <option v-for="item of districts">{{item}}</option>
                </optgroup>
            </select>
            <File v-model="files" :extList="[]"></File>
            <v-btn @click="submitSelectedFile" color="default" :disabled="!files.length || isLoading"
                   :loading="isLoading">Upload
            </v-btn>
        </div>
        <ol>
            <li v-for="(districts, region) of params">
                <span @click="regionClick(region)" class="document-link">{{region}}</span>
                <ul v-show="activeRegion === region">
                    <li v-for="item of districts">
                        {{item}}
                        <div v-for="file of items[item]">
                            <a :href="file.file" target="_blank">{{getFileName(file.file)}}</a>
                            <v-btn text icon color="default" @click="deleteFile(file)">
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                        </div>
                    </li>
                </ul>
            </li>
        </ol>
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
                seletedDistrict: '',
                isLoading: false,
                activeRegion: '',
                typeId: '',
                files: [],
            };
        },
        computed: {
            items() {
                return this.$store.state.document.list;
            },
            params() {
                const params = this.$store.state.document.params;

                /*for(let val in params) {
                    for(let subVal in params[val]) {
                        this.files[params[val][subVal]] = [];
                    }
                }*/

                return params;
            }
        },
        created() {
            this.changeRoute();
        },
        watch: {
            '$route'() {
                this.changeRoute();
            }
        },

        methods: {
            getFileName(fileName) {
                return fileName.split('/').pop();
            },
            deleteFile(file) {
                this.isLoading = true;
                this.$options.service.delete(file.id, () => {
                    this.isLoading = false;
                }, this.typeId);
            },
            changeRoute() {
                let routeName = this.$router.currentRoute.name;
                this.typeId = routeName.replace('document.item', '');
                this.$options.service.init(this.typeId);
            },
            regionClick(region) {
                if(this.activeRegion === region) {
                    this.activeRegion = '';
                } else {
                    this.activeRegion = region;
                }
            },
            submitSelectedFile() {
                this.isLoading = true;
                this.$options.service.submit(this.files, () => {
                    this.files = [];
                    this.isLoading = false;
                }, this.seletedDistrict, this.typeId);
            }
        },
        components: {
            PageBox,
            File
        }
    }
</script>