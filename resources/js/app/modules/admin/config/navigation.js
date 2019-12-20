export default {
    admin: [
        {text: 'ECC Survey', icon: 'mdi-progress-check', route: {name: 'progressrate.checkList'}},
        {
            icon: 'mdi-progress-check',
            text: 'Installation Progress',
            children: [
                { text: 'Summary Progress', route: {name: 'progressrate.list'} },
                { text: 'Progress in Details', route: {name: 'progressrate.detail'} },
            ],
        },
        {
            icon: 'mdi-inbox-multiple',
            text: 'Stock Management',
            children: [
                { text: 'Summary', route: {name: 'stock.list'} },
                { text: 'W/H-1- Tashkent (ET)', route: {name: 'stock.detail1'} },
                { text: 'W/H-2- Tashkent (NAV)', route: {name: 'stock.detail2'} },
            ],
        },
        {
            icon: 'mdi-progress-clock',
            text: 'Shipment Progress',
            children: [
                { text: 'PC', route: {name: 'shipment-progress.list'} },
                { text: 'AVR', route: {name: 'shipment-progress.list2'} },
            ],
        },
        {text: 'Defect management', icon: 'mdi-image-broken-variant', route: {name: 'defect'}},
        {
            icon: 'mdi-file-document',
            text: 'Documents',
            children: [
                { text: 'Survey report', route: {name: 'document.item1'} },
                { text: 'OATC', route: {name: 'document.item2'} },
                { text: 'Request for stock-out, each warehouse', route: {name: 'document.item3'} },
                { text: 'Etc.', route: {name: 'document.item4'} },
            ],
        },
        // {text: 'Dashboard', icon: 'mdi-view-dashboard-outline', route: {name: 'dashboard'}},
        /*{text: 'Region', icon: 'mdi-city-variant-outline', route: {name: 'region.list'}},
        {text: 'District', icon: 'mdi-city-variant-outline', route: {name: 'district.list'}},
        {text: 'School', icon: 'mdi-school-outline', route: {name: 'school.list'}},
        {text: 'Category', icon: 'mdi-laptop', route: {name: 'category.list'}},
        {text: 'Goods', icon: 'mdi-laptop', route: {name: 'goods.list'}},*/
        {text: 'User', icon: 'mdi-account-supervisor-outline', route: {name: 'user.list'}},
        // {text: 'Defects', icon: 'mdi-image-broken-variant', route: {name: 'defect'}},
        // {text: 'Progress rate', icon: 'mdi-progress-check', route: {name: 'progressrate.list'}},
        // {text: 'Stock', icon: 'mdi-inbox-multiple', route: {name: 'stock.list'}},
        // {text: 'Shipment progress', icon: 'mdi-progress-clock', route: {name: 'shipment-progress.list'}},
        /*{ divider: true },
        { heading: 'Labels' },
        {text: 'Users', icon: 'mdi-account-group-outline', route: {name: 'admin.user'}},
        {text: 'Address', icon: 'mdi-account-group-outline', route: {name: 'admin.address'}},
        {text: 'Task', icon: 'mdi-account-group-outline', route: {name: 'admin.task'}},
        //{text: 'File Manager', icon: 'folder', route: {name: 'admin.fileManager'}},
        {text: 'Settings', icon: 'mdi-settings-outline', route: {name: 'admin.settings'}},
        {
            icon: 'mdi-settings-outline',
            text: 'More',
            children: [
                { text: 'Import', icon: 'settings' },
                { text: 'Export', icon: 'settings' },
                { text: 'Print', icon: 'settings' },
                { text: 'Undo changes', icon: 'settings' },
                { text: 'Other contacts', icon: 'settings' },
            ],
        },*/
    ],
    minister: [
        {text: 'ECC Survey', icon: 'mdi-progress-check', route: {name: 'progressrate.checkList'}},
        {
            icon: 'mdi-progress-check',
            text: 'Installation Progress',
            children: [
                { text: 'Summary Progress', route: {name: 'progressrate.list'} },
                { text: 'Progress in Details', route: {name: 'progressrate.detail'} },
            ],
        },
        {
            icon: 'mdi-progress-clock',
            text: 'Shipment Progress',
            children: [
                { text: 'PC', route: {name: 'shipment-progress.list'} },
                { text: 'AVR', route: {name: 'shipment-progress.list2'} },
            ],
        },
    ],
    guest: [
        {text: 'ECC Survey', icon: 'mdi-progress-check', route: {name: 'progressrate.checkList'}},
        {
            icon: 'mdi-progress-check',
            text: 'Installation Progress',
            children: [
                { text: 'Summary Progress', route: {name: 'progressrate.list'} },
                { text: 'Progress in Details', route: {name: 'progressrate.detail'} },
            ],
        },
        {
            icon: 'mdi-inbox-multiple',
            text: 'Stock Management',
            children: [
                { text: 'Summary', route: {name: 'stock.list'} },
                { text: 'W/H-1- Tashkent (ET)', route: {name: 'stock.detail1'} },
                { text: 'W/H-2- Tashkent (NAV)', route: {name: 'stock.detail2'} },
            ],
        },
        {
            icon: 'mdi-progress-clock',
            text: 'Shipment Progress',
            children: [
                { text: 'PC', route: {name: 'shipment-progress.list'} },
                { text: 'AVR', route: {name: 'shipment-progress.list2'} },
            ],
        },
        {text: 'Defect management', icon: 'mdi-image-broken-variant', route: {name: 'defect'}},
        {
            icon: 'mdi-file-document',
            text: 'Documents',
            children: [
                { text: 'Survey report', route: {name: 'document.item1'} },
                { text: 'OATC', route: {name: 'document.item2'} },
                { text: 'Request for stock-out, each warehouse', route: {name: 'document.item3'} },
                { text: 'Etc.', route: {name: 'document.item4'} },
            ],
        },
    ]
};
/*export default [
    { icon: 'contacts', text: 'Contacts' },
    { icon: 'history', text: 'Frequently contacted' },
    { icon: 'content_copy', text: 'Duplicates' },
    {
        icon: 'keyboard_arrow_up',
        'icon-alt': 'keyboard_arrow_down',
        text: 'Labels',
        model: true,
        children: [
            { icon: 'add', text: 'Create label' },
        ],
    },
    {
        icon: 'keyboard_arrow_up',
        'icon-alt': 'keyboard_arrow_down',
        text: 'More',
        model: false,
        children: [
            { text: 'Import' },
            { text: 'Export' },
            { text: 'Print' },
            { text: 'Undo changes' },
            { text: 'Other contacts' },
        ],
    },
    { icon: 'settings', text: 'Settings' },
    { icon: 'chat_bubble', text: 'Send feedback' },
    { icon: 'help', text: 'Help' },
    { icon: 'phonelink', text: 'App downloads' },
    { icon: 'keyboard', text: 'Go to the old version' },
];*/
