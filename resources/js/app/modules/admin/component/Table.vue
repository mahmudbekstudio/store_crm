<template>
    <v-data-table
            :items="items"
            :headers="headers"

            class="elevation-1"

            @click:row="clickRow"
            @current-items="currentItems"
            @input="input"
            @item-expanded="itemExpanded"
            @item-selected="itemSelected"
            @page-count="pageCount"
            @pagination="pagination"
            @toggle-select-all="toggleSelectAll"
            @update:expanded="updateExpanded"
            @update:group-by="updateGroupBy"
            @update:options="updateOptions"
            @update:items-per-page="updateItemsPerPage"
            @update:multi-sort="updateMultiSort"
            @update:must-sort="updateMustSort"
            @update:group-desc="updateGroupDesc"
            @update:page="updatePage"
            @update:sort-by="updateSortBy"
            @update:sort-desc="updateSortDesc"
    >
        <template v-slot:item.action="{ item }">
            <v-icon
                    v-for="item in actions"
                    class="mr-2"
                    @click="item.click(item)"
            >
                {{item.icon}}
            </v-icon>
        </template>
        <template v-slot:no-data>
            <div class="text-center">{{noDataText}}</div>
        </template>
    </v-data-table>
</template>
<script>
  export default {
    props: {
      noDataText: this.$t('translations.words.no-data'),
      headers: {
        type: Array,
        default: []
      },
      items: {
        type: Array,
        default: []
      },
      actions: {
        type: Array,
        default: []
      }
    },
    methods: {
      clickRow(val) {
        /* any */
        this.$logger.info('table event click:row', val);
        this.$emit('click-row', val);
      },
      currentItems(list) {
        /* any[] */
        this.$logger.info('table event current-items', list);
        this.$emit('current-items', list);
      },
      input(list) {
        /* any[] */
        this.$logger.info('table event input', list);
        this.$emit('input', list);
      },
      itemExpanded(val) {
        /* { item: any, value: boolean } */
        this.$logger.info('table event item-expanded', val);
        this.$emit('item-expanded', val);
      },
      itemSelected(val) {
        /* { item: any, value: boolean } */
        this.$logger.info('table event item-selected', val);
        this.$emit('item-selected', val);
      },
      pageCount(val) {
        /* number */
        this.$logger.info('table event page-count', val);
        this.$emit('page-count', val);
      },
      pagination(val) {
        /* {
              page: number
              itemsPerPage: number
              pageStart: number
              pageStop: number
              pageCount: number
              itemsLength: number
            } */
        this.$logger.info('table event pagination', val);
        this.$emit('pagination', val);
      },
      toggleSelectAll(val) {
        /* { value: boolean } */
        this.$logger.info('table event toggle-select-all', val);
        this.$emit('toggle-select-all', val);
      },
      updateExpanded(val) {
        /* any[] */
        this.$logger.info('table event update:expanded', val);
        this.$emit('update:expanded', val);
      },
      updateGroupBy(val) {
        /* string | string[] */
        this.$logger.info('table event update:group-by', val);
        this.$emit('update:group-by', val);
      },
      updateGroupDesc(val) {
        /* boolean | boolean[] */
        this.$logger.info('table event update:group-desc', val);
        this.$emit('update:group-desc', val);
      },
      updateItemsPerPage(val) {
        /* number */
        this.$logger.info('table event update:items-per-page', val);
        this.$emit('update:items-per-page', val);
      },
      updateMultiSort(val) {
        /* boolean */
        this.$logger.info('table event update:multi-sort', val);
        this.$emit('update:multi-sort', val);
      },
      updateMustSort(val) {
        /* boolean */
        this.$logger.info('table event update:must-sort', val);
        this.$emit('update:must-sort', val);
      },
      updateOptions(val) {
        /*  {
              page: number
              itemsPerPage: number
              sortBy: string[]
              sortDesc: boolean[]
              groupBy: string[]
              groupDesc: boolean[]
              multiSort: boolean
              mustSort: boolean
            } */
        this.$logger.info('table event update:options', val);
        this.$emit('update:options', val);
      },
      updatePage(val) {
        /* number */
        this.$logger.info('table event update:page', val);
        this.$emit('update:page', val);
      },
      updateSortBy(val) {
        /* string | string[] */
        this.$logger.info('table event update:sort-by', val);
        this.$emit('update:sort-by', val);
      },
      updateSortDesc(val) {
        /* boolean | boolean[] */
        this.$logger.info('table event update:sort-desc', val);
        this.$emit('update:sort-desc', val);
      }
    }
  };
</script>
