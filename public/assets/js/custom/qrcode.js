function Qrcode(options) {
    var self = this,
        defaults = {
            container: $("#stage"),
            form: $("form"),
            data: []
        },
        settings = $.extend(true, defaults, options);

    var qrcode = {
        stage: null,
        layer: new Konva.Layer(),
        group: new Konva.Group({ draggable: true }),
        photo: new Image(),
        qrcode: new Image(),
        data: settings.data,
        attributes: settings.data
    };
    var data = {};
    self.getAttributes = function() {
        return qrcode.attributes;
    };
    self.make = function() {
        qrcode.stage = new Konva.Stage({
            container: "stage",
            width: 400,
            height: 400
        });
        qrcode.layer.add(qrcode.group);
        qrcode.stage.add(qrcode.layer);

        $.each(qrcode.data, (id, t) => {
            if (data[id] == null) {
                data[id] = t;
            }
            var obj = null,
                x = qrcode.stage.width() / 2 - 100 / 2,
                y = qrcode.stage.height() / 2 - 100 / 2,
                fontFamily = "NiDAKhmerEmpire",
                fontStyle = "normal",
                visible = false,
                draggable = false;
            if (id == "photo") {
                x = qrcode.stage.width() / 2 - 75 / 2;
                y = qrcode.stage.height() / 2 - 80 / 2;
                visible = false;
            } else if (id == "qrcode") {
                x = qrcode.stage.width() / 2 - 100 / 2;
                y = qrcode.stage.height() / 2 - 100 / 2;
                visible = true;
            }
            if (id == "photo" || id == "qrcode") {
                qrcode[id].onload = function() {
                    obj = new Konva.Image({
                        x: x,
                        y: y,
                        image: qrcode[id],
                        width: id == "photo" ? 75 : 100,
                        height: id == "photo" ? 80 : 100,
                        name: "ob",
                        id: id,
                        visible: visible,
                        draggable: draggable
                    });
                    qrcode.group.add(obj);
                    qrcode.layer.batchDraw();
                };
                qrcode[id].src =
                    id == "photo"
                        ? t
                        : "https://api.qrserver.com/v1/create-qr-code/?data=1&size=500x500";
            } else {
                obj = new Konva.Text({
                    x: x,
                    y: y,
                    text: "object" == typeof t ? t.name : t,
                    name: "ob",
                    id: id,
                    visible: visible,
                    draggable: draggable
                }).on("transform", function() {
                    qrcode.attributes[id] = JSON.parse(this.toJSON());
                });
                qrcode.layer.add(obj);
            }
            qrcode.attributes[id] = {};
        });

        event();
        // this.resize();
    };

    self.resize = function() {
        fitStageIntoParentContainer();
        $(window).on("resize", fitStageIntoParentContainer);
    };

    function fitStageIntoParentContainer() {
        var scale = settings.container.parent().width() / qrcode.stage.width();
        qrcode.stage.width(qrcode.stage.width() * scale);
        qrcode.stage.height(qrcode.stage.height() * scale);
        qrcode.stage.scale({ x: scale, y: scale });
        qrcode.stage.draw();
        $('[data-toggle="qrcode-image"]').height(
            settings.container.outerHeight()
        );
    }

    function event() {
        var e = settings.form.find(".input-slider");
        e.length &&
            e.each(function() {
                this.noUiSlider.on("update", function(e, a) {
                    if ($(this.target).attr("data-toggle") == "qrcode-code") {
                        var size = parseInt(e[a]);
                        $(this.target)
                            .parent()
                            .find("#input-slider-value")
                            .html(
                                '<input type="hidden" value="' +
                                    size +
                                    '" name="qrcode[code]">' +
                                    size
                            );
                        if (typeof qrcode !== "undefined") {
                            qrcode.stage
                                .find("#qrcode")
                                .width(size)
                                .height(size)
                                .position({
                                    x: qrcode.stage.width() / 2 - size / 2,
                                    y: qrcode.stage.height() / 2 - size / 2
                                });
                            qrcode.attributes["qrcode"] = qrcode.stage.find(
                                "#qrcode"
                            )[0];
                            qrcode.layer.draw();
                        }
                    } else if (
                        $(this.target).attr("data-toggle") == "qrcode-image"
                    ) {
                        var size = parseInt(e[a]);
                        $(this.target)
                            .parent()
                            .find("#input-slider-value")
                            .html(
                                '<input type="hidden" value="' +
                                    size +
                                    '" name="qrcode[image]">' +
                                    size
                            );
                        if (typeof qrcode !== "undefined") {
                            qrcode.stage
                                .find("#photo")
                                .width(size > 10 ? size - 5 : size)
                                .height(size)
                                .position({
                                    x:
                                        qrcode.stage.width() / 2 -
                                        (size > 10 ? size - 5 : size) / 2,
                                    y: qrcode.stage.height() / 2 - size / 2
                                });
                            qrcode.stage.find("#qrcode").setZIndex(0);
                            if (size == 0) {
                                qrcode.stage.find("#photo").hide();
                            } else {
                                qrcode.stage.find("#photo").show();
                            }
                            qrcode.attributes["photo"] = qrcode.stage.find(
                                "#photo"
                            )[0];
                            qrcode.layer.draw();
                        }
                    }
                });
            });

        settings.form.unbind("submit").on("submit", e => {
            e.preventDefault();
            var url = settings.form.attr("action"),
                formData = new FormData(e.target);
            var c = self.getAttributes();
            formData.append("qrcode[attributes]", JSON.stringify(c));
            ajax(url, formData);
        });
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
                    var container = $("<div>"),
                        containerImage = $("<div>")
                            .addClass("row")
                            .appendTo(container);

                    if (response.data) {
                        var allImage = response.data,
                            setClass = "col-md-6";

                        switch (allImage.length) {
                            case 1:
                                setClass = "col-md-12";
                                break;
                            case 2:
                                setClass = "col-md-6";
                                break;
                            case 3:
                                setClass = "col-md-4";
                                break;
                            case 4:
                                setClass = "col-md-3";
                                break;
                            default:
                                setClass = "col-md-3";
                                break;
                        }

                        $.each(allImage, function(i, img) {
                            var colImage = $("<div>")
                                    .addClass(setClass + " p-1")
                                    .appendTo(containerImage),
                                image = $("<img>")
                                    .attr({
                                        src: img
                                    })
                                    .appendTo(colImage);
                        });
                    }

                    swal({
                        title: response.message.title,
                        type: "success",
                        html: container,
                        confirmButtonText: response.message.button.confirm
                    });
                }
            },
            error: (xhr, type, error) => {}
        });
    }
}

