import Route from "../../../api/route";

const api = {
    list: {
        ...Route.admin('goodsCategory.list'),
        token: true
    },
    /*delete: {
        ...Route.admin('goodsCategory.delete'),
        callback: function(id) {
            this.urlParam('{id}', id);
        },
        token: true
    }*/
};

export default api;