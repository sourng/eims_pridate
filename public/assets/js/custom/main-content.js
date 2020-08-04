MainContent = function (opts) {
    var defaults = {
        url: null,
        targetContainer: null,
        loading: '<tr class="loading"><td colspan="10" class="text-center p-3"><div class="spinner spinner-3 text-blue"></div></td></tr>',
        loadingContainer: null,
        onBeforeSend: null,
        onSuccess: null
    };
    var ajax = null;
    var o = $.extend(defaults, opts);
    this.set = function (options) {
        o = $.extend(o, options);
    };

    var onBeforeSend = function () {
            if (loadingContainer) {
                loadingContainer.prepend(loading);
            }
        },
        onSuccess = function (response, newDocument) {
            if (response) {
                var urlhelper = new UrlHelper();
                urlhelper.set(o.url, o.url);

                var newMaincontent = $(newDocument).find("div.main-content");
                targetContainer.html(newMaincontent.html());
                $.getScript(location.origin + "/assets/js/argon.min.js");
            }
        };
    this.load = function () {
        if (o.url) {
            if (ajax) {
                ajax.abort();
            }
            ajax = $.ajax({
                url: o.url,
                method: "GET",
                processData: true,
                contentType: "text/html",
                beforeSend: function (xhr) {
                    if (o.onBeforeSend) {
                        o.onBeforeSend(xhr);
                    } else {
                        onBeforeSend(xhr);
                    }
                },
                success: function (response) {

                    var newDocument = new DOMParser()
                        .parseFromString(response, "text/html");
                    if (o.onSuccess) {
                        o.onSuccess(response, newDocument);
                    } else {
                        onSuccess(response, newDocument);                    }
                }
            });
        }
    };
    this.stop = function () {
        if (ajax) {
            ajax.abort();
        }

    }
};
