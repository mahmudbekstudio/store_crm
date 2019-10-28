import viewConfig from '../config/view';
import authRoute from './auth/route';
import dashboardRoute from './dashboard/route';
import regionRoute from './region/route';
import districtRoute from './district/route';
import schoolRoute from './school/route';
import categoryRoute from './category/route';
import goodsRoute from './goods/route';
import userRoute from './user/route';
import errorRoute from './error/route';
import defectRoute from './defect/route';

const routes = [
    {path: '/', redirect: {name: viewConfig.page.default}},
    authRoute,
    dashboardRoute,
    regionRoute,
    districtRoute,
    schoolRoute,
    categoryRoute,
    goodsRoute,
    defectRoute,
    userRoute,
    errorRoute,
    {path: '*', redirect: {name: viewConfig.page.notFound}}
];

export default routes;
