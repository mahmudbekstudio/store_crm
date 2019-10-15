import Route from "../../../api/route";

const api = {
    get: {
        ...Route.admin('goods.item'),
        callback: function(id) {
            this.urlParam('{id}', id);
        },
        token: true
    },
    update: {
        ...Route.admin('goods.edit'),
        callback: function(id, name) {
            this.urlParam('{id}', id);
            this.data({ name });
        },
        token: true
    },
    add: {
        ...Route.admin('goods.add'),
        callback: function(name) {
            this.data({ name });
        },
        token: true
    }
};

export default api;