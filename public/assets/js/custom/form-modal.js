AjaxFormModal = function(opts) {
    var defaults = {
            modalContainer: $(".modal"),
            url: null,
            method: "GET",
            onBeforeSend: null, //(xhr ,loading)=>{}
            onSuccess: null, //(response)=>{}
            onCompleted: null, //(response)=>{}
            onError: null //(xhr, type, error)=> {}
        },
        settings = $.extend(defaults, opts);

    this.set = options => {
        settings = $.extend(settings, options);
    };

    this.load = () => {
        ajax();
    };
    var ajax = () => {
            $.ajax({
                url: settings.url,
                method: settings.method,
                processData: true,
                contentType: "text/html",
                beforeSend: xhr => {
                    typeof settings.onBeforeSend == "function"
                        ? settings.onBeforeSend(xhr)
                        : onBeforeSend(xhr);
                },
                success: response => {
                    typeof settings.onBeforeSend == "function"
                        ? settings.onSuccess(response)
                        : onSuccess(response);
                },
                error: (xhr, type, error) => {
                    typeof settings.onBeforeSend == "function"
                        ? settings.onError(xhr, type, error)
                        : onError(xhr, type, error);
                }
            });
        },
        onBeforeSend = xhr => {
            settings.modalContainer.find(".full-link").attr("href",settings.url);
            settings.modalContainer
                .find(".modal-dialog")
                .removeClass("modal-xl")
                .removeClass("modal-lg")
                .removeClass("modal-md")
                .removeClass("modal-sm")
                .removeClass("modal-xs");

            settings.modalContainer.find(".modal-title").html("");
            settings.modalContainer.find(".modal-footer").html("");
            settings.modalContainer
                .find(".card-body")
                .addClass("text-center")
                .html('<div class="spinner spinner-3"></div>');
        },
        onSuccess = response => {
            var newDocument = new DOMParser().parseFromString(
                    response,
                    "text/html"
                ),
                newModal = $(newDocument).find("div.modal"),
                newModalHeader = newModal.find("div.modal-header");
            var oldModal = settings.modalContainer,
                oldModalHeader = oldModal.find("div.modal-header"),
                oldModalBody = oldModal.find("div.modal-body");


                oldModal.html(newModal.html());
                oldModalHeader.html(newModalHeader.html());

                var loadstyle = settings.element ?  settings.element.data("loadstyle") : [];
                var loadscript = settings.element ?  settings.element.data("loadscript") : [];


                if (loadstyle) {
                    $.each(loadstyle, (i, link) => {
                        var style = $("<link>").attr({
                            rel: "stylesheet",
                            href: link,
                            type: "text/css",
                        });
                        $("head").append(style);
                    });
                }
                if (loadscript) {
                    $.each(loadscript, (i, script) => {
                        $.getScript(script);
                    });
                }



            $.getScript(location.origin + "/assets/js/argon.min.js").done(
                (response, type, xhr) => {
                    if (type == "success") {
                        typeof settings.onCompleted == "function"
                            ? settings.onCompleted(xhr, type, oldModalBody)
                            : onCompleted(xhr, type, oldModalBody);
                    }
                }
            );
        },
        onCompleted = (xhr, type, modalBody) => {
            if (type == "success") {
                modalBody.show();
            }
        },
        onError = (xhr, type, error) => {
            settings.modalContainer
                .find(".card-body")
                .addClass("text-center")
                .html(xhr.responseJSON ? xhr.responseJSON.message : error);
        };
};
