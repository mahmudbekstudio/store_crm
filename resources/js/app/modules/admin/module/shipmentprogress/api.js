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
    },*/
    changeField: {
        ...Route.admin('shipment-progress.change-field'),
        callback: function (id, key, val) {
            this.data({
                id,
                key,
                val
            });
        },
        token: true
    },
    submit: {
        ...Route.admin('import.shipment-progress'),
        callback: function (file, sheetNo) {
            this.setFormData({
                file: file,
                sheetNo: sheetNo
            });
            this.headers({'Content-Type': 'multipart/form-data'});
        },
        token: true
    }
};

export default api;