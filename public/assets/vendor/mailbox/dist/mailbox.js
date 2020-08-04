var Mailbox = {
    Modals: {
        Compose: function () {
            this.init = function () {
                    this.builder();
                },
                this.builder = function (element) {
                    var e = element ? element : $('[data-toggle="mailbox-modal"]');
                    e.length && e.each(function () {
                        $(this).click(function (event) {
                            event.preventDefault();
                            var target = $(this).data("target");
                            $(target).find("form").get(0).reset();
                            $(target).modal();
                            // if ($(target).length) {
                            //     $(target).modal();
                            //     var ajaxModal = new AjaxFormModal();
                            //     ajaxModal.set({
                            //         element: $(this),
                            //         modalContainer: $(target),
                            //         url: $(this).attr("href"),
                            //         method: "GET",
                            //         onCompleted: (xhr, type, modalBody) => {
                            //             if (type == "success") {
                            //                 modalBody.show();
                            //                 var formCompose = new Mailbox.Forms.Compose();
                            //                 formCompose.builder($(target).find("form"));
                            //             }
                            //         }
                            //     });
                            //     ajaxModal.load();
                            // }

                        })
                    });
                }

        }

    },
    Forms: {
        Compose: function () {
            this.init = function () {
                    this.builder();
                },
                this.builder = function (element) {
                    var e = element ? element : $('form[data-toggle="mailbox-compose"]');

                    e.length && e.unbind().each(function () {
                        var form = $(this);

                        // tinymce.init({
                        //     selector:'#message',
                        //     toolbar: 'bold italic underline strikethrough | fontselect fontsizeselect formatselect | forecolor backcolor | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | link image media',
                        // });

                        Quill.prototype.getHtml = function () {
                            return this.container.firstChild.innerHTML;
                        };


                        var name = form.find('#message').data("name");
                        if (name) {

                            var toolbarOptions = [
                                [{
                                    'font': []
                                }],
                                [{
                                    'size': ['small', false, 'large', 'huge']
                                }], // custom dropdown
                                //[{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                                ['bold', 'italic', 'underline', 'strike'], // toggled buttons
                                [{
                                    'color': []
                                }, {
                                    'background': []
                                }], // dropdown with defaults from theme
                                [{
                                    'list': 'ordered'
                                }, {
                                    'list': 'bullet'
                                }, {
                                    'align': []
                                }],
                                [{
                                    'script': 'sub'
                                }, {
                                    'script': 'super'
                                }], // superscript/subscript
                                [{
                                    'indent': '-1'
                                }, {
                                    'indent': '+1'
                                }], // outdent/indent
                                [{
                                    'direction': 'rtl'
                                }], // text direction
                                ["link", "image", "video"],

                            ];

                            var quill = new Quill(form.find('#message').get(0), {
                                modules: {
                                    imageResize: {
                                        modules: ['Resize', 'DisplaySize', 'Toolbar']
                                    },
                                    // videoResize: {
                                    //     modules: ['Resize', 'DisplaySize', 'Toolbar']
                                    // },
                                    toolbar: toolbarOptions,
                                },
                                placeholder: form.find('#message').data("placeholder"),
                                theme: "snow"
                            });

                            var toolbar = quill.getModule('toolbar');
                            toolbar.addHandler('image', imageHandler);
                            toolbar.addHandler('link', linkHandler);

                            function linkHandler() {



                                var range = this.quill.getSelection();
                                var text = quill.getText(range.index, range.length);

                                if ($("div.modal#mailbox-compose-link").length) {

                                    var url = $("div.modal#mailbox-compose-link").find("input#url");
                                    var url_display = $("div.modal#mailbox-compose-link").find("input#text_to_display");
                                    url.val("");
                                    url_display.val(text);

                                    $("div.modal#mailbox-compose-link").find("button#btn-save").unbind().click(() => {

                                        if (url.val() && url_display.val()) {
                                            var html = '<a href="' + url.val() + '">' + url_display.val() + '</a>';
                                            quill.deleteText(range.index, range.length);
                                            quill.clipboard.dangerouslyPasteHTML(range.index, html);
                                            $("div.modal#mailbox-compose-link").modal("hide");
                                            url.val("");
                                            url_display.val("");
                                        }

                                    });

                                    $("div.modal#mailbox-compose-link").find("button#btn-remove").unbind().click(() => {
                                        quill.deleteText(range.index, range.length);
                                        quill.clipboard.dangerouslyPasteHTML(range.index, text);
                                        $("div.modal#mailbox-compose-link").modal("hide");
                                    });
                                    $("div.modal#mailbox-compose-link").modal();
                                }


                            }

                            function imageHandler() {

                                $("div.modal#mailbox-compose-image").find("div#preview-image").html("");
                                $("div.modal#mailbox-compose-image").find("input#url").val("");
                                $("div.modal#mailbox-compose-image").find("input#upload").val("");

                                var range = this.quill.getSelection();
                                if ($("div.modal#mailbox-compose-image").length) {
                                    $("div.modal#mailbox-compose-image").find("input#url").unbind().on("input", (event) => {
                                        $("div.modal#mailbox-compose-image").find("div#preview-image").html('<img class="w-100" data-src="' + $(event.target).val() + '">');

                                        new LazyLoad({
                                            callback_error: el => {
                                                $(el).remove();
                                            }
                                        }, $("div.modal#mailbox-compose-image").find("div#preview-image").find("img"));

                                    });
                                    var ajaxupload = null;
                                    $("div.modal#mailbox-compose-image").find("input#upload").unbind().on("change", (event) => {
                                        var file = event.target.files[0];
                                        var formData = new FormData();
                                        formData.append($(event.target).data("name"), file);
                                        ajaxupload = $.ajax({
                                            url: $(event.target).data("url"),
                                            method: "POST",
                                            data: formData,
                                            processData: false,
                                            contentType: false,
                                            xhr: function () {
                                                var xhr = new XMLHttpRequest();
                                                xhr.onprogress = function (e) {
                                                    if (e.lengthComputable) {
                                                        // console.log(parseInt(e.loaded / e.total * 100) + '%');
                                                    }
                                                };
                                                xhr.upload.onprogress = function (e) {
                                                    if (e.lengthComputable) {
                                                        $("div.modal#mailbox-compose-image").find("div#preview-image").html('<div class="text-center text-muted">' + parseInt(e.loaded / e.total * 100) + "%" + '</div>');
                                                    }
                                                };
                                                return xhr;
                                            },
                                            beforeSend: function () {
                                                $("div.modal#mailbox-compose-image").find("div#preview-image").html("");
                                            },
                                        }).done(function (response) {
                                            if (response.success) {
                                                $("div.modal#mailbox-compose-image").find("input#url").val(response.data[0]);
                                                $("div.modal#mailbox-compose-image").find("div#preview-image").html('<img class="w-100" data-src="' + response.data[0] + '">');
                                            }
                                            new LazyLoad({
                                                callback_error: el => {
                                                    $(el).remove();
                                                }
                                            }, $("div.modal#mailbox-compose-image").find("div#preview-image").find("img"));
                                        });
                                    });
                                    $("div.modal#mailbox-compose-image").find("button#btn-save").unbind().click(() => {
                                        if ($("div.modal#mailbox-compose-image").find("input#url").val()) {
                                            this.quill.insertEmbed(range.index, 'image', $("div.modal#mailbox-compose-image").find("input#url").val(), Quill.sources.USER);
                                            $("div.modal#mailbox-compose-image").modal("hide");
                                        }

                                    });
                                    $("div.modal#mailbox-compose-image").modal();
                                } else {

                                    var value = prompt('What is the image URL');
                                    if (value) {
                                        this.quill.insertEmbed(range.index, 'image', value, Quill.sources.USER);
                                    }
                                }

                            }

                            quill.on('text-change', function () {
                                if (form.find('[name="' + name + '"]').length) {
                                    form.find('[name="' + name + '"]').val(quill.getHtml());

                                } else {
                                    var textarea = $("<textarea name='" + name + "'>").val(quill.getHtml()).addClass("d-none");
                                    form.find('#message').after(textarea);
                                }
                            });
                        }




                        if (form.data("validation")) {
                            var load = $('<span class="loading ml-2"><img src="' + location.origin + '/assets/img/icons/LOOn0JtHNzb.gif"></span>');
                            form.attr({
                                hasValidate: true
                            }).validation({
                                request_field: $(this).data("validation"),
                                onBeforeSend: (xhr, loading) => {
                                    $(this).find('button[type="submit"]').append(load);
                                },
                                onSuccess: (response) => {
                                    load.remove();
                                    if (response.success) {}
                                }
                            });
                        }


                    });
                }
        },

        Taginputs: function (elements) {
            this.init = function () {
                this.builder();
            }
            this.builder = function (element) {
                    var template = this.template();
                    element = element ? element : elements;
                    element.length && element.each(function () {
                        var $template = $(template);
                        $(this).hide();
                        $(this).attr("disabled", "disabled");
                        var url = $(this).data("ajax");
                        var placeholder = $(this).data("placeholder");
                        $(this).after($template);
                        var ajax = null;
                        var name = $(this).data("name");


                        function change_selection(array_element, current_index) {
                            array_element.removeAttr('selected');
                            array_element.eq(current_index).attr('selected', 'selected');
                        }

                        $template.click(() => {
                            $template.find('input').focus();
                        });
                        $template.find('input').attr("placeholder", placeholder)
                            .on("input focus keyup", function (event) {
                                var val = $(this).val();
                                var offset = $(this).offset();

                                $("div.users-in-search").removeClass("hidden");

                                // Backspace
                                if ($("div.users-in-search").length && val == "") {
                                    $("div.users-in-search").css({
                                        'left': offset.left - 50
                                    });
                                    $("div.users-in-search").show();
                                }
                                //Backspace
                                if (event.keyCode === 8) {
                                    if (val == "") {
                                        if ($(this).parent().prev().length > 0) {
                                            if ($(this).parent().prev().length > 0) {
                                                if ($(this).parent().prev().hasClass("selected")) {
                                                    var userid = $(this).parent().prev().data("userid");
                                                    $(this).parent().prev().remove();
                                                    offset = $(this).offset();
                                                    $("div.users-in-search").find("div.user#" + userid).show();
                                                    $("div.users-in-search").css({
                                                        'left': offset.left - 50
                                                    });
                                                } else {
                                                    $(this).parent().prev().addClass("selected");
                                                }
                                                $(this).attr("placeholder", "");
                                            } else {
                                                $(this).attr("placeholder", placeholder);
                                            }

                                        }
                                    }
                                    return false;
                                } else {
                                    $template.find("li[data-userid]").removeClass("selected");
                                }

                                var current_index = $('div.users-in-search div.user[selected]').index(),
                                    items_total = $('div.users-in-search div.user').length;
                                if (event.keyCode == 40) { //down arrow
                                    if (current_index + 1 < items_total) {
                                        current_index++;
                                        change_selection($('div.users-in-search div.user'), current_index);
                                        event.preventDefault();
                                        return false;
                                    }
                                } else if (event.keyCode == 38) { // up arrow
                                    if (current_index > 0) {
                                        current_index--;
                                        change_selection($('div.users-in-search div.user'), current_index);
                                        event.preventDefault();
                                        return false;
                                    }
                                } else if (event.keyCode == 13) { // Enter key

                                    if (current_index != -1) {
                                        $('div.users-in-search div.user')[current_index].click();
                                    }
                                    event.preventDefault();
                                    return false;

                                }



                                if (ajax) {
                                    ajax.abort();
                                }
                                ajax = $.ajax({
                                    url: url,
                                    type: "GET",
                                    dataType: "json",
                                    processData: true,
                                    contentType: "application/json",
                                    data: {
                                        search: val,
                                        selected: $template.find('li[data-userid]').length ? $template.find('li[data-userid]').map((i, el) => {
                                            return $(el).data("userid")
                                        }).toArray() : []
                                    },
                                    success: function (response) {
                                        if (response.success) {

                                            var $users_in_search = $('<div class="users-in-search"></div>');
                                            if ($("div.users-in-search").length) {
                                                var $users_in_search = $("div.users-in-search");
                                            } else {
                                                $template.after($users_in_search);
                                            }
                                            $users_in_search.find("div.user").hide();

                                            $.each(response.data, function () {
                                                var username = this.name;
                                                var user_id = this.id;
                                                var profile = this.profile;

                                                if ($template.find('li[data-userid="' + user_id + '"]').length == 0) {

                                                    var $users_in_search_one_user = $('<div class="user" id="' + user_id + '"><img draggable="false" data-src="' + profile + '"><span class="user-name">' + username + '</span></div>');

                                                    $users_in_search_one_user.on('click', function (event) {
                                                        $("#has-error-for-" + name.replace("[", "").replace("]", "")).remove();
                                                        $template.find('li[data-userid]').removeClass("selected");
                                                        var $self = $(this);

                                                        var $liuser = $('<li data-userid=' + user_id + '><input type="hidden" name="' + name + '" value=' + user_id + '><span><img draggable="false" data-src="' + profile + '"></span><span>' + username + '</span><button type="button"><i class="fas fa-times"></i></button></li>');

                                                        $liuser.find("button").click(function (event) {
                                                            event.preventDefault();
                                                            $liuser.remove();
                                                            $self.show();
                                                            $template.find('input').focus();
                                                        });

                                                        $template.find("li.input>input").val("");
                                                        $template.find("li.input").before($liuser);
                                                        $(this).hide();
                                                        $template.find('input').focus();
                                                        if (lazyLoadInstance) {
                                                            lazyLoadInstance.update();
                                                        }

                                                    });
                                                    if ($users_in_search.find("div.user#" + user_id).length == 0) {
                                                        $users_in_search.append($users_in_search_one_user);
                                                    } else {
                                                        $users_in_search.find("div.user#" + user_id).show();
                                                    }
                                                    if (lazyLoadInstance) {
                                                        lazyLoadInstance.update();
                                                    }
                                                }
                                            });

                                            $users_in_search.css({
                                                'margin-top': '-2px',
                                                'left': offset.left - 50
                                            });
                                            $users_in_search.animate({
                                                'opacity': '1',
                                            });

                                        } else {
                                            if ($template.find('li[data-userid]').length == $("div.users-in-search").find("div.user").length) {
                                                $("div.users-in-search").hide();
                                            }

                                        }
                                    }
                                });

                            }).blur(() => {
                                $("div.users-in-search").addClass("hidden");
                            });
                        $(document).not($template).click(() => {
                            console.log($("div.users-in-search").hasClass("hidden"))
                            if ($("div.users-in-search").hasClass("hidden")) {
                                $("div.users-in-search").hide();
                            }

                        });
                    });

                },
                this.template = function () {
                    var template = '<div class="taginputs-wapper form-control">';
                    template += '<div class="users">';
                    template += '<ul>';
                    template += '<li class="input"><input class="form-control"></li>';
                    template += '</ul>';
                    template += '</div>';
                    template += '</div>';

                    return template;
                }
        }
    },
    Nav: function () {
        this.init = function () {

            },
            this.builder = function () {

            }

    }

};

$(document).ready(function () {

    var formCompose = new Mailbox.Forms.Compose();
    formCompose.init();
    formCompose.builder($('form[data-toggle="mailbox-reply"]'));


    var taginputs = new Mailbox.Forms.Taginputs($('[data-toggle="taginputs"]'));
    taginputs.init();

    var modalCompose = new Mailbox.Modals.Compose();
    modalCompose.init();



    $("[datetime]").timeago();
});
