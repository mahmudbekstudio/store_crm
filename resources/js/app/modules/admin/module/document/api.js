import Route from "../../api/route";

const api = {
    list: {
        ...Route.admin('document.list'),
        callback: function(id) {
            this.urlParam('{id}', id);
        },
        token: true
    },
    submit: {
        ...Route.admin('document.upload'),
        callback: function (file, district, id) {
            this.urlParam('{id}', id);
            this.setFormData({
                file: file,
                district: district,
            });
            this.headers({'Content-Type': 'multipart/form-data'});
        },
        token: true
    },
    delete: {
        ...Route.admin('document.delete'),
        callback: function (id) {
            this.urlParam('{id}', id);
        },
        token: true
    }
};

export default api;
