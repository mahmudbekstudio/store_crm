import Route from "../../../api/route";

const api = {
    get: {
        ...Route.admin('user.item'),
        callback: function(id) {
            this.urlParam('{id}', id);
        },
        token: true
    },
    update: {
        ...Route.admin('user.edit'),
        callback: function(id, form) {
            this.urlParam('{id}', id);
            this.data(form);
        },
        token: true
    },
    add: {
        ...Route.admin('user.add'),
        callback: function(form) {
            this.data(form);
        },
        token: true
    },
    params: {
        ...Route.admin('user.params'),
        token: true
    }
};

export default api;