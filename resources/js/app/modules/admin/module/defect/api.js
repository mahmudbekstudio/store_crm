import Route from "../../api/route";

const api = {
    list: {
        ...Route.admin('defect.list'),
        token: true
    },
    submit: {
        ...Route.admin('import.defect'),
        callback: function(file) {
            this.setFormData({
                file: file
            });
            this.headers({'Content-Type': 'multipart/form-data'});
        },
        token: true
    }
};

export default api;