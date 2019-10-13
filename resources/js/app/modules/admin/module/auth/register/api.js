import Route from "../../../api/route";

const api = {
    register: {
        ...Route.admin('register'),
        callback: function(email, password, password2) {
            this.data({
                email,
                password,
                password2
            });
        }
    },
};

export default api;