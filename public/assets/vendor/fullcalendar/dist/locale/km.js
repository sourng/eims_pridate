!(function(e, t) {
    "object" == typeof exports && "object" == typeof module
        ? (module.exports = t(require("moment"), require("fullcalendar")))
        : "function" == typeof define && define.amd
        ? define(["moment", "fullcalendar"], t)
        : "object" == typeof exports
        ? t(require("moment"), require("fullcalendar"))
        : t(e.moment, e.FullCalendar);
})("undefined" != typeof self ? self : this, function(e, t) {
    return (function(e) {
        function t(r) {
            if (a[r]) return a[r].exports;
            var n = (a[r] = { i: r, l: !1, exports: {} });
            return e[r].call(n.exports, n, n.exports, t), (n.l = !0), n.exports;
        }
        var a = {};
        return (
            (t.m = e),
            (t.c = a),
            (t.d = function(e, a, r) {
                t.o(e, a) ||
                    Object.defineProperty(e, a, {
                        configurable: !1,
                        enumerable: !0,
                        get: r
                    });
            }),
            (t.n = function(e) {
                var a =
                    e && e.__esModule
                        ? function() {
                              return e.default;
                          }
                        : function() {
                              return e;
                          };
                return t.d(a, "a", a), a;
            }),
            (t.o = function(e, t) {
                return Object.prototype.hasOwnProperty.call(e, t);
            }),
            (t.p = ""),
            t((t.s = 107))
        );
    })({
        0: function(t, a) {
            t.exports = e;
        },
        1: function(e, a) {
            e.exports = t;
        },
        107: function(e, t, a) {
            Object.defineProperty(t, "__esModule", { value: !0 }), a(108);
            var r = a(1);
            r.datepickerLocale("km", "km", {
                closeText: "ធ្វើរួច",
                prevText: "មុន",
                nextText: "បន្ទាប់",
                currentText: "ថ្ងៃនេះ",
                allDayText: "ពេញមួយថ្ងៃ",
                monthNames: [
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
                monthNamesShort: [
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
                dayNames: [
                    "អាទិត្យ", "ចន្ទ", "អង្គារ", "ពុធ", "ព្រហស្បតិ៍", "សុក្រ", "សៅរ៍"
                ],
                dayNamesShort: [
                    "អា.ទិ", "ចន្ទ", "អ.ង", "ពុធ", "ព្រ.ហ", "សុក្រ", "សៅរ៍"
                ],
                dayNamesMin: ["អា", "ច", "អ", "ពុ", "ព្រ.ហ", "សុ", "សៅ"],
                weekHeader: "Wk",
                dateFormat: "dd/mm/yyyy",
                firstDay: 1,
                isRTL: !1,
                showMonthAfterYear: !1,
                yearSuffix: ""
            }),
                r.locale("km");
        },
        108: function(e, t, a) {
            !(function(e, t) {
                t(a(0));
            })(0, function(e) {
                return e.defineLocale('km', {
                    months: 'មករា_កុម្ភៈ_មីនា_មេសា_ឧសភា_មិថុនា_កក្កដា_សីហា_កញ្ញា_តុលា_វិច្ឆិកា_ធ្នូ'.split(
                        '_'
                    ),
                    monthsShort: 'មករា_កុម្ភៈ_មីនា_មេសា_ឧសភា_មិថុនា_កក្កដា_សីហា_កញ្ញា_តុលា_វិច្ឆិកា_ធ្នូ'.split(
                        '_'
                    ),
                    weekdays: 'អាទិត្យ_ច័ន្ទ_អង្គារ_ពុធ_ព្រហស្បតិ៍_សុក្រ_សៅរ៍'.split('_'),
                    weekdaysShort: 'អា.ទិ_ច័ន្ទ_អ.ង_ពុធ_ព្រ.ហ_សុក្រ_សៅ'.split('_'),
                    weekdaysMin: 'អា_ច_អ_ពុ_ព្រ_សុ_សៅ'.split('_'),
                    weekdaysParseExact: true,
                    longDateFormat: {
                        LT: 'HH:mm',
                        LTS: 'HH:mm:ss',
                        L: 'DD/MM/YYYY',
                        LL: 'D MMMM YYYY',
                        LLL: 'D MMMM YYYY HH:mm',
                        LLLL: 'dddd, D MMMM YYYY HH:mm'
                    },
                    meridiemParse: /ព្រឹក|ល្ងាច/,
                    isPM: function (input) {
                        return input === 'ល្ងាច';
                    },
                    meridiem: function (hour, minute, isLower) {
                        if (hour < 12) {
                            return 'ព្រឹក';
                        } else {
                            return 'ល្ងាច';
                        }
                    },
                    calendar: {
                        sameDay: '[ថ្ងៃនេះ ម៉ោង] LT',
                        nextDay: '[ស្អែក ម៉ោង] LT',
                        nextWeek: 'dddd [ម៉ោង] LT',
                        lastDay: '[ម្សិលមិញ ម៉ោង] LT',
                        lastWeek: 'dddd [សប្តាហ៍មុន] [ម៉ោង] LT',
                        sameElse: 'L'
                    },
                    relativeTime: {
                        future: '%sទៀត',
                        past: '%sមុន',
                        s: 'ប៉ុន្មានវិនាទី',
                        ss: '%d វិនាទី',
                        m: 'មួយនាទី',
                        mm: '%d នាទី',
                        h: 'មួយម៉ោង',
                        hh: '%d ម៉ោង',
                        d: 'មួយថ្ងៃ',
                        dd: '%d ថ្ងៃ',
                        M: 'មួយខែ',
                        MM: '%d ខែ',
                        y: 'មួយឆ្នាំ',
                        yy: '%d ឆ្នាំ'
                    },
                    dayOfMonthOrdinalParse : /ទី\d{1,2}/,
                    ordinal : 'ទី%d',
                    week: {
                        dow: 1, // Monday is the first day of the week.
                        doy: 4 // The week that contains Jan 4th is the first week of the year.
                    }
                });
            });
        }
    });
});
