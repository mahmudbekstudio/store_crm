import auth from './auth';
import Route from "./route";

const defaultApi = {
    website: {
        ...Route.admin('website'),
        token: true
    },
};

export default {
    auth,
    default: defaultApi
};
