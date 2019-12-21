<template>
    <PageBox class="module-document">
        <div v-if="selected.district && $store.state.view.website.user.role === 'admin'">
            <File v-model="files" :extList="[]"></File>
            <v-btn @click="submitSelectedFile" color="default" :disabled="!files.length || isLoading"
                   :loading="isLoading">Upload
            </v-btn>
        </div>
        <div v-if="!selected.region" class="folder-list">
            <h2>
                Regions list
                <v-text-field
                        v-model="regionName"
                        :error="regionError"
                        :error-messages="regionMessages"
                        append-outer-icon="mdi-send"
                        clear-icon="mdi-close-circle"
                        clearable
                        label="New region"
                        type="text"
                        :disabled="regionDisabled"
                        @click:append-outer="addRegion"
                ></v-text-field>
            </h2>
            <div v-for="(districts, region) of params" class="folder-item">
                <v-icon @click="clickSelectRegion(region)">mdi-folder-outline</v-icon>
                <v-tooltip top>
                    <template v-slot:activator="{ on }">
                        <div class="folder-name" v-on="on">
                            <v-btn text icon color="default" class="delete-btn" @click="deleteRegion(region)">
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                            <span @click="clickSelectRegion(region)">{{ region }}</span>
                        </div>
                    </template>
                    <span>{{ region }}</span>
                </v-tooltip>
            </div>
        </div>
        <div v-if="selected.region && !selected.district" class="folder-list">
            <h4 v-if="regionsLength > 1">Selected region: {{ selected.region }}</h4>
            <h2>
                <v-btn v-if="regionsLength > 1" color="default" icon @click="selected.region = ''"><v-icon>mdi-keyboard-backspace</v-icon></v-btn>
                Districts list
                <v-text-field
                        v-model="districtName"
                        :error="districtError"
                        :error-messages="districtMessages"
                        append-outer-icon="mdi-send"
                        clear-icon="mdi-close-circle"
                        clearable
                        label="New district"
                        type="text"
                        :disabled="districtDisabled"
                        @click:append-outer="addDistrict"
                ></v-text-field>
            </h2>
            <div v-for="district of params[selected.region]" class="folder-item">
                <v-icon @click="clickSelectDistrict(district)">mdi-folder-outline</v-icon>
                <v-tooltip top>
                    <template v-slot:activator="{ on }">
                        <div class="folder-name" v-on="on">
                            <v-btn text icon color="default" class="delete-btn" @click="deleteDistrict(district)">
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                            <span @click="clickSelectDistrict(district)">{{ district }}</span>
                        </div>
                    </template>
                    <span>{{ district }}</span>
                </v-tooltip>
            </div>
        </div>
        <div v-if="selected.district" class="folder-list">
            <h4 v-if="regionsLength > 1">Selected region: {{ selected.region }}</h4>
            <h4>Selected district: {{ selected.district }}</h4>
            <h2><v-btn color="default" icon @click="selected.district = ''"><v-icon>mdi-keyboard-backspace</v-icon></v-btn> Files list</h2>

            <div v-for="file of items[selected.district]" class="folder-item">
                <v-btn text icon color="default" class="delete-btn" @click="deleteFile(file)">
                    <v-icon>mdi-delete</v-icon>
                </v-btn>
                <a :href="'/api/admin/document/download/' + file.id" target="_blank">
                    <v-icon>mdi-file-outline</v-icon>
                    <v-tooltip top>
                        <template v-slot:activator="{ on }">
                            <div class="folder-name" v-on="on">
                                {{getFileName(file.file)}}
                            </div>
                        </template>
                        <span>{{getFileName(file.file)}}</span>
                    </v-tooltip>
                </a>
            </div>
        </div>
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
                regionName: null,
                regionError: false,
                regionDisabled: false,
                regionMessages: [],

                districtName: null,
                districtError: false,
                districtDisabled: false,
                districtMessages: [],
                selected: {
                    region: '',
                    district: ''
                },
                isLoading: false,
                typeId: '',
                files: [],
                regionsLength: 0,
            };
        },
        computed: {
            items() {
                return this.$store.state.document.list;
            },
            params() {
                const params = this.$store.state.document.params;

                return params;
            }
        },
        created() {
            this.changeRoute();
        },
        watch: {
            '$route'() {
                this.changeRoute();
            },
            params(val) {
                this.regionsLength = 0;
                let lastKey = '';

                for(let key in val) {
                    this.regionsLength++;
                    lastKey = key;
                }

                if(this.regionsLength === 1) {
                    this.selected.region = lastKey;
                }
            },
            regionName() {
                this.regionError = false;
            },
            districtName() {
                this.districtError = false;
            }
        },

        methods: {
            addRegion() {
                this.regionName = this.regionName ? this.regionName.trim() : null;

                if(!this.regionName) {
                    this.regionError = true;
                    return false;
                }

                this.regionDisabled = true;
                this.$options.service.addRegion(this.typeId, this.regionName, () => {
                    this.regionName = '';
                    this.regionDisabled = false;
                });
            },
            addDistrict() {
                this.districtName = this.districtName ? this.districtName.trim() : null;

                if(!this.districtName) {
                    this.districtError = true;
                    return false;
                }

                this.districtDisabled = true;
                this.$options.service.addDistrict(this.typeId, this.districtName, this.selected.region, () => {
                    this.districtName = '';
                    this.districtDisabled = false;
                });
            },
            deleteRegion(region) {
                this.isLoading = true;
                this.$options.service.deleteRegion(this.typeId, region, () => {
                    this.isLoading = false;
                });
            },
            deleteDistrict(district) {
                this.isLoading = true;
                this.$options.service.deleteDistrict(this.typeId, district, () => {
                    this.isLoading = false;
                });
            },
            getFileName(fileName) {
                return fileName.split('/').pop();
            },
            clickSelectRegion(region) {
                this.selected.region = region;
            },
            clickSelectDistrict(district) {
                this.selected.district = district;
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
                this.selected.region = '';
                this.selected.district = '';
            },
            submitSelectedFile() {
                this.isLoading = true;
                this.$options.service.submit(this.files, () => {
                    this.files = [];
                    this.isLoading = false;
                }, this.selected.district, this.typeId);
            }
        },
        components: {
            PageBox,
            File
        }
    }
</script>
