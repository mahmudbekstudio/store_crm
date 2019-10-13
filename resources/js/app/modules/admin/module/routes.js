import viewConfig from '../config/view';
import authRoute from './auth/route';
import dashboardRoute from './dashboard/route';
import regionRoute from './region/route';
import schoolRoute from './school/route';
import goodsRoute from './goods/route';
import errorRoute from './error/route';

const routes = [
    {path: '/', redirect: {name: viewConfig.page.default}},
    authRoute,
    dashboardRoute,
    regionRoute,
    schoolRoute,
    goodsRoute,
    errorRoute,
    {path: '*', redirect: {name: viewConfig.page.notFound}}
];

export default routes;
