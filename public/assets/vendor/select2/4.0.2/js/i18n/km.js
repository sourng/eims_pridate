/*! Select2 4.0.2 | https://github.com/select2/select2/blob/master/LICENSE.md */

(function() {
    if (jQuery && jQuery.fn && jQuery.fn.select2 && jQuery.fn.select2.amd)
        var e = jQuery.fn.select2.amd;
    return (
        e.define("select2/i18n/km", [], function() {
            return {
                errorLoading: function() {
                    return "លទ្ធផលមិនអាចផ្ទុកបានទេ។";
                },
                inputTooLong: function(e) {
                    var t = e.input.length - e.maximum,
                        n = "សូមលុបចោល " + t + " តួអក្សរ";
                    return t != 1 && (n += "s"), n;
                },
                inputTooShort: function(e) {
                    var t = e.minimum - e.input.length,
                        n = "សូមបញ្ចូល " + t + " ឬតួអក្សរច្រើនទៀត";
                    return n;
                },
                loadingMore: function() {
                    return "កំពុងផ្ទុកលទ្ធផលច្រើនទៀត…";
                },
                maximumSelected: function(e) {
                    var t = "អ្នកអាចជ្រើសរើសបាន " + e.maximum + " ធាតុ";
                    return e.maximum != 1 && (t += "s"), t;
                },
                noResults: function() {
                    return "រកមិនឃើញលទ្ធផល";
                },
                searching: function() {
                    return "កំពុងស្វែងរក…";
                },
                removeAllItems: function() {
                    return "យករបស់ទាំងអស់ចេញ";
                }
            };
        }),
        { define: e.define, require: e.require }
    );
})();
