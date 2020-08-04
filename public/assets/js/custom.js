!(function($) {
    "use strict";
    $(function() {
        $('[data-toggle="sweet-alert"]').on("click", function(e) {
            e.preventDefault();
            var self = $(this),
                url  = $(this).attr("href"),
                id   = $(this).attr("data-sweet-alert-controls-id");
                
            switch ($(this).data("sweet-alert")) {
                case "basic":
                    swal({
                        title: "Here's a message!",
                        text: "A few words about this sweet alert ...",
                        buttonsStyling: !1,
                        confirmButtonClass: "btn btn-primary"
                    });
                    break;
                case "info":
                case "info":
                    swal({
                        title: "Info",
                        text: "A few words about this sweet alert ...",
                        type: "info",
                        buttonsStyling: !1,
                        confirmButtonClass: "btn btn-info"
                    });
                    break;
                case "success":
                    swal({
                        title: "Success",
                        text: "A few words about this sweet alert ...",
                        type: "success",
                        buttonsStyling: !1,
                        confirmButtonClass: "btn btn-success"
                    });
                    break;
                case "warning":
                    swal({
                        title: "Warning",
                        text: "A few words about this sweet alert ...",
                        type: "warning",
                        buttonsStyling: !1,
                        confirmButtonClass: "btn btn-warning"
                    });
                    break;
                case "question":
                    swal({
                        title: "Are you sure?",
                        text: "A few words about this sweet alert ...",
                        type: "question",
                        buttonsStyling: !1,
                        confirmButtonClass: "btn btn-default"
                    });
                    break;
                case "confirm":
                    $.get(url).done(function(data) {

                        swal({
                            title: data.message.title,
                            html: data.message.text,
                            type: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonClass: "btn btn-danger",
                            confirmButtonText: data.message.button.confirm,
                            cancelButtonClass: "btn btn-secondary",
                            cancelButtonText: data.message.button.cancel
                        }).then(e => {
                            if (e.value) {
                                var formData = new FormData();
                                $.ajax({
                                    url: url,
                                    method: "POST",
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(data) {
                                        if (data.success) {
                                            if(id){
                                                $.each(id.split(","),function(){
                                                    $('[data-sweet-alert-id="'+this+'"]').remove();
                                                });
                                            }


                                            swal({
                                                title: data.message.title,
                                                text: data.message.text,
                                                type: "success",
                                                buttonsStyling: !1,
                                                confirmButtonClass:
                                                    "btn btn-primary",
                                                confirmButtonText:
                                                    data.message.button.confirm
                                            });
                                        }
                                    },
                                    error: function(erorr) {
                                    }
                                });
                            }
                        });
                    });

                    break;
                case "image":
                    swal({
                        title: "Sweet",
                        text: "Modal with a custom image ...",
                        imageUrl: "../../assets/img/ill/ill-1.svg",
                        buttonsStyling: !1,
                        confirmButtonClass: "btn btn-primary",
                        confirmButtonText: "Super!"
                    });
                    break;
                case "timer":
                    swal({
                        title: "Auto close alert!",
                        text: "I will close in 2 seconds.",
                        timer: 2e3,
                        showConfirmButton: !1
                    });
            }
        });
    });
})(jQuery);
