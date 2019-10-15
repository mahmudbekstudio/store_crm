import Route from "../../../api/route";

const api = {
    regionsList: {
        ...Route.admin('region.list'),
        token: true
    },
    get: {
        ...Route.admin('school.item'),
        callback: function(id) {
            this.urlParam('{id}', id);
        },
        token: true
    },
    update: {
        ...Route.admin('school.edit'),
        callback: function(id, name, region_id) {
            this.urlParam('{id}', id);
            this.data({ name, region_id });
        },
        token: true
    },
    add: {
        ...Route.admin('school.add'),
        callback: function(name, region_id) {
            this.data({ name, region_id });
        },
        token: true
    }
};

export default api;