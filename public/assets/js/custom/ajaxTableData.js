function AjaxTableData($table) {
    this.element = $table;
}
AjaxTableData.prototype = {
    getThead: function () {
        var th = [];
        this.element.find('thead th[data-type]').each((i, el) => {
            if ($(el).data("type")) {
                th.push({
                    element: $(el),
                    type: $(el).data("type"),
                    key: $(el).data("key"),
                    join: $(el).data("join") ? $(el).data("join") : "",//&#9866;
                    link: $(el).data("url"),
                });
            }

        });
        return th;
    },
    buildTr: function (OneData) {
        var tr = '<tr data-id="' + OneData.id + '">';
        $.map(this.getThead(), (th) => {
            if (th.type == "checkbox") {
                tr += this.buildTd(th.type, OneData.id);
            } else if (th.type == "table_quiz_question") {
                tr += this.buildTd(th.type, {
                    question: OneData.question,
                    answer: OneData.answer
                });
            } else if (th.type == "table_quiz_student") {
                tr += this.buildTd(th.type, {
                    answer: OneData.quiz_answered
                });
            } else {
                if (th.key) {
                    var allKey = th.key.split(",");
                    var values = "";
                    if (allKey.length == 1) {
                        $.each(allKey, (i, key) => {
                            var arr_value = null;
                            key = th.key.split(".");
                            if (key.length == 1) {
                                tr += this.buildTd(th.type, OneData[key[0]]);
                            } else {
                                $.each(key, (ix, k) => {
                                    if (arr_value) {
                                        arr_value = arr_value[k];
                                    } else {
                                        arr_value = OneData[k];
                                    }
                                });

                                tr += this.buildTd(th.type, arr_value);
                            }
                        });

                    } else {

                        $.each(allKey, (i, key) => {

                            var arr_value = null;
                            key = key.split(".");

                            if (key.length == 1) {
                                values += OneData[key[0]] + " " + th.join + " ";

                            } else {
                                $.each(key, (ix, k) => {
                                    if (arr_value) {
                                        arr_value = arr_value[k];
                                    } else {
                                        arr_value = OneData[k];
                                    }
                                });
                                values += arr_value + " " + th.join + " ";
                            }
                        });
                        var lastword = values.lastIndexOf(th.join);
                        values = values.substring(0, lastword);

                        tr += this.buildTd(th.type, values);
                    }
                }
            }
        });
        tr += '</tr>';
        this.hideEmptyTr();
        return tr;
    },
    buildTd: function (t, d) {
        var checkedControls = this.element.find('[data-toggle="table-checked"]').data("checked-show-controls");
        var td = "";
        if (t == "checkbox") {
            td += '<td>';
            td += '<div class="custom-control custom-checkbox">';
            td += '<input class="custom-control-input" data-toggle="table-checked" id="table-check-' + d + '" data-checked-show-controls=\'' + JSON.stringify(checkedControls) + '\' type="checkbox" data-checked="table-checked" value="' + d + '">';
            td += '<label class="custom-control-label" for="table-check-' + d + '"></label>';
            td += '</div>';
            td += '</td>';
        } else if (t == "image") {
            td += '<td>';
            td += '<img width="50px" height="50px" data-src="' + d + '">';
            td += '</td>';
        } else if (t == "text") {
            td += '<td>';
            td += d;
            td += '</td>';
        } else if (t == "table_quiz_question") {
            if ($(".template-table-quiz-question").length) {
                var template = $(".template-table-quiz-question").clone();

                var ntr = '<tr>';
                ntr += '<td class="text-center m-auto align-middle" rowspan="' + ((d.answer).length + 1) + '">';
                ntr += d.question;
                ntr += '</td>';
                ntr += '</tr>';

                $.each(d.answer, (i, v) => {
                    ntr += '<tr>';
                    ntr += '<td>';
                    ntr += v.answer;
                    ntr += '</td>';

                    ntr += '<td>';
                    if (v.correct_answer) {
                        ntr += '<i class="fas fa-check"></i>';
                    }
                    ntr += '</td>';
                    ntr += '</tr>';
                });

                template.find("tbody").html(ntr);
                td += '<td>';
                td += template.html();
                td += '</td>';
            }
        }else if (t == "table_quiz_student") {
            if ($(".template-table-quiz-student").length) {
                var template = $(".template-table-quiz-student").clone();
                td += '<td>';
                td += template.html();
                td += '</td>';
            }
        }


        return td;
    },
    build: function (data) {
        $.each(data, (i, v) => {
            this.element.find(">tbody").prepend(this.buildTr(v));
        });
    },
    hideEmptyTr: function () {
        this.element.find(">tbody tr.empty").hide();
    },
    showEmptyTr: function () {
        this.element.find(">tbody tr.empty").show();
    },
};
