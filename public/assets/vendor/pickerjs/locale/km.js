(function(global, factory) {
    typeof exports === "object" && typeof module !== "undefined"
        ? (module.exports = factory())
        : typeof define === "function" && define.amd
        ? define(factory)
        : factory(global.Picker);
})(typeof self !== "undefined" ? self : this, function(Picker) {
    "use strict";
    Picker.languages["km"] = {
        months: [
            "មករា",
            "កុម្ភះ",
            "មិនា",
            "មេសា",
            "ឧសភា",
            "មិថុនា",
            "កក្កដា",
            "សីហា",
            "កញ្ញា",
            "តុលា",
            "វិច្ឆិកា",
            "ធ្នូ"
        ],
        monthsShort: [
            "មករា",
            "កុម្ភះ",
            "មិនា",
            "មេសា",
            "ឧសភា",
            "មិថុនា",
            "កក្កដា",
            "សីហា",
            "កញ្ញា",
            "តុលា",
            "វិច្ឆិកា",
            "ធ្នូ"
        ],
        text: {
            title: "ជ្រើសរើសពេលវេលា",
            cancel: "បោះបង់",
            confirm: "យល់ព្រម",
            year: "ឆ្នាំ",
            month: "ខែ",
            day: "ថ្ងៃ",
            hour: "ម៉ោង",
            minute: "នាទី",
            second: "វិនាទី",
            millisecond: "មីលីវិនាទី"
        }
    };
});
