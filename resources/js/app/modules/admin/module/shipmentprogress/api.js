import Route from "../../api/route";

const api = {
    list: {
        ...Route.admin('shipment-progress.list'),
        callback: function(id) {
            this.urlParam('{id?}', id);
        },
        token: true
    },
    /*detail: {
        ...Route.admin('stock.detail'),
        callback: function(id) {
            this.urlParam('{id}', id);
        },
        token: true
    },
    changeField: {
        ...Route.admin('stock.change-field'),
        callback: function (id, key, val) {
            this.data({
                id,
                key,
                val
            });
        },
        token: true
    },*/
    submit: {
        ...Route.admin('import.shipment-progress'),
        callback: function (file) {
            this.setFormData({
                file: file
            });
            this.headers({'Content-Type': 'multipart/form-data'});
        },
        token: true
    }
};

export default api;
