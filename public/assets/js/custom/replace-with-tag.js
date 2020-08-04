(function($) {
    $.fn.replaceWithTag = function(tagName) {
        var result = [];
        this.each(function() {
            var newElem = $("<" + tagName + ">").get(0);
            for (var i = 0; i < this.attributes.length; i++) {
                newElem.setAttribute(
                    this.attributes[i].name,
                    this.attributes[i].value
                );
            }
            newElem = $(this)
                .wrapInner(newElem)
                .children(0)
                .unwrap()
                .get(0);
            result.push(newElem);
        });
        return $(result);
    };

    $.fn.convertFormTag = function(o) {
        var d = {
                dataNameTag: { id: null, name: null, email: null, phone: null },
                toTagname: "span"
            },
            s = $.extend(d, o);

        this.set = opt => {
            s = $.extend(d, opt);
        };
        s.id = null;
        this.convert = () => {
            $.each(Object.keys(s.dataNameTag), (i, key) => {
                if ($(this).find('[name="' + key + '"]').length) {
                    if (
                        $(this)
                            .find('[name="' + key + '"]')
                            .get(0).tagName == "INPUT"
                    ) {
                        if (
                            $(this)
                                .find('[name="' + key + '"]')
                                .attr("type") == "file"
                        ) {
                            var dz = $(this)
                                    .find('[name="' + key + '"]')
                                    .parent()
                                    .parent()
                                    .parent(),
                                image = dz.attr("data-dropzone-url");
                            dz.find(".dz-preview").css({
                                position: "relative",
                                padding: "5rem 1rem"
                            });
                            dz.find(".dz-message").hide();
                        } else {
                            var newData = $(this)
                                .find('[name="' + key + '"]')
                                .val();
                            $(this)
                                .find('[name="' + key + '"]')
                                .replaceWithTag(s.toTagname)
                                .html(newData);
                        }
                    } else if (
                        $(this)
                            .find('[name="' + key + '"]')
                            .get(0).tagName == "SELECT"
                    ) {
                        var id = $(this)
                                .find('[name="' + key + '"]')
                                .val(),
                            newData = $(this)
                                .find('[name="' + key + '"]')
                                .find('[value="' + id + '"]')
                                .text();

                        $(this)
                            .find('[name="' + key + '"]')
                            .removeClass("select2-hidden-accessible")
                            .replaceWithTag(s.toTagname)
                            .html(newData)
                            .removeAttr("data-toggle")
                            .nextAll().remove();


                    } else if (
                        $(this)
                            .find('[name="' + key + '"]')
                            .get(0).tagName == "TEXTAREA"
                    ) {
                        $(this)
                            .find('[name="' + key + '"]')
                            .replaceWithTag(s.toTagname);
                    }
                }
            });
        };
        this.convert();
    };
})(jQuery);
