(function (factory) {
    if (typeof define === 'function' && define.amd) {
      define(['jquery'], factory);
    } else if (typeof module === 'object' && typeof module.exports === 'object') {
      factory(require('jquery'));
    } else {
      factory(jQuery);
    }
  }(function (jQuery) {
    // English (Template)
    jQuery.timeago.settings.strings = {
      prefixAgo: null,
      prefixFromNow: null,
      suffixAgo: "មុន",
      suffixFromNow: "ចាប់ពីពេលនេះ",
      seconds: "តិចជាង ១ នាទី",
      minute: "១ នាទី",
      minutes: "%d នាទី",
      hour: "១ ម៉ោង",
      hours: "%d ម៉ោង",
      day: "១ ថ្ងៃ",
      days: "%d ថ្ងៃ",
      month: "១ ខែ",
      months: "%d ខែ",
      year: "១ ឆ្នាំ",
      years: "%d ឆ្នាំ",
      wordSeparator: " ",
      numbers: ['០','១','២','៣','៤','៥','៦','៧','៨','៩']
    };
  }));
