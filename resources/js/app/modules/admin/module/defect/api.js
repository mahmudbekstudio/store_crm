import Route from "../../api/route";

const api = {
    list: {
        ...Route.admin('defect.list'),
        token: true
    },
    changeField: {
        ...Route.admin('defect.change-field'),
        callback: function(id, key, val) {
            this.data({
                id,
                key,
                val
            });
        },
        token: true
    },
    addRecord: {
        ...Route.admin('defect.add-record'),
        callback: function (list) {
            this.data({
                list
            });
        },
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