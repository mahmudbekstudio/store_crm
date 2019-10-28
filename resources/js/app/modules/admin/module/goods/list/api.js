import Route from "../../../api/route";

const api = {
    list: {
        ...Route.admin('goods.list'),
        token: true
    },
    delete: {
        ...Route.admin('goods.delete'),
        callback: function(id) {
            this.urlParam('{id}', id);
        },
        token: true
    }
};

export default api;