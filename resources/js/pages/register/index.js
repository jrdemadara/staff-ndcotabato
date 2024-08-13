import Toastify from "toastify-js";
(function () {
    "use strict";

    async function register() {
        // Reset state
        $("#register-form").find(".login__input").removeClass("border-danger");
        $("#register-form").find(".login__input-error").html("");

        // Post form
        let id_number = $("#id_number").val().trim();
        let password = $("#password").val().trim();
        let confirm_password = $("#confirm_password").val().trim();
        let user_type = $("#user_type").val().trim();
        let section = $("#section").val().trim();
        let isChecked = $("#policy").is(":checked");

        // Check inputs
        if (
            id_number !== "" &&
            password !== "" &&
            confirm_password !== "" &&
            user_type !== "" &&
            section !== ""
        ) {
            // Check password comfirmed
            if (password === confirm_password) {
                // Check if the checkbox is checked
                if (isChecked) {
                    if (id_number)
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
                            if (res.status === 201) {
                                Toastify({
                                    node: $("#success-notification-content")
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
                            $("#btn-register").html("Register");
                        })
                        .catch((err) => {
                            console.log(err);
                            $("#btn-register").html("Register");

                            if (err.response.status == 422) {
                                Toastify({
                                    node: $("#error-notification-content")
                                        .clone()
                                        .removeClass("hidden")[0],
                                    duration: 5000,
                                    newWindow: true,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    stopOnFocus: true,
                                }).showToast();
                            }
                            if (err.response.status == 500) {
                                Toastify({
                                    node: $("#error-500-notification-content")
                                        .clone()
                                        .removeClass("hidden")[0],
                                    duration: 5000,
                                    newWindow: true,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    stopOnFocus: true,
                                }).showToast();
                            }

                            if (err.response.data.status == "invalid-id") {
                                Toastify({
                                    node: $("#invalid-id-notification-content")
                                        .clone()
                                        .removeClass("hidden")[0],
                                    duration: 5000,
                                    newWindow: true,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    stopOnFocus: true,
                                }).showToast();
                            }

                            if (
                                err.response.data.status == "already-registered"
                            ) {
                                Toastify({
                                    node: $(
                                        "#already-registered-notification-content"
                                    )
                                        .clone()
                                        .removeClass("hidden")[0],
                                    duration: 5000,
                                    newWindow: true,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    stopOnFocus: true,
                                }).showToast();
                            }

                            if (err.response.data.status == "taken") {
                                Toastify({
                                    node: $("#taken-notification-content")
                                        .clone()
                                        .removeClass("hidden")[0],
                                    duration: 5000,
                                    newWindow: true,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    stopOnFocus: true,
                                }).showToast();
                            }
                        });
                } else {
                    Toastify({
                        node: $("#unchecked-notification-content")
                            .clone()
                            .removeClass("hidden")[0],
                        duration: 5000,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: "right",
                        stopOnFocus: true,
                    }).showToast();
                }
            } else {
                Toastify({
                    node: $("#confirm-password-notification-content")
                        .clone()
                        .removeClass("hidden")[0],
                    duration: 5000,
                    newWindow: true,
                    close: true,
                    gravity: "top",
                    position: "right",
                    stopOnFocus: true,
                }).showToast();
            }
        } else {
            // One or more fields are empty
            Toastify({
                node: $("#empty-input-notification-content")
                    .clone()
                    .removeClass("hidden")[0],
                duration: 5000,
                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
            }).showToast();
        }
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
