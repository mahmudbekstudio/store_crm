import Route from "../../../api/route";

const api = {
    list: {
        ...Route.admin('district.list'),
        token: true
    },
    /*delete: {
        ...Route.admin('region.delete'),
        callback: function(id) {
            this.urlParam('{id}', id);
        },
        token: true
    }*/
};

export default api;