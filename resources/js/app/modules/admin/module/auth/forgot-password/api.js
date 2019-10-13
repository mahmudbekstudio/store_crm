import Route from "../../../api/route";

const api = {
    resetPassword: {
        ...Route.admin('reset-password'),
        callback: function(email) {
            this.data({
                email
            });
        }
    },
};

export default api;