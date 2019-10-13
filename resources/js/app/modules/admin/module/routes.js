import viewConfig from '../config/view';
import authRoute from './auth/route';
import dashboardRoute from './dashboard/route';
import categoryRoute from './category/route';
import errorRoute from './error/route';

const routes = [
    {path: '/', redirect: {name: viewConfig.page.default}},
    authRoute,
    dashboardRoute,
    categoryRoute,
    errorRoute,
    {path: '*', redirect: {name: viewConfig.page.notFound}}
];

export default routes;
