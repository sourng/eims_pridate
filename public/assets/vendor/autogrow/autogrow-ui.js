(function($) {
    $.fn.autogrow = function(o) {
        var defaults = {
                height: $(this).data("height") ? $(this).data("height") : 44,
                maxHeight: 190,
                overflowY: "scroll",
                overflowX: "hidden",
                resize: "none"
            },
            settings = $.extend({}, defaults, o);

        return this.each(function() {
            var textarea = this;
            $.fn.autogrow.resize(textarea, settings);
            $(textarea)
                .addClass("scrollbar")
                .css({
                    height: settings.height,
                    maxHeight: settings.maxHeight,
                    overflowY: settings.overflowY,
                    overflowX: settings.overflowX,
                    resize: settings.resize
                })
                .on("focus change",function() {
                    textarea.interval = setInterval(function() {
                        $.fn.autogrow.resize(textarea, settings);
                    }, 500);
                })
                .blur(function() {
                    clearInterval(textarea.interval);
                });
        });
    };
    $.fn.autogrow.resize = function(textarea, settings) {
        var lineHeight = parseInt($(textarea).css("line-height"), 10);
        var lines = textarea.value.split("\n");
        if (lines.length > 1) {
            var height = lineHeight * (lines.length + 1);
            $(textarea).css("height", height);
        }
    };
})(jQuery);