$.fn.extend({
    QrcodeReader: function(qrcodeSuccess, qrcodeError, videoError,localStream) {
        return this.each(function() {
            var currentElem = $(this),
                height = currentElem.height(),
                width = currentElem.width();
            null == height && (height = 250), null == width && (width = 300);
            var localMediaStream,
                vidElem = $(
                    '<video width="' +
                        width +
                        'px" height="' +
                        height +
                        'px"></video>'
                ).appendTo(currentElem),
                canvasElem = $(
                    '<canvas id="qr-canvas" width="' +
                        (width - 2) +
                        'px" height="' +
                        (height - 2) +
                        'px" style="display:none;"></canvas>'
                ).appendTo(currentElem),
                video = vidElem[0],
                canvas = canvasElem[0],
                context = canvas.getContext("2d"),
                scan = function() {
                    if (localMediaStream) {
                        localStream(localMediaStream);
                        context.drawImage(video, 0, 0, 307, 250);
                        try {
                            qrcode.decode();
                        } catch (e) {
                            qrcodeError(e, localMediaStream);
                        }
                        $.data(
                            currentElem[0],
                            "timeout",
                            setTimeout(scan, 500)
                        );
                    } else
                        $.data(
                            currentElem[0],
                            "timeout",
                            setTimeout(scan, 500)
                        );
                };
            (window.URL =
                window.URL ||
                window.webkitURL ||
                window.mozURL ||
                window.msURL),
                (navigator.getUserMedia =
                    navigator.getUserMedia ||
                    navigator.webkitGetUserMedia ||
                    navigator.mozGetUserMedia ||
                    navigator.msGetUserMedia);
            var successCallback = function(stream) {
                (video.srcObject = stream),
                    (localMediaStream = stream),
                    $.data(currentElem[0], "stream", stream),
                    video.play(),
                    $.data(currentElem[0], "timeout", setTimeout(scan, 1e3));
            };
            navigator.getUserMedia
                ? navigator.getUserMedia(
                      { video: !0 },
                      successCallback,
                      function(error) {
                          videoError(error, localMediaStream);
                      }
                  )
                : videoError(
                      "Native web camera streaming (getUserMedia) not supported in this browser."
                  ),
                (qrcode.callback = function(result) {
                    qrcodeSuccess(result, localMediaStream);
                });
        });
    },
    QrcodeReaderInput: function(node, qrcodeSuccess) {
        return this.each(function() {
            reader = new FileReader();
            reader.onload = function() {
                qrcode.callback = function(result) {
                    if (result instanceof Error) {
                        console.log(
                            "No QR code found. Please make sure the QR code is within the camera's frame and try again."
                        );
                    } else {
                        qrcodeSuccess(result);
                    }
                };
                qrcode.decode(reader.result);
            };
            reader.readAsDataURL(node.files[0]);
        });
    },
    QrcodeReaderStop: function() {
        return this.each(function() {
            $(this)
                .data("stream")
                .getVideoTracks()
                .forEach(function(videoTrack) {
                    videoTrack.stop();
                }),
                clearTimeout($(this).data("timeout"));
        });
    }
});
