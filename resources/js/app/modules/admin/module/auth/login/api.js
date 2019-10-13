import Route from "../../../api/route";

const api = {
    login: {
        ...Route.admin('login'),
        callback: function(email, password) {
            this.data({
                email,
                password
            });
        }
    },
};

export default api;