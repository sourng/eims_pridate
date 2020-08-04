@extends("layouts.master-v1")
@section("meta")
@foreach(config("app.meta") as $keys)
@for($i = 0 ; $i< count($keys);$i++) @php $meta=array();$content=array();@endphp @foreach ($keys[$i] as $name=> $item)
    @php $meta[] = $name ;@endphp
    @endforeach
    @if(count($meta) == 1)
    <meta {{$meta[0]}}="{{ $keys[$i][$meta[0]] }}" />
    @else
    <meta {{$meta[0]}}="{{ $keys[$i][$meta[0]] }}" {{$meta[1]}}="{{ $keys[$i][$meta[1]] }}" />
    @endif
    @endfor
    @endforeach
    @endsection

    @section("style")
    <link rel="stylesheet" href="{{asset("/assets/vendor/@fortawesome/fontawesome-pro/css/pro.min.css")}}"
        type="text/css">
    <link rel="stylesheet" href="{{ asset("/assets/css/paper.css") }}" />
    <link rel="stylesheet" href="{{asset("/assets/vendor/sweetalert2/dist/sweetalert2.min.css")}}">
    <style>
        [id^="stage"] {
            margin: auto 2mm;
            @if ($cards["settings"] && $cards["settings"]["layout"]=="vertical") display: inline-block;
            margin: auto 0.3mm 0.1mm;
            height: 350px;
            width: 504px;
            @endif
        }

        header {
            padding: 10px;
            color: white;
            background: var(--app-color, blueviolet);
        }
    </style>
    @endsection
    @section("content")
    <div class="paper A4 {{($cards["settings"]  && $cards["settings"]["layout"] =="vertical")? "landscape": ""}}">
        <header class="sticky">
            <h1 class="d-print-none">{{$cards["frame"]["institute"]["name"]}}</h1>

            <div class="{{$cards["success"] == false ? "d-none":""}}">
                <button class="btn-save btn d-print-none">
                    <i class="fas fa-save"></i> {{Translator::phrase("save")}}
                </button>

                <button class="btn-print btn btn-primary d-print-none">
                    <i class="fas fa-print"></i>
                    {{Translator::phrase("print")}} | (A4)
                    {{$cards["settings"]  && $cards["settings"]["layout"] =="vertical"? Translator::phrase("landscape") : Translator::phrase("portrait")}}
                </button>
            </div>
        </header>

        @if ($cards["success"] == false)
        <section class="sheet nodata">
            <div class="nodata-text">{{Translator::phrase("no_data")}}</div>
        </section>

        @endif

    </div>

    <footer>
        <div class="copyright d-print-none">
            &copy; 2019 <a href="{{config("app.website")}}" class="font-weight-bold ml-1"
                target="_blank">{{config('app.name')}}</a>
        </div>
    </footer>


    @endsection
    @section("script")
    <script src="{{ asset("/assets/vendor/konva/konva.min.js")}}"></script>
    <script src="{{asset("/assets/vendor/jquery/dist/jquery.min.js")}}"></script>
    <script src="{{asset("/assets/vendor/sweetalert2/dist/sweetalert2.min.js")}}"></script>
    <script>
       function b64toFile(dataURI) {
        const byteString = atob(dataURI.split(',')[1]);
        const mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
        const ab = new ArrayBuffer(byteString.length);
        const ia = new Uint8Array(ab);
        for (let i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }
        const blob = new Blob([ab], {
            'type': mimeString
        });
        blob['lastModifiedDate'] = (new Date()).toISOString();
        blob['name'] = 'file';
        switch (blob.type) {
            case 'image/jpeg':
                blob['name'] += '.jpg';
                break;
            case 'image/png':
                blob['name'] += '.png';
                break;
        }
        return blob;
    }
    var cardId = [];
    var cards = {!!json_encode($cards["data"]) !!};
    var j = 1;
    for (var i in cards) {
        var id = cards[i].id;
        var sheet = $("<section></section>");
        sheet.attr({
            id: id,
            class: "sheet padding-10mm"
        });
        cardId.push(id);
        var container = $("<div></div>");
        container.attr({
            id: "stage-" + id,
        });

        if (j == 1) {
            $(".paper").append(sheet);
        } else if (j == 4) {
            j = 0;
        }
        $(".paper").find("section:last").append(container);
        cards[i] = Konva.Node.create(cards[i], "stage-" + id);
        cards[i].find("Image").forEach(imageNode => {
            var nativeImage = new Image();
            nativeImage.onload = () => {
                imageNode.image(nativeImage);
                imageNode.getLayer().batchDraw();
            };
            nativeImage.src = imageNode.getAttr("source");
        });
        j++;
    }

    $(".btn-print").on("click", () => {
        window.print();
    });

    $(".btn-save").on("click", () => {
        var a = null;
        var formData = new FormData();
        formData.append("_token", $("meta[name='csrf-token']").attr('content'));
        for (var i in cards) {
            formData.append("cards[" + i + "][id]", cardId[i]);
            formData.append("cards[" + i + "][image]", b64toFile(cards[i].toDataURL({
                pixelRatio: 3
            })));
        }
        if (a) {
            a.abort();
        }

        a = $.ajax({
            url: location.href.replace("result", "save"),
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                swal({
                    title: 'Saving',
                    showCloseButton: true,
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    onOpen: () => {
                        swal.showLoading();
                    },
                    onClose: () => {
                        a.abort();
                    }
                });
            },
            success: function (response) {
                if (response.success) {
                    swal({
                        title: response.message.title,
                        text: response.message.text,
                        type: "success",
                        buttonsStyling: !1,
                        confirmButtonClass: "btn",
                        confirmButtonText: response.message.button.confirm,
                    });
                }
            }
        })

    });

    </script>
    @endsection
