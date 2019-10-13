export default {
    admin: [
        {text: 'Dashboard', icon: 'mdi-view-dashboard-outline', route: {name: 'dashboard'}},
        {text: 'Category', icon: 'mdi-post-outline', route: {name: 'category'}},
        { divider: true },
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
        },
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
