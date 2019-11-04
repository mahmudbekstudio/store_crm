export default {
    admin: [
        {text: 'Dashboard', icon: 'mdi-view-dashboard-outline', route: {name: 'dashboard'}},
        /*{text: 'Region', icon: 'mdi-city-variant-outline', route: {name: 'region.list'}},
        {text: 'District', icon: 'mdi-city-variant-outline', route: {name: 'district.list'}},
        {text: 'School', icon: 'mdi-school-outline', route: {name: 'school.list'}},
        {text: 'Category', icon: 'mdi-laptop', route: {name: 'category.list'}},
        {text: 'Goods', icon: 'mdi-laptop', route: {name: 'goods.list'}},*/
        {text: 'User', icon: 'mdi-account-supervisor-outline', route: {name: 'user.list'}},
        {text: 'Defects', icon: 'mdi-image-broken-variant', route: {name: 'defect'}},
        {text: 'Progress rate', icon: 'mdi-progress-check', route: {name: 'progressrate.list'}},
        {text: 'Stock', icon: 'mdi-inbox-multiple', route: {name: 'stock.list'}},
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
    manager: [
        {text: 'Dashboard', icon: 'dashboard', route: {name: 'manager.dashboard'}},
        {text: 'Tasks', icon: 'group', route: {name: 'default-login'}},
        {text: 'Settings', icon: 'settings', route: {name: 'manager.settings'}}
    ],
    publisher: [
        {text: 'Dashboard', icon: 'dashboard', route: {name: 'publisher.dashboard'}},
        {text: 'Tasks', icon: 'dashboard', route: {name: 'publisher.dashboard'}},
        //{text: 'Test', icon: 'group', route: {name: 'default-login'}},
        {text: 'Settings', icon: 'settings', route: {name: 'publisher.settings'}}
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
