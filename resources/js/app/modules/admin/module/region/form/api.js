import Route from "../../../api/route";

const api = {
    get: {
        ...Route.admin('region.item'),
        callback: function(id) {
            this.urlParam('{id}', id);
        },
        token: true
    },
    update: {
        ...Route.admin('region.edit'),
        callback: function(id, name) {
            this.urlParam('{id}', id);
            this.data({ name });
        },
        token: true
    },
    add: {
        ...Route.admin('region.add'),
        callback: function(name) {
            this.data({ name });
        },
        token: true
    }
};

export default api;