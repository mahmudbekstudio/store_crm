import i18n from '../../plugin/i18n';
import Document from './Document'
import ParentRoute from '../../view/ParentRoute';

const route = {
    path: '/document',
    name: 'document',
    component: ParentRoute,
    children: [
        {path: '', redirect: {name: 'document.item1'}},
        {
            path: 'document/1',
            name: 'document.item1',
            component: Document,
            meta: {
                requiresAuth: true,
                title: 'Survey report'
            },
        },
        {
            path: 'document/2',
            name: 'document.item2',
            component: Document,
            meta: {
                requiresAuth: true,
                title: 'OATC'
            },
        },
        {
            path: 'document/3',
            name: 'document.item3',
            component: Document,
            meta: {
                requiresAuth: true,
                title: 'Request for stock-out, each warehouse'
            },
        },
        {
            path: 'document/4',
            name: 'document.item4',
            component: Document,
            meta: {
                requiresAuth: true,
                title: 'Etc.'
            },
        },
    ]
};

export default route;
