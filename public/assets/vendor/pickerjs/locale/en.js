(function(global, factory) {
    typeof exports === "object" && typeof module !== "undefined"
        ? (module.exports = factory())
        : typeof define === "function" && define.amd
        ? define(factory)
        : factory(global.Picker);
})(typeof self !== "undefined" ? self : this, function(Picker) {
    "use strict";

    Picker.languages["en"] = {
        months: [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ],

        monthsShort: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec"
        ],

        text: {
            title: "Pick time",
            cancel: "Cancel",
            confirm: "OK",
            year: "Year",
            month: "Month",
            day: "Day",
            hour: "Hour",
            minute: "Minute",
            second: "Second",
            millisecond: "Millisecond"
        }
    };
});
