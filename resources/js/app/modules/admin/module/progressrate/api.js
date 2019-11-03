import Route from "../../api/route";

const api = {
    list: {
        ...Route.admin('progressrate.list'),
        token: true
    },
    detail: {
        ...Route.admin('progressrate.detail'),
        token: true
    },
    changeField: {
        ...Route.admin('progressrate.change-field'),
        callback: function (id, key, val) {
            this.data({
                id,
                key,
                val
            });
        },
        token: true
    },
    checkList: {
        ...Route.admin('progressrate.check-list'),
        token: true
    },
    changeFieldCheckList: {
        ...Route.admin('progressrate.change-field-check-list'),
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
        ...Route.admin('import.progressrate'),
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
