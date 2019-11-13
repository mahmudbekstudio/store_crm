<template>
    <PageBox class="module-progressrate">
        <!--p>
            <v-btn color="primary" :to="{ name: 'stock.list'}">Summary</v-btn>
            <v-btn :color="wh_no === '1' ? 'default' : 'primary'" :to="{ name: 'stock.detail1'}">W/H 1</v-btn>
            <v-btn :color="wh_no === '2' ? 'default' : 'primary'" :to="{ name: 'stock.detail2'}">W/H 2</v-btn>
            <v-btn :color="wh_no === '3' ? 'default' : 'primary'" :to="{ name: 'stock.detail3'}">W/H 3</v-btn>
            <v-btn :color="wh_no === '4' ? 'default' : 'primary'" :to="{ name: 'stock.detail4'}">W/H 4</v-btn>
            <v-btn :color="wh_no === '5' ? 'default' : 'primary'" :to="{ name: 'stock.detail5'}">W/H 5</v-btn>
            <v-btn :color="wh_no === '6' ? 'default' : 'primary'" :to="{ name: 'stock.detail6'}">W/H 6</v-btn>
            <v-btn :color="wh_no === '7' ? 'default' : 'primary'" :to="{ name: 'stock.detail7'}">W/H 7</v-btn>
        </p-->
        <p>
            <File v-model="files" :extList="extensions"></File>
            <v-btn @click="submitSelectedFile" color="default" :disabled="!files.length || isLoading"
                   :loading="isLoading">{{ $t('progressrate.submit') }}
            </v-btn>
            <v-btn text color="default" @click="filterShow=!filterShow">Filter</v-btn>
            <span class="d-inline-block"><v-switch v-model="isEditMode" label="Edit" color="primary"></v-switch></span>
        </p>
        <div v-show="filterShow">
            <v-container class="grey lighten-5">
                <v-row no-gutters>
                    <v-col cols="12" sm="4">
                        <v-select
                                :value="filter.item.value"
                                @input="filterChanged($event, 'item')"
                                :items="['All', ...filter.item.list]"
                                label="Item"
                        ></v-select>
                        <v-select
                                :value="filter.unit.value"
                                @input="filterChanged($event, 'unit')"
                                :items="['All', ...filter.unit.list]"
                                label="Unit"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-select
                                :value="filter.total_a.value"
                                @input="filterChanged($event, 'total_a')"
                                :items="['All', ...filter.total_a.list]"
                                label="Total (A)"
                        ></v-select>
                        <v-select
                                :value="filter.total_b.value"
                                @input="filterChanged($event, 'total_b')"
                                :items="['All', ...filter.total_b.list]"
                                label="Total (B)"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-select
                                :value="filter.total_ab.value"
                                @input="filterChanged($event, 'total_ab')"
                                :items="['All', ...filter.total_ab.list]"
                                label="Total (A - B)"
                        ></v-select>
                    </v-col>
                </v-row>
            </v-container>
        </div>
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

            <template v-slot:item.total_a="props">
                <v-edit-dialog
                        :return-value.sync="props.item.total_a"
                        @save="fieldSave(props.item.id, 'total_a')"
                        large
                > {{ props.item.total_a }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'total_a') || props.item.total_a"
                                @input="changeField(props.item.id, 'total_a', $event)"

                                label="Total (A)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.total_b="props">
                <v-edit-dialog
                        :return-value.sync="props.item.total_b"
                        @save="fieldSave(props.item.id, 'total_b')"
                        large
                > {{ props.item.total_b }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'total_b') || props.item.total_b"
                                @input="changeField(props.item.id, 'total_b', $event)"

                                label="Total (B)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.remark="props">
                <v-edit-dialog
                        :return-value.sync="props.item.remark"
                        @save="fieldSave(props.item.id, 'remark')"
                        large
                > {{ props.item.remark }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'remark') || props.item.remark"
                                @input="changeField(props.item.id, 'remark', $event)"

                                label="Remark"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.in_column_3="props">
                <v-edit-dialog
                        :return-value.sync="props.item.in_column_3"
                        @save="fieldSave(props.item.id, 'in_column_3')"
                        large
                > {{ props.item.in_column_3 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'in_column_3') || props.item.in_column_3"
                                @input="changeField(props.item.id, 'in_column_3', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.in_column_4="props">
                <v-edit-dialog
                        :return-value.sync="props.item.in_column_4"
                        @save="fieldSave(props.item.id, 'in_column_4')"
                        large
                > {{ props.item.in_column_4 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'in_column_4') || props.item.in_column_4"
                                @input="changeField(props.item.id, 'in_column_4', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.in_column_5="props">
                <v-edit-dialog
                        :return-value.sync="props.item.in_column_5"
                        @save="fieldSave(props.item.id, 'in_column_5')"
                        large
                > {{ props.item.in_column_5 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'in_column_5') || props.item.in_column_5"
                                @input="changeField(props.item.id, 'in_column_5', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.in_column_6="props">
                <v-edit-dialog
                        :return-value.sync="props.item.in_column_6"
                        @save="fieldSave(props.item.id, 'in_column_6')"
                        large
                > {{ props.item.in_column_6 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'in_column_6') || props.item.in_column_6"
                                @input="changeField(props.item.id, 'in_column_6', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.in_column_7="props">
                <v-edit-dialog
                        :return-value.sync="props.item.in_column_7"
                        @save="fieldSave(props.item.id, 'in_column_7')"
                        large
                > {{ props.item.in_column_7 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'in_column_7') || props.item.in_column_7"
                                @input="changeField(props.item.id, 'in_column_7', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.in_column_8="props">
                <v-edit-dialog
                        :return-value.sync="props.item.in_column_8"
                        @save="fieldSave(props.item.id, 'in_column_8')"
                        large
                > {{ props.item.in_column_8 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'in_column_8') || props.item.in_column_8"
                                @input="changeField(props.item.id, 'in_column_8', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.in_column_9="props">
                <v-edit-dialog
                        :return-value.sync="props.item.in_column_9"
                        @save="fieldSave(props.item.id, 'in_column_9')"
                        large
                > {{ props.item.in_column_9 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'in_column_9') || props.item.in_column_9"
                                @input="changeField(props.item.id, 'in_column_9', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.in_column_10="props">
                <v-edit-dialog
                        :return-value.sync="props.item.in_column_10"
                        @save="fieldSave(props.item.id, 'in_column_10')"
                        large
                > {{ props.item.in_column_10 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'in_column_10') || props.item.in_column_10"
                                @input="changeField(props.item.id, 'in_column_10', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.in_column_11="props">
                <v-edit-dialog
                        :return-value.sync="props.item.in_column_11"
                        @save="fieldSave(props.item.id, 'in_column_11')"
                        large
                > {{ props.item.in_column_11 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'in_column_11') || props.item.in_column_11"
                                @input="changeField(props.item.id, 'in_column_11', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.in_column_12="props">
                <v-edit-dialog
                        :return-value.sync="props.item.in_column_12"
                        @save="fieldSave(props.item.id, 'in_column_12')"
                        large
                > {{ props.item.in_column_12 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'in_column_12') || props.item.in_column_12"
                                @input="changeField(props.item.id, 'in_column_12', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.in_column_13="props">
                <v-edit-dialog
                        :return-value.sync="props.item.in_column_13"
                        @save="fieldSave(props.item.id, 'in_column_13')"
                        large
                > {{ props.item.in_column_13 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'in_column_13') || props.item.in_column_13"
                                @input="changeField(props.item.id, 'in_column_13', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>

            <template v-slot:item.out_column_6="props">
                <v-edit-dialog
                        :return-value.sync="props.item.out_column_6"
                        @save="fieldSave(props.item.id, 'out_column_6')"
                        large
                > {{ props.item.out_column_6 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'out_column_6') || props.item.out_column_6"
                                @input="changeField(props.item.id, 'out_column_6', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.out_column_7="props">
                <v-edit-dialog
                        :return-value.sync="props.item.out_column_7"
                        @save="fieldSave(props.item.id, 'out_column_7')"
                        large
                > {{ props.item.out_column_7 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'out_column_7') || props.item.out_column_7"
                                @input="changeField(props.item.id, 'out_column_7', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.out_column_8="props">
                <v-edit-dialog
                        :return-value.sync="props.item.out_column_8"
                        @save="fieldSave(props.item.id, 'out_column_8')"
                        large
                > {{ props.item.out_column_8 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'out_column_8') || props.item.out_column_8"
                                @input="changeField(props.item.id, 'out_column_8', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.out_column_9="props">
                <v-edit-dialog
                        :return-value.sync="props.item.out_column_9"
                        @save="fieldSave(props.item.id, 'out_column_9')"
                        large
                > {{ props.item.out_column_9 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'out_column_9') || props.item.out_column_9"
                                @input="changeField(props.item.id, 'out_column_9', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.out_column_10="props">
                <v-edit-dialog
                        :return-value.sync="props.item.out_column_10"
                        @save="fieldSave(props.item.id, 'out_column_10')"
                        large
                > {{ props.item.out_column_10 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'out_column_10') || props.item.out_column_10"
                                @input="changeField(props.item.id, 'out_column_10', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.out_column_11="props">
                <v-edit-dialog
                        :return-value.sync="props.item.out_column_11"
                        @save="fieldSave(props.item.id, 'out_column_11')"
                        large
                > {{ props.item.out_column_11 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'out_column_11') || props.item.out_column_11"
                                @input="changeField(props.item.id, 'out_column_11', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.out_column_12="props">
                <v-edit-dialog
                        :return-value.sync="props.item.out_column_12"
                        @save="fieldSave(props.item.id, 'out_column_12')"
                        large
                > {{ props.item.out_column_12 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'out_column_12') || props.item.out_column_12"
                                @input="changeField(props.item.id, 'out_column_12', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.out_column_13="props">
                <v-edit-dialog
                        :return-value.sync="props.item.out_column_13"
                        @save="fieldSave(props.item.id, 'out_column_13')"
                        large
                > {{ props.item.out_column_13 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'out_column_13') || props.item.out_column_13"
                                @input="changeField(props.item.id, 'out_column_13', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.out_column_14="props">
                <v-edit-dialog
                        :return-value.sync="props.item.out_column_14"
                        @save="fieldSave(props.item.id, 'out_column_14')"
                        large
                > {{ props.item.out_column_14 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'out_column_14') || props.item.out_column_14"
                                @input="changeField(props.item.id, 'out_column_14', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.out_column_15="props">
                <v-edit-dialog
                        :return-value.sync="props.item.out_column_15"
                        @save="fieldSave(props.item.id, 'out_column_15')"
                        large
                > {{ props.item.out_column_15 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'out_column_15') || props.item.out_column_15"
                                @input="changeField(props.item.id, 'out_column_15', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.out_column_16="props">
                <v-edit-dialog
                        :return-value.sync="props.item.out_column_16"
                        @save="fieldSave(props.item.id, 'out_column_16')"
                        large
                > {{ props.item.out_column_16 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'out_column_16') || props.item.out_column_16"
                                @input="changeField(props.item.id, 'out_column_16', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.out_column_17="props">
                <v-edit-dialog
                        :return-value.sync="props.item.out_column_17"
                        @save="fieldSave(props.item.id, 'out_column_17')"
                        large
                > {{ props.item.out_column_17 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'out_column_17') || props.item.out_column_17"
                                @input="changeField(props.item.id, 'out_column_17', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.out_column_18="props">
                <v-edit-dialog
                        :return-value.sync="props.item.out_column_18"
                        @save="fieldSave(props.item.id, 'out_column_18')"
                        large
                > {{ props.item.out_column_18 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'out_column_18') || props.item.out_column_18"
                                @input="changeField(props.item.id, 'out_column_18', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.out_column_19="props">
                <v-edit-dialog
                        :return-value.sync="props.item.out_column_19"
                        @save="fieldSave(props.item.id, 'out_column_19')"
                        large
                > {{ props.item.out_column_19 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'out_column_19') || props.item.out_column_19"
                                @input="changeField(props.item.id, 'out_column_19', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.out_column_20="props">
                <v-edit-dialog
                        :return-value.sync="props.item.out_column_20"
                        @save="fieldSave(props.item.id, 'out_column_20')"
                        large
                > {{ props.item.out_column_20 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'out_column_20') || props.item.out_column_20"
                                @input="changeField(props.item.id, 'out_column_20', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.out_column_21="props">
                <v-edit-dialog
                        :return-value.sync="props.item.out_column_21"
                        @save="fieldSave(props.item.id, 'out_column_21')"
                        large
                > {{ props.item.out_column_21 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'out_column_21') || props.item.out_column_21"
                                @input="changeField(props.item.id, 'out_column_21', $event)"
                                single-line
                                counter
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.out_column_22="props">
                <v-edit-dialog
                        :return-value.sync="props.item.out_column_22"
                        @save="fieldSave(props.item.id, 'out_column_22')"
                        large
                > {{ props.item.out_column_22 }}
                    <template v-slot:input>
                        <v-text-field
                                :value="getField(props.item.id, 'out_column_22') || props.item.out_column_22"
                                @input="changeField(props.item.id, 'out_column_22', $event)"
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
        {
            text: 'Item',
            align: 'center',
            value: 'item'
        },
        {
            text: 'Unit',
            align: 'center',
            value: 'unit'
        }
    ];

    export default {
        service: new Service(),
        data() {
            return {
                isEditMode: false,
                selected: [],
                changedFields: {},
                wh_no: 0,
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
                return this.$store.state.stock.detail.filter(item => {
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

                    if (
                        this.filter.total_a.value !== 'All' &&
                        this.filter.total_a.value !== item.total_a
                    ) {
                        return false;
                    }

                    if (
                        this.filter.total_b.value !== 'All' &&
                        this.filter.total_b.value !== item.total_b
                    ) {
                        return false;
                    }

                    if (
                        this.filter.total_ab.value !== 'All' &&
                        this.filter.total_ab.value !== item.total_ab
                    ) {
                        return false;
                    }

                    return true;
                });
            },
            filter() {
                return this.$store.state.stock.detailFilter;
            }
        },
        created() {
            this.changeWh();
        },
        watch: {
            '$route'() {
                this.changeWh();
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

                for (let key in columns.in) {
                    console.log(columns.in[key]);
                    let item = Object.assign({}, columns.in[key]);

                    if(this.isEditMode) {
                        item.text = '';
                    }

                    this.headers.push(item);
                }

                if(!this.isEditMode) {
                    this.headers.push({
                        text: 'Total (A)',
                        align: 'center',
                        value: 'total_a'
                    });
                }

                for (let key in columns.out) {
                    console.log(columns.out[key]);
                    let item = Object.assign({}, columns.out[key]);

                    if(this.isEditMode) {
                        item.text = '';
                    }

                    this.headers.push(item);
                }

                if(!this.isEditMode) {
                    this.headers.push({
                        text: 'Total (B)',
                        align: 'center',
                        value: 'total_b'
                    });

                    this.headers.push({
                        text: 'Total (A-B)',
                        align: 'center',
                        value: 'total_ab'
                    });

                    this.headers.push({
                        text: 'Remark',
                        align: 'center',
                        value: 'remark'
                    });
                }
            },
            changeWh() {
                let routeName = this.$router.currentRoute.name;
                this.wh_no = routeName.replace('stock.detail', '');

                this.$store.commit('stock/changeDetail', []);


                this.$options.service.detailInit(this.wh_no, '', columns => {
                    console.log('columns', columns);
                    this.columns = columns;
                    this.changeColumns();
                });
            },
            changeField(id, key, val, send) {
                this.$logger.info(id, key, val);
                this.changedFields[id] = this.changedFields[id] || {};
                this.changedFields[id][key] = val;

                if(send) {
                    this.fieldSave(id, key);
                }
            },
            fieldSave(id, key) {
                if(typeof this.changedFields[id] !== 'undefined' && typeof this.changedFields[id][key] !== 'undefined') {
                    this.$logger.info('changed field', id, key, this.changedFields[id][key]);
                    this.$options.service.changeFieldDetail(id, key, this.changedFields[id][key], true, this.wh_no, columns => {
                        console.log('columns', columns);
                        this.columns = columns;
                        this.changeColumns();
                    });
                }
                this.changedFields = {};
            },
            submitSelectedFile() {
                this.isLoading = true;
                this.$options.service.submit(this.files, () => {
                    this.files = [];
                    this.isLoading = false;
                }, true, this.wh_no, columns => {
                    console.log('columns', columns);
                    this.columns = columns;
                    this.changeColumns();
                });
            },
            filterChanged(val, key) {
                const newFilter = Object.assign({}, this.filter);
                newFilter[key].value = val;
                this.$store.commit('stock/changeDetailFilter', newFilter);
                console.log(val);
            },
            getField(id, key) {
                if (this.changedFields[id] && this.changedFields[id][key]) {
                    return this.changedFields[id][key];
                }
                return null;
            },
        },
        components: {
            PageBox,
            File
        }
    }
</script>