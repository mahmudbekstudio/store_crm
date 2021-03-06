import Route from "../../../api/route";

const api = {
    list: {
        ...Route.admin('school.list'),
        token: true
    },
    delete: {
        ...Route.admin('school.delete'),
        callback: function(id) {
            this.urlParam('{id}', id);
        },
        token: true
    }
};

export default api;