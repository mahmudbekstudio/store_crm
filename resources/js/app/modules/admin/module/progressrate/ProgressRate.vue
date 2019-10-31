<template>
    <PageBox class="module-progressrate">
        <div>
            <File v-model="files" :extList="extensions" btnTitle="Update"></File>
            <v-btn @click="submitSelectedFile" color="default" :disabled="!files.length || isLoading">{{ $t('progressrate.submit') }}</v-btn>
            <v-btn text color="default" @click="filterShow=!filterShow">Filter</v-btn>
        </div>

        <div v-show="filterShow">Filter</div>

        <v-data-table
                :headers="headers"
                :items="items"
                class="elevation-1"
        >
            <template v-slot:no-data>
                <div class="text-center">No Data</div>
            </template>
        </v-data-table>
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
        changedFields: {},
        filterShow: false,
        files: [],
        extensions: ['xlsx'],
        isLoading: false,
        headers: [
          {
            text: 'Id',
            align: 'left',
            value: 'id',
            width: 50
          },
          {
            text: 'Region',
            align: 'left',
            value: 'region',
          },
          {
            text: 'Teacher computer',
            align: 'left',
            value: 'teacher_computer',
          },
          {
            text: 'Student computer',
            align: 'left',
            value: 'student_computer',
          },
          {
            text: 'Total PC',
            align: 'left',
            value: 'total_pc',
          },
          {
            text: 'Survey',
            align: 'left',
            value: 'survey',
          },
          {
            text: 'Out W/H',
            align: 'left',
            value: 'out_wh',
          },
          {
            text: 'Site Arrival Inspection',
            align: 'left',
            value: 'site_arrival_inspection',
          },
          {
            text: 'OAT/Training',
            align: 'left',
            value: 'oat_training',
          },
          {
            text: 'OAC',
            align: 'left',
            value: 'oac',
          },
          {
            text: 'MAC',
            align: 'left',
            value: 'mac',
          },
          {
            text: 'Warranty Competition',
            align: 'left',
            value: 'warranty_competition',
          },
          {
            text: 'Installed Q-ty of Ecc',
            align: 'left',
            value: 'installed_quantity_ecc',
          },
          {
            text: 'Installed Q-ty of PC',
            align: 'left',
            value: 'installed_quantity_pc',
          },
          {
            text: 'Progress Rate ECC',
            align: 'left',
            value: 'progress_rate_ecc',
          },
          {
            text: 'Progress Rate PC(T+S)',
            align: 'left',
            value: 'progress_rate_pc',
          }
        ],
      }
    },
    computed: {
      items() {
        return [];
      }
    },
    created() {
      this.$options.service.init();
    },
    methods: {
      submitSelectedFile() {
        this.$options.service.submit(this.files, () => {
          this.files = [];
        });
      },
    },
    components: {
      PageBox,
      File
    }
  }
</script>
