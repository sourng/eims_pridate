function Certificate(options) {
    var self = this,
        defaults = {
            container: $("#stage"),
            form: $("form"),
            layout: "vertical", // vertical and horizontal
            container_width: 1000,
            container_height: 700,
            max_width: 150,
            max_height: 14,
            font_size: 14,
            text_color: "#23499E",
            frame_front: "../../img/certificate/front.png",
            frame_background: "../../img/certificate/background.png",
            data: {
                photo: "../../img/user/male.jpg",
                qrcode: null,
                id: "០០១",
                fullname: "សែម គឹមសាន",
                _fullname: "SEM KEAMSAN",
                program: "បរិញ្ញាបត្រ",
                _program: "Bachelor Degress",
                course: "ព័ត៌មានវិទ្យាសាស្រ្តកំព្យទ័រ",
                _course: "Information Technology",
                dob: '16-តុលា-1998',
                _dob: '16-October-1998',
            }
        },
        settings = $.extend(true, defaults, options);

    self.set = function(opts) {
        settings = $.extend(true, settings, opts);
    };
    var certificate = {
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
        certificate.data = self.getData();
        certificate.layout = settings.layout;
        certificate.frameFrontImage.src = settings.frame_front;
        certificate.frameFrontImage.src = settings.frame_background;
        certificate.stage.destroy();
        make();
    };

    self.make = function() {
        make();
    };
    function make() {
        if (settings.layout == "horizontal") {
            self.set({
                container_width: 700,
                container_height: 1000
            });
        } else if (settings.layout == "vertical") {
            self.set({
                container_width: 1000,
                container_height: 700
            });
        }

        settings.container.css({
            width: settings.container_width
        });

        certificate.stage = new Konva.Stage({
            container: settings.container.attr("id"),
            width: settings.container_width,
            height: settings.container_height
        });
        certificate.stage.add(certificate.background);
        certificate.stage.add(certificate.layer);
        certificate.background.setZIndex(0);
        certificate.layer.setZIndex(1);

        certificate.frameFrontImage = new Image();
        certificate.frameFrontImage.onload = function() {
            certificate.frameFront = new Konva.Image({
                x: 0,
                y: 0,
                image: certificate.frameFrontImage,
                width: settings.layout == "vertical" ? 1000 : 700,
                height: settings.layout == "vertical" ? 700 : 1000
            });
            certificate.background.add(certificate.frameFront);
            certificate.background.batchDraw();
        };
        certificate.frameFrontImage.src = settings.frame_front;

        certificate.frameBackImage = new Image();
        certificate.frameBackImage.onload = function() {
            certificate.frameBack = new Konva.Image({
                x: settings.layout == "vertical" ? 252 : 352,
                y: 0,
                image: certificate.frameBackImage,
                width: settings.layout == "vertical" ? 1000 : 700,
                height: settings.layout == "vertical" ? 700 : 1000
            });
            certificate.background.add(certificate.frameBack);
            certificate.background.batchDraw();
        };
        certificate.frameBackImage.src = settings.frame_background;
        $.each(certificate.data, (id, t) => {
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
                (x = settings.layout == "vertical" ? 213 : 180),
                    (y = settings.layout == "vertical" ? 299 : 80),
                    (fontFamily = "KhmerOSMoul"),
                    (fontStyle = "bold");
                visible = true;
            } else if (id == "_fullname") {
                x = settings.layout == "vertical" ? 635 : 180;
                y = settings.layout == "vertical" ? 302 : 102;
                (fontFamily = "KhmerOSMoul"),
                (fontStyle = "bold");
                visible = true;
            } else if (id == "program") {
                x = settings.layout == "vertical" ? 270 : 180;
                y = settings.layout == "vertical" ? 370 : 148;
                visible = true;
            } else if (id == "_program") {
                x = settings.layout == "vertical" ? 665 : 180;
                y = settings.layout == "vertical" ? 370 : 148;
                visible = true;
            } else if (id == "course") {
                x = settings.layout == "vertical" ? 196 : 180;
                y = settings.layout == "vertical" ? 391 : 148;
                visible = true;
            } else if (id == "_course") {
                x = settings.layout == "vertical" ? 575 : 180;
                y = settings.layout == "vertical" ? 393 : 148;
                visible = true;
            } else if (id == "dob") {
                x = settings.layout == "vertical" ? 210 : 180;
                y = settings.layout == "vertical" ? 324 : 148;
                visible = true;
            } else if (id == "_dob") {
                x = settings.layout == "vertical" ? 630 : 180;
                y = settings.layout == "vertical" ? 324 : 148;
                visible = true;

            } else if (id == "photo") {
                x = settings.layout == "vertical" ? 475  : 20;
                y = settings.layout == "vertical" ? 487 : 76;
                visible = true;
            }

            if (id == "photo" || id == "qrcode") {
                certificate[id].onload = function() {
                    obj = new Konva.Image({
                        x: x,
                        y: y,
                        image: certificate[id],
                        width: id == "photo" ? 75 : 90,
                        height: id == "photo" ? 85 : 90,
                        name: "ob",
                        id: id,
                        visible: visible,
                        draggable: draggable,
                        zoom: true ,
                        zoomScale: 1.01
                    }).on("transform", function() {
                        certificate.attributes[id] = JSON.parse(this.toJSON());
                    });
                    certificate.layer.add(obj);
                    certificate.layer.batchDraw();
                };

                certificate[id].src = t;
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
                    certificate.attributes[id] = JSON.parse(this.toJSON());
                });
                certificate.layer.add(obj);
            }
            certificate.attributes[id] = {};
        });
        certificate.layer.draw();
        event();
    }

    function attribute(e, x = null, y = null, operator = "-") {
        console.log(e)
        if (x) {
            if (operator == "-") {
                certificate.stage
                    .find("#" + e.target.getId())[0]
                    .x(
                        certificate.stage.find("#" + e.target.getId())[0].x() -
                            certificate.delta
                    );
            } else {
                certificate.stage
                    .find("#" + e.target.getId())[0]
                    .x(
                        certificate.stage.find("#" + e.target.getId())[0].x() +
                            certificate.delta
                    );
            }
        } else if (y) {
            if (operator == "-") {
                certificate.stage
                    .find("#" + e.target.getId())[0]
                    .y(
                        certificate.stage.find("#" + e.target.getId())[0].y() -
                            certificate.delta
                    );
            } else {
                certificate.stage
                    .find("#" + e.target.getId())[0]
                    .y(
                        certificate.stage.find("#" + e.target.getId())[0].y() +
                            certificate.delta
                    );
            }
        }
        certificate.attributes[e.target.getId()] = JSON.parse(e.target.toJSON());
        detection(e);
    }

    function event() {
        settings.form
            .find('[type="checkbox"]')
            .unbind("change")
            .on("change", function(e) {
                e.preventDefault();
                var val = $(this).val();
                ch = $(this).is(":checked");
                if (val) {
                    if (ch) {
                        certificate.layer.find("#" + val).show();
                    } else {
                        certificate.layer.find("#" + val).hide();
                    }
                    certificate.attributes[val] = JSON.parse(
                        certificate.layer.find("#" + val)[0].toJSON()
                    );

                    certificate.layer.draw();
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
                        if (getid === "front_certificate") {
                            certificate.frameFrontImage.src = e.target.result;
                        } else if (getid === "back_certificate") {
                            certificate.frameBackImage.src = e.target.result;
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
                    frame_background: certificate.settings.frame_background,
                    frame_front: certificate.settings.frame_front,
                    layout: certificate.settings.layout
                },
                attributes: self.getAttributes()
            };
            formData.append("certificate", JSON.stringify(c));
            ajax(url, formData);
        });

        $(document)
            .unbind("keydown")
            .on("keydown", e => {
                if (certificate.selected) {
                    if (e.keyCode === 37) {
                        attribute(certificate.selected, true, false, "-");
                    } else if (e.keyCode === 38) {
                        attribute(certificate.selected, false, true, "-");
                    } else if (e.keyCode === 39) {
                        attribute(certificate.selected, true, false, "+");
                    } else if (e.keyCode === 40) {
                        attribute(certificate.selected, false, true, "+");
                    }
                    e.preventDefault();
                    certificate.layer.batchDraw();
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

        certificate.stage.find(".ob").on("mouseenter", function() {
            document.body.style.cursor = "move";
        });
        certificate.stage.find(".ob").on("mouseleave", function() {
            document.body.style.cursor = "default";
        });

        certificate.stage.on("click tap dragmove", e => {
            if (e.target === certificate.frameFront || e.target === certificate.frameBack) {
                certificate.stage.find("Transformer").destroy();
                certificate.layer.draw();
                return;
            }

            // do nothing if clicked NOT on our rectangles
            certificate.stage.find("Transformer").destroy();
            if (!e.target.getId()) {
                return;
            }

            e.target.moveToTop();
            certificate.layer.draw();
            certificate.selected = e;
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

            certificate.layer.add(tr);
            tr.attachTo(e.target);
            certificate.layer.draw();
        });

        certificate.layer.on("dragmove", function(e) {
            // clear all previous lines on the screen
            certificate.layer.find(".guid-line").destroy();

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

        certificate.layer.on("dragend", function(e) {
            // clear all previous lines on the screen
            certificate.layer.find(".guid-line").destroy();
            certificate.layer.batchDraw();
        });
    }
    function detection(e) {
        certificate.layer.children.each(function(t) {
            if (t === e.target) {
                return;
            }
            if (haveIntersection(t.getClientRect(), e.target.getClientRect())) {
                if (t.getClassName() == "Text") {
                    certificate.layer.find("#" + t.getId()).fill("red");
                }
            } else {
                if (t.getClassName() == "Text") {
                    certificate.layer.find("#" + t.getId()).fill(settings.text_color);
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
        var vertical = [0, certificate.stage.width() / 2, certificate.stage.width()];
        var horizontal = [0, certificate.stage.height() / 2, certificate.stage.height()];

        // and we snap over edges and center of each object on the canvas
        certificate.stage.find(".ob").forEach(guideItem => {
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
                if (diff < certificate.GUIDELINE_OFFSET) {
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
                if (diff < certificate.GUIDELINE_OFFSET) {
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
                certificate.layer.add(line);
                certificate.layer.batchDraw();
            } else if (lg.orientation === "V") {
                var line = new Konva.Line({
                    points: [lg.lineGuide, -6000, lg.lineGuide, 6000],
                    stroke: "rgb(0, 161, 255)",
                    strokeWidth: 1,
                    name: "guid-line",
                    dash: [4, 6]
                });
                certificate.layer.add(line);
                certificate.layer.batchDraw();
            }
        });
    }

    self.getAttributes = function($key = null) {
        if ($key) {
            return certificate.attributes[$key];
        }
        return certificate.attributes;
    };

    self.getJson = function(frame = true) {
        if (frame) {
            return JSON.parse(certificate.stage.toJSON());
        } else {
            return JSON.parse(certificate.layer.toJSON());
        }
    };

    self.getBase64 = function(frame = true, size = { pixelRatio: 3 }) {
        // {width : 1000 ,height : 1000}
        if (frame) {
            return certificate.stage.toDataURL(size);
        } else {
            return certificate.layer.toDataURL(size);
        }
    };

    self.getImage = function(frame = true, size = { pixelRatio: 3 }) {
        // {width : 1000 ,height : 1000}
        if (frame) {
            return downloadURI(certificate.stage.toDataURL(size), "image.png");
        } else {
            return downloadURI(certificate.layer.toDataURL(size), "image.png");
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
