import Route from "../../../api/route";

const api = {
    list: {
        ...Route.admin('user.list'),
        token: true
    },
    delete: {
        ...Route.admin('user.delete'),
        callback: function(id) {
            this.urlParam('{id}', id);
        },
        token: true
    }
};

export default api;