(function () {
    "use strict";

    async function register() {
        // Reset state
        $("#register-form").find(".login__input").removeClass("border-danger");
        $("#register-form").find(".login__input-error").html("");

        // Post form
        let id_number = $("#id_number").val();
        let password = $("#password").val();
        let confirm_password = $("#confirm_password").val();
        let user_type = $("#user_type").val();
        let section = $("#section").val();

        // Loading state
        $("#btn-register").html(
            '<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>'
        );
        tailwind.svgLoader();
        await helper.delay(1500);

        axios
            .post(`register`, {
                id_number: id_number,
                password: password,
                confirm_password: confirm_password,
                user_type: user_type,
                section: section,
            })
            .then((res) => {
                //location.href = "student-profile";
                console.log(res);
            })
            .catch((err) => {
                console.log(err);
                $("#btn-register").html("Register");
                if (err.response.status == 422) {
                    Toastify({
                        node: $("#error-notification-content")
                            .clone()
                            .removeClass("hidden")[0],
                        duration: -1,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: "right",
                        stopOnFocus: true,
                    }).showToast();
                }
            });
    }

    $("#register-form").on("keyup", function (e) {
        if (e.keyCode === 13) {
            register();
        }
    });

    $("#btn-register").on("click", function () {
        register();
    });
})();
