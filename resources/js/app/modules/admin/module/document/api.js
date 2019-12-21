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
    },
    addRegion: {
        ...Route.admin('document.add-region'),
        callback: function(id, name) {
            this.urlParam('{id}', id);
            this.data({
                name
            });
        },
        token: true
    },
    addDistrict: {
        ...Route.admin('document.add-district'),
        callback: function(id, name, region) {
            this.urlParam('{id}', id);
            this.data({
                name,
                region
            });
        },
        token: true
    },
    deleteRegion: {
        ...Route.admin('document.delete-region'),
        callback: function (id, region) {
            this.urlParam('{id}', id);
            this.data({
                region
            });
        },
        token: true
    },
    deleteDistrict: {
        ...Route.admin('document.delete-district'),
        callback: function (id, district) {
            this.urlParam('{id}', id);
            this.data({
                district
            });
        },
        token: true
    }
};

export default api;
