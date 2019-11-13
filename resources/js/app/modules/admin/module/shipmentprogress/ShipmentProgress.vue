<template>
    <PageBox class="module-progressrate">
        <!--p>
            <v-btn :color="shipmentNo === '' ? 'default' : 'primary'" :to="{ name: 'shipment-progress.list'}">Shipment progress</v-btn>
            <v-btn :color="shipmentNo === '2' ? 'default' : 'primary'" :to="{ name: 'shipment-progress.list2'}">Shipment progress AVR</v-btn>
        </p-->
        <p>
            <File v-model="files" :extList="extensions"></File>
            <v-btn @click="submitSelectedFile" color="default" :disabled="!files.length || isLoading"
                   :loading="isLoading">{{ $t('shipmentprogress.submit') }}
            </v-btn>
            <span class="d-inline-block"><v-switch v-model="isEditMode" label="Edit" color="primary"></v-switch></span>
            <!--v-btn text color="default" @click="filterShow=!filterShow">Filter</v-btn-->
        </p>
        <div v-show="filterShow"></div>
        <v-data-table
                :headers="headers"
                :items="items"
                class="elevation-1"
                @click:row="clickRow"
                v-model="selected"
        >
            <template v-slot:no-data>
                <div class="text-center">No Data</div>
            </template>

            <template v-slot:item.num="props">
                <v-edit-dialog
                        :return-value.sync="props.item.num"
                        @save="fieldSave(props.item.id, 'num')"
                        large
                > {{ props.item.num }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'num') || props.item.num"
                                @input="changeField(props.item.id, 'num', $event)"

                                label="No"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.item="props">
                <v-edit-dialog
                        :return-value.sync="props.item.item"
                        @save="fieldSave(props.item.id, 'item')"
                        large
                > {{ props.item.item }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'item') || props.item.item"
                                @input="changeField(props.item.id, 'item', $event)"

                                label="Item"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.unit="props">
                <v-edit-dialog
                        :return-value.sync="props.item.unit"
                        @save="fieldSave(props.item.id, 'unit')"
                        large
                > {{ props.item.unit }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'unit') || props.item.unit"
                                @input="changeField(props.item.id, 'unit', $event)"

                                label="Unit"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.contract="props">
                <v-edit-dialog
                        :return-value.sync="props.item.contract"
                        @save="fieldSave(props.item.id, 'contract')"
                        large
                > {{ props.item.contract }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'contract') || props.item.contract"
                                @input="changeField(props.item.id, 'contract', $event)"

                                label="Contract"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.column_4="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_4"
                        @save="fieldSave(props.item.id, 'column_4')"
                        large
                > {{ props.item.column_4 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_4') || props.item.column_4"
                                @input="changeField(props.item.id, 'column_4', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_5="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_5"
                        @save="fieldSave(props.item.id, 'column_5')"
                        large
                > {{ props.item.column_5 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_5') || props.item.column_5"
                                @input="changeField(props.item.id, 'column_5', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_6="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_6"
                        @save="fieldSave(props.item.id, 'column_6')"
                        large
                > {{ props.item.column_6 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_6') || props.item.column_6"
                                @input="changeField(props.item.id, 'column_6', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_7="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_7"
                        @save="fieldSave(props.item.id, 'column_7')"
                        large
                > {{ props.item.column_7 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_7') || props.item.column_7"
                                @input="changeField(props.item.id, 'column_7', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_8="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_8"
                        @save="fieldSave(props.item.id, 'column_8')"
                        large
                > {{ props.item.column_8 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_8') || props.item.column_8"
                                @input="changeField(props.item.id, 'column_8', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_9="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_9"
                        @save="fieldSave(props.item.id, 'column_9')"
                        large
                > {{ props.item.column_9 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_9') || props.item.column_9"
                                @input="changeField(props.item.id, 'column_9', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.column_10="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_10"
                        @save="fieldSave(props.item.id, 'column_10')"
                        large
                > {{ props.item.column_10 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_10') || props.item.column_10"
                                @input="changeField(props.item.id, 'column_10', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_11="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_11"
                        @save="fieldSave(props.item.id, 'column_11')"
                        large
                > {{ props.item.column_11 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_11') || props.item.column_11"
                                @input="changeField(props.item.id, 'column_11', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_12="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_12"
                        @save="fieldSave(props.item.id, 'column_12')"
                        large
                > {{ props.item.column_12 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_12') || props.item.column_12"
                                @input="changeField(props.item.id, 'column_12', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_13="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_13"
                        @save="fieldSave(props.item.id, 'column_13')"
                        large
                > {{ props.item.column_13 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_13') || props.item.column_13"
                                @input="changeField(props.item.id, 'column_13', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_14="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_14"
                        @save="fieldSave(props.item.id, 'column_14')"
                        large
                > {{ props.item.column_14 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_14') || props.item.column_14"
                                @input="changeField(props.item.id, 'column_14', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_15="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_15"
                        @save="fieldSave(props.item.id, 'column_15')"
                        large
                > {{ props.item.column_15 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_15') || props.item.column_15"
                                @input="changeField(props.item.id, 'column_15', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_16="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_16"
                        @save="fieldSave(props.item.id, 'column_16')"
                        large
                > {{ props.item.column_16 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_16') || props.item.column_16"
                                @input="changeField(props.item.id, 'column_16', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_17="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_17"
                        @save="fieldSave(props.item.id, 'column_17')"
                        large
                > {{ props.item.column_17 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_17') || props.item.column_17"
                                @input="changeField(props.item.id, 'column_17', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_18="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_18"
                        @save="fieldSave(props.item.id, 'column_18')"
                        large
                > {{ props.item.column_18 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_18') || props.item.column_18"
                                @input="changeField(props.item.id, 'column_18', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_19="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_19"
                        @save="fieldSave(props.item.id, 'column_19')"
                        large
                > {{ props.item.column_19 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_19') || props.item.column_19"
                                @input="changeField(props.item.id, 'column_19', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>



            <template v-slot:item.column_20="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_20"
                        @save="fieldSave(props.item.id, 'column_20')"
                        large
                > {{ props.item.column_20 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_20') || props.item.column_20"
                                @input="changeField(props.item.id, 'column_20', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_21="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_21"
                        @save="fieldSave(props.item.id, 'column_21')"
                        large
                > {{ props.item.column_21 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_21') || props.item.column_21"
                                @input="changeField(props.item.id, 'column_21', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_22="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_22"
                        @save="fieldSave(props.item.id, 'column_22')"
                        large
                > {{ props.item.column_22 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_22') || props.item.column_22"
                                @input="changeField(props.item.id, 'column_22', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_23="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_23"
                        @save="fieldSave(props.item.id, 'column_23')"
                        large
                > {{ props.item.column_23 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_23') || props.item.column_23"
                                @input="changeField(props.item.id, 'column_23', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_24="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_24"
                        @save="fieldSave(props.item.id, 'column_24')"
                        large
                > {{ props.item.column_24 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_24') || props.item.column_24"
                                @input="changeField(props.item.id, 'column_24', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_25="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_25"
                        @save="fieldSave(props.item.id, 'column_25')"
                        large
                > {{ props.item.column_25 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_25') || props.item.column_25"
                                @input="changeField(props.item.id, 'column_25', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_26="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_26"
                        @save="fieldSave(props.item.id, 'column_26')"
                        large
                > {{ props.item.column_266 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_26') || props.item.column_2"
                                @input="changeField(props.item.id, 'column_26', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_27="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_27"
                        @save="fieldSave(props.item.id, 'column_27')"
                        large
                > {{ props.item.column_27 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_27') || props.item.column_27"
                                @input="changeField(props.item.id, 'column_27', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_28="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_28"
                        @save="fieldSave(props.item.id, 'column_28')"
                        large
                > {{ props.item.column_28 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_28') || props.item.column_28"
                                @input="changeField(props.item.id, 'column_28', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_29="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_29"
                        @save="fieldSave(props.item.id, 'column_29')"
                        large
                > {{ props.item.column_29 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_29') || props.item.column_29"
                                @input="changeField(props.item.id, 'column_29', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.column_30="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_30"
                        @save="fieldSave(props.item.id, 'column_30')"
                        large
                > {{ props.item.column_30 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_30') || props.item.column_30"
                                @input="changeField(props.item.id, 'column_30', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_31="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_31"
                        @save="fieldSave(props.item.id, 'column_31')"
                        large
                > {{ props.item.column_31 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_31') || props.item.column_31"
                                @input="changeField(props.item.id, 'column_31', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_32="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_32"
                        @save="fieldSave(props.item.id, 'column_32')"
                        large
                > {{ props.item.column_32 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_32') || props.item.column_32"
                                @input="changeField(props.item.id, 'column_32', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_33="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_33"
                        @save="fieldSave(props.item.id, 'column_33')"
                        large
                > {{ props.item.column_33 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_33') || props.item.column_33"
                                @input="changeField(props.item.id, 'column_33', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_34="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_34"
                        @save="fieldSave(props.item.id, 'column_34')"
                        large
                > {{ props.item.column_34 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_34') || props.item.column_34"
                                @input="changeField(props.item.id, 'column_34', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_35="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_35"
                        @save="fieldSave(props.item.id, 'column_35')"
                        large
                > {{ props.item.column_35 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_35') || props.item.column_35"
                                @input="changeField(props.item.id, 'column_35', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_36="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_36"
                        @save="fieldSave(props.item.id, 'column_36')"
                        large
                > {{ props.item.column_36 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_36') || props.item.column_36"
                                @input="changeField(props.item.id, 'column_36', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_37="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_37"
                        @save="fieldSave(props.item.id, 'column_37')"
                        large
                > {{ props.item.column_37 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_37') || props.item.column_37"
                                @input="changeField(props.item.id, 'column_37', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_38="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_38"
                        @save="fieldSave(props.item.id, 'column_38')"
                        large
                > {{ props.item.column_38 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_38') || props.item.column_38"
                                @input="changeField(props.item.id, 'column_38', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_39="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_39"
                        @save="fieldSave(props.item.id, 'column_39')"
                        large
                > {{ props.item.column_39 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_39') || props.item.column_39"
                                @input="changeField(props.item.id, 'column_39', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.column_40="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_40"
                        @save="fieldSave(props.item.id, 'column_40')"
                        large
                > {{ props.item.column_40 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_40') || props.item.column_40"
                                @input="changeField(props.item.id, 'column_40', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_41="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_41"
                        @save="fieldSave(props.item.id, 'column_41')"
                        large
                > {{ props.item.column_41 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_41') || props.item.column_41"
                                @input="changeField(props.item.id, 'column_41', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_42="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_42"
                        @save="fieldSave(props.item.id, 'column_42')"
                        large
                > {{ props.item.column_42 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_42') || props.item.column_42"
                                @input="changeField(props.item.id, 'column_42', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_43="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_43"
                        @save="fieldSave(props.item.id, 'column_43')"
                        large
                > {{ props.item.column_43 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_43') || props.item.column_43"
                                @input="changeField(props.item.id, 'column_43', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_44="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_44"
                        @save="fieldSave(props.item.id, 'column_44')"
                        large
                > {{ props.item.column_44 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_44') || props.item.column_44"
                                @input="changeField(props.item.id, 'column_44', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_45="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_45"
                        @save="fieldSave(props.item.id, 'column_45')"
                        large
                > {{ props.item.column_45 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_45') || props.item.column_45"
                                @input="changeField(props.item.id, 'column_45', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_46="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_46"
                        @save="fieldSave(props.item.id, 'column_46')"
                        large
                > {{ props.item.column_46 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_46') || props.item.column_46"
                                @input="changeField(props.item.id, 'column_46', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_47="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_47"
                        @save="fieldSave(props.item.id, 'column_47')"
                        large
                > {{ props.item.column_47 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_47') || props.item.column_47"
                                @input="changeField(props.item.id, 'column_47', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_48="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_48"
                        @save="fieldSave(props.item.id, 'column_48')"
                        large
                > {{ props.item.column_48 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_48') || props.item.column_48"
                                @input="changeField(props.item.id, 'column_48', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_49="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_49"
                        @save="fieldSave(props.item.id, 'column_49')"
                        large
                > {{ props.item.column_49 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_49') || props.item.column_49"
                                @input="changeField(props.item.id, 'column_49', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.column_50="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_50"
                        @save="fieldSave(props.item.id, 'column_50')"
                        large
                > {{ props.item.column_50 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_50') || props.item.column_50"
                                @input="changeField(props.item.id, 'column_50', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_51="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_51"
                        @save="fieldSave(props.item.id, 'column_51')"
                        large
                > {{ props.item.column_51 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_51') || props.item.column_51"
                                @input="changeField(props.item.id, 'column_51', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_52="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_52"
                        @save="fieldSave(props.item.id, 'column_52')"
                        large
                > {{ props.item.column_52 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_52') || props.item.column_52"
                                @input="changeField(props.item.id, 'column_52', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_53="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_53"
                        @save="fieldSave(props.item.id, 'column_53')"
                        large
                > {{ props.item.column_53 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_53') || props.item.column_53"
                                @input="changeField(props.item.id, 'column_53', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_54="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_54"
                        @save="fieldSave(props.item.id, 'column_54')"
                        large
                > {{ props.item.column_54 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_54') || props.item.column_54"
                                @input="changeField(props.item.id, 'column_54', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_55="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_55"
                        @save="fieldSave(props.item.id, 'column_55')"
                        large
                > {{ props.item.column_55 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_55') || props.item.column_55"
                                @input="changeField(props.item.id, 'column_55', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_56="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_56"
                        @save="fieldSave(props.item.id, 'column_56')"
                        large
                > {{ props.item.column_56 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_56') || props.item.column_56"
                                @input="changeField(props.item.id, 'column_56', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_57="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_57"
                        @save="fieldSave(props.item.id, 'column_57')"
                        large
                > {{ props.item.column_57 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_57') || props.item.column_57"
                                @input="changeField(props.item.id, 'column_57', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_58="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_58"
                        @save="fieldSave(props.item.id, 'column_58')"
                        large
                > {{ props.item.column_58 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_58') || props.item.column_58"
                                @input="changeField(props.item.id, 'column_58', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_59="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_59"
                        @save="fieldSave(props.item.id, 'column_59')"
                        large
                > {{ props.item.column_59 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_59') || props.item.column_59"
                                @input="changeField(props.item.id, 'column_59', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.column_60="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_60"
                        @save="fieldSave(props.item.id, 'column_60')"
                        large
                > {{ props.item.column_60 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_60') || props.item.column_60"
                                @input="changeField(props.item.id, 'column_60', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_61="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_61"
                        @save="fieldSave(props.item.id, 'column_61')"
                        large
                > {{ props.item.column_61 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_61') || props.item.column_61"
                                @input="changeField(props.item.id, 'column_61', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_62="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_62"
                        @save="fieldSave(props.item.id, 'column_62')"
                        large
                > {{ props.item.column_62 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_62') || props.item.column_62"
                                @input="changeField(props.item.id, 'column_62', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_63="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_63"
                        @save="fieldSave(props.item.id, 'column_63')"
                        large
                > {{ props.item.column_63 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_63') || props.item.column_63"
                                @input="changeField(props.item.id, 'column_63', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_64="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_64"
                        @save="fieldSave(props.item.id, 'column_64')"
                        large
                > {{ props.item.column_64 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_64') || props.item.column_64"
                                @input="changeField(props.item.id, 'column_64', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_65="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_65"
                        @save="fieldSave(props.item.id, 'column_65')"
                        large
                > {{ props.item.column_65 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_65') || props.item.column_65"
                                @input="changeField(props.item.id, 'column_65', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_66="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_66"
                        @save="fieldSave(props.item.id, 'column_66')"
                        large
                > {{ props.item.column_66 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_66') || props.item.column_66"
                                @input="changeField(props.item.id, 'column_66', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_67="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_67"
                        @save="fieldSave(props.item.id, 'column_67')"
                        large
                > {{ props.item.column_67 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_67') || props.item.column_67"
                                @input="changeField(props.item.id, 'column_67', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_68="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_68"
                        @save="fieldSave(props.item.id, 'column_68')"
                        large
                > {{ props.item.column_68 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_68') || props.item.column_68"
                                @input="changeField(props.item.id, 'column_68', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.column_69="props">
                <v-edit-dialog
                        :return-value.sync="props.item.column_69"
                        @save="fieldSave(props.item.id, 'column_69')"
                        large
                > {{ props.item.column_69 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'column_69') || props.item.column_69"
                                @input="changeField(props.item.id, 'column_69', $event)"

                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>


        </v-data-table>
    </PageBox>
</template>
<script>
    import PageBox from '../../view/partial/PageBox';
    import File from '../../component/File';
    import Service from './service';

    const defaultHeaders = [
        {
            text: 'No',
            align: 'center',
            value: 'no',
            width: 50
        },
        /*{
            text: 'No',
            align: 'center',
            value: 'num',
            width: 50
        },*/
        {
            text: 'Item',
            align: 'center',
            value: 'item'
        },
        {
            text: 'Unit',
            align: 'center',
            value: 'unit'
        },
        {
            text: 'Contract',
            align: 'center',
            value: 'contract'
        }
    ];

    export default {
        service: new Service(),
        data() {
            return {
                isEditMode: false,
                selected:[],
                columns: [],
                shipmentNo: '',
                changedFields: {},
                filterShow: false,
                files: [],
                extensions: ['xlsx'],
                isLoading: false,
                headers: [],
                columns: []
            }
        },
        computed: {
            items() {
                return this.$store.state.shipmentprogress.list.filter(item => {
                    if(parseInt(item.id) === 0) {
                        return this.isEditMode;
                    }

                    if(this.isEditMode) {
                        return false;
                    }

                    if (
                        this.filter.item.value !== 'All' &&
                        this.filter.item.value !== item.item
                    ) {
                        return false;
                    }

                    if (
                        this.filter.unit.value !== 'All' &&
                        this.filter.unit.value !== item.unit
                    ) {
                        return false;
                    }

                    return true;
                });
            },
            filter() {
                return this.$store.state.shipmentprogress.filter;
            }
        },
        created() {
            this.changeRoute();
        },
        watch: {
            '$route'() {
                this.changeRoute();
            },
            isEditMode() {
                this.changeColumns();
            }
        },
        methods: {
            clickRow(item) {
                this.$logger.info('clickrow', item);
                const index = this.selected.indexOf(item);
                if(index > -1) {
                    this.selected.splice(index, 1);
                } else {
                    this.selected.push(item);
                }
            },
            changeColumns() {
                let columns = this.columns;
                this.headers = [];

                if(!this.isEditMode) {
                    for (let key in defaultHeaders) {
                        this.headers.push(defaultHeaders[key]);
                    }
                }

                for (let key in columns) {
                    let item = Object.assign({}, columns[key]);

                    if(this.isEditMode) {
                        item.text = '';
                    }

                    this.headers.push(item);
                }

                if(!this.isEditMode) {
                    this.headers.push({
                        text: 'Total',
                        align: 'center',
                        value: 'total'
                    });
                    this.headers.push({
                        text: 'Balance',
                        align: 'center',
                        value: 'balance'
                    });
                }
            },
            changeRoute() {
                let routeName = this.$router.currentRoute.name;
                this.shipmentNo = routeName.replace('shipment-progress.list', '');

                this.$options.service.init(this.shipmentNo, '', columns => {
                    console.log('columns', columns);
                    this.columns = columns;
                    this.changeColumns();
                });
            },
            submitSelectedFile() {
                this.isLoading = true;
                this.$options.service.submit(this.files, () => {
                    this.files = [];
                    this.isLoading = false;
                }, this.shipmentNo || 1, columns => {
                    console.log('columns', columns);
                    this.columns = columns;
                    this.changeColumns();
                });
            },
            changeField(id, key, val, send, isNumber) {
                this.$logger.info(id, key, val);
                this.changedFields[id] = this.changedFields[id] || {};
                this.changedFields[id][key] = val;

                if(isNumber) {
                    this.changedFields[id][key] = isNumber === 'int' ? parseInt(this.changedFields[id][key]) : parseFloat(this.changedFields[id][key]);
                }

                if(send) {
                    this.fieldSave(id, key);
                }
            },
            fieldSave(id, key) {
                if(typeof this.changedFields[id] !== 'undefined' && typeof this.changedFields[id][key] !== 'undefined') {
                    this.$logger.info('changed field', id, key, this.changedFields[id][key]);
                    this.$options.service.changeField(id, key, this.changedFields[id][key], true, this.shipmentNo || 1, columns => {
                        console.log('columns', columns);
                        this.columns = columns;
                        this.changeColumns();
                    });
                }
                this.changedFields = {};
            },
            getField(id, key) {
                if(this.changedFields[id] && this.changedFields[id][key]) {
                    return this.changedFields[id][key];
                }
                return null;
            },
            filterChanged(val, key) {
                const newFilter = Object.assign({}, this.filter);
                newFilter[key].value = val;
                this.$store.commit('shipmentprogress/changeFilter', newFilter);
                console.log(val);
            }
        },
        components: {
            PageBox,
            File
        }
    }
</script>