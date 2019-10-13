export let tableHeader = function(val) {
  const defaultData = {
    text: '',
    value: '',
    align: 'start', // align?: 'start' | 'center' | 'end'
    sortable: false, // sortable?: boolean
    filterable: false, // filterable?: boolean
    divider: false, // divider?: boolean
    class: '', // class?: string | string[]
    // width?: string | number
    // filter?: (value: any, search: string, item: any) => boolean
    // sort?: (a: any, b: any) => number
  };
  return Object.assign({}, defaultData, val);
};
