(function($) {
    $.fn.localeLanguages = function(options = {}) {
        if ($(this).length == 0) return false;

        var defaults = {
            view: "dropdown",
            get: "selected",
            url: "http://rpitssr.edu/api/language",
            method: "GET",
            data: {},
            onBeforeSend: function(xhr) {},
            onSuccess: function(response) {},
            onError: function(xhr, type, error) {},
            current_locale: "a",
            current_locale_id: "navbarDropdownMenuLink2",
            current_locale_class: "nav-link dropdown-toggle",
            current_locale_data_toggle: "dropdown",
            current_locale_flag: "img",
            current_locale_flag_width: 26,
            languagesContainer: "ul",
            languagesContainer_class:
                "dropdown-menu dropdown-menu-right py-0 overflow-hidden",
            languagesContainer_aria_labelledby: "navbarDropdownMenuLink2",
            list_languagesContainer: "li",
            list_languages: "a",
            list_languages_class: "dropdown-item",
            list_languages_flag: "img",
            list_languages_flag_width: 26,
            list_languages_text: "span",
            list_languages_selected: "li",
            list_languages_selected_class: "fas fa-check pull-right"
        };
        var settings = $.extend(defaults, options),
            ajax = () => {
                $.ajax({
                    url: settings.url,
                    method: settings.method,
                    data: settings.data,
                    beforeSend: xhr => {
                        // options.hasOwnProperty("onBeforeSend") &&
                        // "function" == typeof options.onBeforeSend
                        //     ? settings.onBeforeSend(xhr)
                        //     : onBeforeSend(xhr);
                    },
                    success: response => {
                        options.hasOwnProperty("onSuccess") &&
                        "function" == typeof options.onSuccess
                            ? settings.onSuccess(response)
                            : onSuccess(response);
                    },
                    error: (xhr, type, error) => {
                        options.hasOwnProperty("onError") &&
                        "function" == typeof options.onError
                            ? settings.onError(xhr, type, error)
                            : onError(xhr, type, error);
                    }
                });
            };
        ajax();
        var onBeforeSend = xhr => {},
            onSuccess = response => {
                if (settings.view == "dropdown" && response.success) {
                    dropdown(response);
                } else if (settings.view == "table" && response.success) {
                    table(response);
                } else if (settings.view == "select" && response.success) {
                    select(response);
                }
            },
            onError = (xhr, type, error) => {},
            dropdown = response => {
                if (response.success) {
                    var locale = response.data.locale,
                        languages =
                            settings.get == "selected"
                                ? response.data.languages
                                : response.data.country,
                        current_locale = $(
                            document.createElement(settings.current_locale)
                        ).attr({
                            href: "#",
                            class: settings.current_locale_class,
                            "data-toggle": settings.current_locale_data_toggle,
                            id: settings.current_locale_id
                        });
                    (current_locale_flag = $(
                        document.createElement(settings.current_locale_flag)
                    ).css({
                        width: settings.current_locale_flag_width
                    })),
                        (languagesContainer = $(
                            document.createElement(settings.languagesContainer)
                        ).attr({
                            class: settings.languagesContainer_class,
                            "aria-labelledby":
                                settings.languagesContainer_aria_labelledby
                        }));

                    languages.map(({ id, language, languageCode, flag }) => {
                        var li = $(
                                document.createElement(
                                    settings.list_languagesContainer
                                )
                            ),
                            a = $(
                                document.createElement(settings.list_languages)
                            )
                                .attr({
                                    class: settings.list_languages_class,
                                    href:
                                        location.origin +
                                        "/language/set/" +
                                        languageCode
                                })
                                .on("click", function(e) {
                                    e.preventDefault();
                                    if(locale != languageCode){
                                        setLocale(languageCode);
                                    }
                                })
                                .appendTo(li),
                            img = $(
                                document.createElement(
                                    settings.list_languages_flag
                                )
                            )
                                .attr({
                                    src: flag
                                })
                                .css({
                                    width: settings.list_languages_flag_width
                                })
                                .appendTo(a),
                            span = $(
                                document.createElement(
                                    settings.list_languages_text
                                )
                            )
                                .html(language)
                                .appendTo(a),
                            selected = $(
                                document.createElement(
                                    settings.list_languages_selected
                                )
                            ).addClass(settings.list_languages_selected_class);
                        if (locale == languageCode) {
                            selected.appendTo(a);
                            current_locale_flag
                                .attr({ src: flag })
                                .appendTo(current_locale);
                        }
                        li.appendTo(languagesContainer);
                    });
                    $(this)
                        .html(current_locale)
                        .append(languagesContainer);
                }
            },
            table = response => {
                if (response.success) {
                    var locale = response.data.locale,
                        headers = response.data.headers,
                        languages =
                            settings.get == "selected"
                                ? response.data.languages
                                : response.data.country,
                        table = $("<table></table>").attr({
                            class: "table table-hover table-bordered",
                            id: "tbl_language"
                        }),
                        thead = $("<thead></thead>").appendTo(table),
                        thead_tr = $("<tr></tr>").appendTo(thead),
                        tbody = $("<tbody></tbody>");
                    for (var i in headers) {
                        var th = $("<th></th>")
                            .html(headers[i])
                            .appendTo(thead_tr);
                    }

                    if ("object" == typeof languages) {
                        languages.map(
                            ({ id, language, languageCode, flag }) => {
                                var tr = $("<tr></tr>"),
                                    td = $("<td></td>"),
                                    img = $("<img>"),
                                    span = $("<span></span>");
                                a = $("<a></a>");

                                td.html(id).appendTo(tr);
                                td = $("<td></td>");
                                img.attr({
                                    class: "img-flag",
                                    style: "width: 26px;",
                                    src: flag
                                }).appendTo(td);
                                span.html(language)
                                    .css({ padding: 5 })
                                    .appendTo(td);
                                td.appendTo(tr);
                                td = $("<td></td>");
                                td.html(languageCode).appendTo(tr);
                                td = $("<td></td>");

                                a.attr({
                                    href:
                                        settings.url +
                                        "/delete/lang/" +
                                        languageCode,
                                    class: "btn btn-danger btn-sm remove-key"
                                })
                                    .html("delete")
                                    .on("click", function(e) {
                                        e.preventDefault();
                                    })
                                    .css({
                                        visibility:
                                            languageCode == "en" ||
                                            languageCode == "km"
                                                ? "hidden"
                                                : "visible"
                                    })
                                    .appendTo(td);

                                td.appendTo(tr);
                                tr.appendTo(tbody);
                            }
                        );
                    }

                    tbody.appendTo(table);
                    $(this).html(table);
                }
            },
            select = response => {
                if (response.success) {
                    var locale = response.data.locale,
                        selected = response.data.selected,
                        languages =
                            settings.get == "selected"
                                ? response.data.languages
                                : response.data.country;
                    $(this).html("");

                    languages.map(({ id, language, languageCode, flag }) => {
                        var option = $("<option>")
                            .attr({
                                value: languageCode,
                                flag: flag
                            })
                            .html(language);

                        if (
                            settings.get == "selected" &&
                            locale == languageCode
                        ) {
                            option.attr({
                                disabled: "disabled"
                            });
                        } else if (
                            settings.get == "all" &&
                            $.inArray(languageCode, selected) != -1
                        ) {
                            option.attr({
                                disabled: "disabled"
                            });
                        }
                        option.appendTo($(this));
                    });

                    $(this)
                        .val(
                            $(this).attr("data-select-value")
                                ? $(this)
                                      .attr("data-select-value")
                                      .split(",")
                                : 0
                        )
                        .trigger("change")
                        .removeAttr("required")
                        .select2({
                            templateResult: item => {
                                if (!item.id) {
                                    return item.text;
                                }

                                var img = $("<img>", {
                                    class: "img-flag",
                                    width: 26,
                                    src: $(item.element).attr("flag")
                                });
                                var span = $("<span>", {
                                    text: " " + item.text
                                });
                                span.prepend(img);
                                return span;
                            }
                        })
                        .on("select2:select", function(e) {
                            $("#selected-flag").html(
                                '<i class="flag ' + e.params.data.id + '">'
                            );
                            $('[name="lang_tl_key"]').val(e.params.data.text);
                            $(this)
                                .removeClass("has-error")
                                .parent()
                                .find(".invalid-feedback")
                                .remove();
                            $(this)
                                .parent()
                                .find(".select2-selection")
                                .removeClass("has-error")
                                .addClass("has-success");
                        });
                }
            },
            setLocale = locale => {
                var toObject = [];
                var form = $("form");
                form.length &&
                    form.each(function() {
                        var fields = $(this)
                            .serializeArray()
                            .reduce(function(obj, item) {
                                obj[item.name] = item.value;
                                return obj;
                            }, {});

                        toObject.push({
                            form: {
                                id: $(this).attr("id"),
                                class: $(this).attr("class"),
                                fields: fields
                            }
                        });
                    });

                $.post(location.origin + "/language/set/" + locale, {
                    forms: JSON.stringify(toObject)
                }).done(response => {
                    if (response.success) {
                        location.assign(response.redirect);
                    }
                });
            };
    };

    $("#target_nav_language").localeLanguages({
        view : "dropdown",
        url : location.origin+"/language/lang",
    });
})(jQuery);
