function Card(options) {
    var self = this,
        defaults = {
            container: $("#stage"),
            form: $("form"),
            layout: "vertical", // vertical and horizontal
            container_width: 504,
            container_height: 350,
            max_width: 150,
            max_height: 14,
            font_size: 14,
            text_color: "#23499E",
            frame_front: "../../img/card/front.png",
            frame_background: "../../img/card/background.png",
            data: {
                photo: "../../img/user/male.jpg",
                qrcode: null,
                id: "០០១",
                fullname: "សែម គឹមសាន",
                _fullname: "SEM KEAMSAN",
                gender: "ប្រុស",
                course: "ព័ត៌មានវិទ្យាសាស្រ្តកំព្យទ័រ"
            }
        },
        settings = $.extend(true, defaults, options);

    self.set = function(opts) {
        settings = $.extend(true, settings, opts);
    };
    var card = {
        frameFrontImage: new Image(),
        frameBackImage: new Image(),
        delta: 2,
        GUIDELINE_OFFSET: 5,
        selected: false,
        frameFront: [],
        frameBack: [],
        photo: new Image(),
        qrcode: new Image(),
        settings: settings,
        stage: null,
        background: new Konva.Layer(),
        layer: new Konva.Layer(),
        data: settings.data,
        attributes: settings.data
    };
    var data = {};

    this.getData = function() {
        return data;
    };
    self.update = function() {
        card.data = self.getData();
        card.layout = settings.layout;
        card.frameFrontImage.src = settings.frame_front;
        card.frameFrontImage.src = settings.frame_background;
        card.stage.destroy();
        make();
    };

    self.make = function() {
        make();
    };
    function make() {
        if (settings.layout == "horizontal") {
            self.set({
                container_width: 700,
                container_height: 250
            });
        } else if (settings.layout == "vertical") {
            self.set({
                container_width: 500,
                container_height: 350
            });
        }

        settings.container.css({
            width: settings.container_width
        });

        card.stage = new Konva.Stage({
            container: settings.container.attr("id"),
            width: settings.container_width,
            height: settings.container_height
        });
        card.stage.add(card.background);
        card.stage.add(card.layer);
        card.background.setZIndex(0);
        card.layer.setZIndex(1);

        card.frameFrontImage = new Image();
        card.frameFrontImage.onload = function() {
            card.frameFront = new Konva.Image({
                x: 0,
                y: 0,
                image: card.frameFrontImage,
                width: settings.layout == "vertical" ? 250 : 350,
                height: settings.layout == "vertical" ? 350 : 250
            });
            card.background.add(card.frameFront);
            card.background.batchDraw();
        };
        card.frameFrontImage.src = settings.frame_front;

        card.frameBackImage = new Image();
        card.frameBackImage.onload = function() {
            card.frameBack = new Konva.Image({
                x: settings.layout == "vertical" ? 252 : 352,
                y: 0,
                image: card.frameBackImage,
                width: settings.layout == "vertical" ? 250 : 350,
                height: settings.layout == "vertical" ? 350 : 250
            });
            card.background.add(card.frameBack);
            card.background.batchDraw();
        };
        card.frameBackImage.src = settings.frame_background;
        $.each(card.data, (id, t) => {
            if (data[id] == null) {
                data[id] = t;
            }

            var obj = null,
                x = settings.container_width / 2,
                y = settings.container_height / 2,
                fontFamily = "NiDAKhmerEmpire",
                fontStyle = "normal",
                visible = false,
                draggable = true;

            if (id == "fullname") {
                (x = settings.layout == "vertical" ? 100 : 180),
                    (y = settings.layout == "vertical" ? 205 : 80),
                    (fontFamily = "KhmerOSMoul"),
                    (fontStyle = "bold");
                visible = true;
            } else if (id == "_fullname") {
                x = settings.layout == "vertical" ? 100 : 180;
                y = settings.layout == "vertical" ? 226 : 102;
                visible = true;
            } else if (id == "gender") {
                x = settings.layout == "vertical" ? 100 : 180;
                y = settings.layout == "vertical" ? 248 : 122;
                visible = true;
            } else if (id == "course") {
                x = settings.layout == "vertical" ? 100 : 180;
                y = settings.layout == "vertical" ? 272 : 148;
                visible = true;
            } else if (id == "id") {
                x = settings.layout == "vertical" ? 100 : 180;
                y = settings.layout == "vertical" ? 290 : 162;
                visible = true;
            } else if (id == "photo") {
                x = settings.layout == "vertical" ? 87  : 20;
                y = settings.layout == "vertical" ? 105 : 76;
                visible = true;
            } else if (id == "qrcode") {
                x = settings.layout == "vertical" ? 330 : 480;
                y = settings.layout == "vertical" ? 75 : 35;
                visible = true;
            }

            if (id == "photo" || id == "qrcode") {
                card[id].onload = function() {
                    obj = new Konva.Image({
                        x: x,
                        y: y,
                        image: card[id],
                        width: id == "photo" ? 75 : 90,
                        height: id == "photo" ? 85 : 90,
                        name: "ob",
                        id: id,
                        visible: visible,
                        draggable: draggable,
                        zoom: true ,
                        zoomScale: 1.01
                    }).on("transform", function() {
                        card.attributes[id] = JSON.parse(this.toJSON());
                    });
                    card.layer.add(obj);
                    card.layer.batchDraw();
                };
                if(t){
                    card[id].src = t;
                }

            } else {
                obj = new Konva.Text({
                    x: x,
                    y: y,
                    text: t,
                    fontSize: settings.font_size,
                    fontFamily: fontFamily,
                    fontStyle: fontStyle,
                    fill: settings.text_color,
                    width: settings.max_width,
                    height: settings.max_height,
                    name: "ob",
                    id: id,
                    visible: visible,
                    draggable: true
                }).on("transform", function() {
                    card.attributes[id] = JSON.parse(this.toJSON());
                });
                card.layer.add(obj);
            }
            card.attributes[id] = {};
        });
        card.layer.draw();
        event();
    }

    function attribute(e, x = null, y = null, operator = "-") {
        if (x) {
            if (operator == "-") {
                card.stage
                    .find("#" + e.target.getId())[0]
                    .x(
                        card.stage.find("#" + e.target.getId())[0].x() -
                            card.delta
                    );
            } else {
                card.stage
                    .find("#" + e.target.getId())[0]
                    .x(
                        card.stage.find("#" + e.target.getId())[0].x() +
                            card.delta
                    );
            }
        } else if (y) {
            if (operator == "-") {
                card.stage
                    .find("#" + e.target.getId())[0]
                    .y(
                        card.stage.find("#" + e.target.getId())[0].y() -
                            card.delta
                    );
            } else {
                card.stage
                    .find("#" + e.target.getId())[0]
                    .y(
                        card.stage.find("#" + e.target.getId())[0].y() +
                            card.delta
                    );
            }
        }
        card.attributes[e.target.getId()] = JSON.parse(e.target.toJSON());
        detection(e);
    }

    function event() {
        settings.form
            .find('.card-value-check')
            .unbind("change")
            .on("change", function(e) {
                e.preventDefault();
                var val = $(this).val();
                ch = $(this).is(":checked");
                if (val) {
                    if (ch) {
                        card.layer.find("#" + val).show();
                    } else {
                        card.layer.find("#" + val).hide();
                    }
                    card.attributes[val] = JSON.parse(
                        card.layer.find("#" + val)[0].toJSON()
                    );

                    card.layer.draw();
                }
            });

        settings.form
            .find('input[type="file"]')
            .unbind("input")
            .on("input", function(e) {
                var files = !!this.files ? this.files : [];
                var getid = $(this).attr("id");
                if (!files.length || !window.FileReader) return;
                if (/^image/.test(files[0].type)) {
                    var Reader = new FileReader();
                    Reader.readAsDataURL(files[0]);
                    Reader.onload = e => {
                        if (getid === "front_card") {
                            card.frameFrontImage.src = e.target.result;
                        } else if (getid === "back_card") {
                            card.frameBackImage.src = e.target.result;
                        }
                    };
                }
            });

        settings.form.unbind("submit").on("submit", e => {
            e.preventDefault();
            var url = settings.form.attr("action"),
                formData = new FormData(e.target);
            var c = {
                settings: {
                    frame_background: card.settings.frame_background,
                    frame_front: card.settings.frame_front,
                    layout: card.settings.layout
                },
                attributes: self.getAttributes()
            };
            formData.append("card", JSON.stringify(c));
            ajax(url, formData);
        });

        $(document)
            .unbind("keydown")
            .on("keydown", e => {
                if (card.selected) {
                    if (e.keyCode === 37) {
                        attribute(card.selected, true, false, "-");
                    } else if (e.keyCode === 38) {
                        attribute(card.selected, false, true, "-");
                    } else if (e.keyCode === 39) {
                        attribute(card.selected, true, false, "+");
                    } else if (e.keyCode === 40) {
                        attribute(card.selected, false, true, "+");
                    }
                    e.preventDefault();
                    card.layer.batchDraw();
                }
                return;
            });

        settings.form
            .find("#layout")
            .unbind("click")
            .on("click", e => {
                e.preventDefault();
                if (settings.layout == "horizontal") {
                    self.set({
                        layout: "vertical"
                    });
                } else if (settings.layout == "vertical") {
                    self.set({
                        layout: "horizontal"
                    });
                }
                self.update();
            });

        card.stage.find(".ob").on("mouseenter", function() {
            document.body.style.cursor = "move";
        });
        card.stage.find(".ob").on("mouseleave", function() {
            document.body.style.cursor = "default";
        });

        card.stage.on("click tap dragmove", e => {
            if (e.target === card.frameFront || e.target === card.frameBack) {
                card.stage.find("Transformer").destroy();
                card.layer.draw();
                return;
            }

            // do nothing if clicked NOT on our rectangles
            card.stage.find("Transformer").destroy();
            if (!e.target.getId()) {
                return;
            }

            e.target.moveToTop();
            card.layer.draw();
            card.selected = e;
            attribute(e);

            // remove old layouters
            // TODO: we can skip it if current rect is already selected
            // create new layouter
            var tr = new Konva.Transformer({
                enabledAnchors: [
                    "top-left",
                    "top-right",
                    "bottom-left",
                    "bottom-right"
                ],
                rotateEnabled: false,
                keepRatio: true,
                //borderStroke: "#09a3ff",
                //borderDash: [3, 3],
                boundBoxFunc: function(oldBoundBox, newBoundBox) {
                    if (Math.abs(newBoundBox.width) > settings.max_width) {
                        return oldBoundBox;
                    }
                    return newBoundBox;
                }
            });

            card.layer.add(tr);
            tr.attachTo(e.target);
            card.layer.draw();
        });

        card.layer.on("dragmove", function(e) {
            // clear all previous lines on the screen
            card.layer.find(".guid-line").destroy();

            // find possible snapping lines
            var lineGuideStops = getLineGuideStops(e.target);
            // find snapping points of current object
            var itemBounds = getObjectSnappingEdges(e.target);

            // now find where can we snap current object
            var guides = getGuides(lineGuideStops, itemBounds);

            // do nothing of no snapping
            if (!guides.length) {
                return;
            }

            drawGuides(guides);

            // now force object position
            guides.forEach(lg => {
                switch (lg.snap) {
                    case "start": {
                        switch (lg.orientation) {
                            case "V": {
                                e.target.x(lg.lineGuide + lg.offset);
                                break;
                            }
                            case "H": {
                                e.target.y(lg.lineGuide + lg.offset);
                                break;
                            }
                        }
                        break;
                    }
                    case "center": {
                        switch (lg.orientation) {
                            case "V": {
                                e.target.x(lg.lineGuide + lg.offset);
                                break;
                            }
                            case "H": {
                                e.target.y(lg.lineGuide + lg.offset);
                                break;
                            }
                        }
                        break;
                    }
                    case "end": {
                        switch (lg.orientation) {
                            case "V": {
                                e.target.x(lg.lineGuide + lg.offset);
                                break;
                            }
                            case "H": {
                                e.target.y(lg.lineGuide + lg.offset);
                                break;
                            }
                        }
                        break;
                    }
                }
            });
        });

        card.layer.on("dragend", function(e) {
            // clear all previous lines on the screen
            card.layer.find(".guid-line").destroy();
            card.layer.batchDraw();
        });
    }
    function detection(e) {
        card.layer.children.each(function(t) {
            if (t === e.target) {
                return;
            }
            if (haveIntersection(t.getClientRect(), e.target.getClientRect())) {
                if (t.getClassName() == "Text") {
                    card.layer.find("#" + t.getId()).fill("red");
                }
            } else {
                if (t.getClassName() == "Text") {
                    card.layer.find("#" + t.getId()).fill(settings.text_color);
                }
            }
        });
    }
    function haveIntersection(r1, r2) {
        return !(
            r2.x > r1.x + r1.width ||
            r2.x + r2.width < r1.x ||
            r2.y > r1.y + r1.height ||
            r2.y + r2.height < r1.y
        );
    }

    // were can we snap our objects?
    function getLineGuideStops(skipShape) {
        // we can snap to stage borders and the center of the stage
        var vertical = [0, card.stage.width() / 2, card.stage.width()];
        var horizontal = [0, card.stage.height() / 2, card.stage.height()];

        // and we snap over edges and center of each object on the canvas
        card.stage.find(".ob").forEach(guideItem => {
            if (guideItem === skipShape) {
                return;
            }
            var box = guideItem.getClientRect();
            // and we can snap to all edges of shapes
            vertical.push([box.x, box.x + box.width, box.x + box.width / 2]);
            horizontal.push([
                box.y,
                box.y + box.height,
                box.y + box.height / 2
            ]);
        });
        return {
            vertical: vertical.flat(),
            horizontal: horizontal.flat()
        };
    }

    // what points of the object will trigger to snapping?
    // it can be just center of the object
    // but we will enable all edges and center
    function getObjectSnappingEdges(node) {
        var box = node.getClientRect();
        return {
            vertical: [
                {
                    guide: Math.round(box.x),
                    offset: Math.round(node.x() - box.x),
                    snap: "start"
                },
                {
                    guide: Math.round(box.x + box.width / 2),
                    offset: Math.round(node.x() - box.x - box.width / 2),
                    snap: "center"
                },
                {
                    guide: Math.round(box.x + box.width),
                    offset: Math.round(node.x() - box.x - box.width),
                    snap: "end"
                }
            ],
            horizontal: [
                {
                    guide: Math.round(box.y),
                    offset: Math.round(node.y() - box.y),
                    snap: "start"
                },
                {
                    guide: Math.round(box.y + box.height / 2),
                    offset: Math.round(node.y() - box.y - box.height / 2),
                    snap: "center"
                },
                {
                    guide: Math.round(box.y + box.height),
                    offset: Math.round(node.y() - box.y - box.height),
                    snap: "end"
                }
            ]
        };
    }

    // find all snapping possibilities
    function getGuides(lineGuideStops, itemBounds) {
        var resultV = [];
        var resultH = [];

        lineGuideStops.vertical.forEach(lineGuide => {
            itemBounds.vertical.forEach(itemBound => {
                var diff = Math.abs(lineGuide - itemBound.guide);
                // if the distance between guild line and object snap point is close we can consider this for snapping
                if (diff < card.GUIDELINE_OFFSET) {
                    resultV.push({
                        lineGuide: lineGuide,
                        diff: diff,
                        snap: itemBound.snap,
                        offset: itemBound.offset
                    });
                }
            });
        });

        lineGuideStops.horizontal.forEach(lineGuide => {
            itemBounds.horizontal.forEach(itemBound => {
                var diff = Math.abs(lineGuide - itemBound.guide);
                if (diff < card.GUIDELINE_OFFSET) {
                    resultH.push({
                        lineGuide: lineGuide,
                        diff: diff,
                        snap: itemBound.snap,
                        offset: itemBound.offset
                    });
                }
            });
        });

        var guides = [];

        // find closest snap
        var minV = resultV.sort((a, b) => a.diff - b.diff)[0];
        var minH = resultH.sort((a, b) => a.diff - b.diff)[0];
        if (minV) {
            guides.push({
                lineGuide: minV.lineGuide,
                offset: minV.offset,
                orientation: "V",
                snap: minV.snap
            });
        }
        if (minH) {
            guides.push({
                lineGuide: minH.lineGuide,
                offset: minH.offset,
                orientation: "H",
                snap: minH.snap
            });
        }
        return guides;
    }

    function drawGuides(guides) {
        guides.forEach(lg => {
            if (lg.orientation === "H") {
                var line = new Konva.Line({
                    points: [-6000, lg.lineGuide, 6000, lg.lineGuide],
                    stroke: "rgb(0, 161, 255)",
                    strokeWidth: 1,
                    name: "guid-line",
                    dash: [4, 6]
                });
                card.layer.add(line);
                card.layer.batchDraw();
            } else if (lg.orientation === "V") {
                var line = new Konva.Line({
                    points: [lg.lineGuide, -6000, lg.lineGuide, 6000],
                    stroke: "rgb(0, 161, 255)",
                    strokeWidth: 1,
                    name: "guid-line",
                    dash: [4, 6]
                });
                card.layer.add(line);
                card.layer.batchDraw();
            }
        });
    }

    self.getAttributes = function($key = null) {
        if ($key) {
            return card.attributes[$key];
        }
        return card.attributes;
    };

    self.getJson = function(frame = true) {
        if (frame) {
            return JSON.parse(card.stage.toJSON());
        } else {
            return JSON.parse(card.layer.toJSON());
        }
    };

    self.getBase64 = function(frame = true, size = { pixelRatio: 3 }) {
        // {width : 1000 ,height : 1000}
        if (frame) {
            return card.stage.toDataURL(size);
        } else {
            return card.layer.toDataURL(size);
        }
    };

    self.getImage = function(frame = true, size = { pixelRatio: 3 }) {
        // {width : 1000 ,height : 1000}
        if (frame) {
            return downloadURI(card.stage.toDataURL(size), "image.png");
        } else {
            return downloadURI(card.layer.toDataURL(size), "image.png");
        }
    };

    function downloadURI(uri, name) {
        var link = document.createElement("a");
        link.download = name;
        link.href = uri;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        delete link;
    }

    function ajax(url, formData) {
        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: xhr => {
                var loading =
                    '<div class="loading" style="background-color: rgba(0, 0, 0, 0.4); position: absolute; height: 100%; width: 100%; z-index: 2;"><div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"><div class="spinner-border spinner-3 text-blue"></div></div></div>';
                settings.form.parent().prepend(loading);
            },
            success: response => {
                settings.form
                    .parent()
                    .find(".loading")
                    .remove();
                if (response.success) {
                    window.open(response.redirect);
                }
            },
            error: (xhr, type, error) => {}
        });
    }
}
