<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="{{asset("/assets/vendor/plyr/dist/plyr.css")}}" />
    <style>
        body {
            margin: 0;
        }

        :root {
            --app-color: red
        }

        .plyr__control.plyr__tab-focus {
            box-shadow: 0 0 0;
        }

        .plyr--audio .plyr__control.plyr__tab-focus,
        .plyr--audio .plyr__control:hover,
        .plyr--audio .plyr__control[aria-expanded=true],
        .plyr--video .plyr__control.plyr__tab-focus,
        .plyr--video .plyr__control:hover,
        .plyr--video .plyr__control[aria-expanded=true],
        .plyr__control--overlaid,
        .plyr__control--overlaid:focus,
        .plyr__control--overlaid:hover,
        .plyr__menu__container .plyr__control[role=menuitemradio][aria-checked=true]::before {
            background: var(--app-color);
        }

        .plyr--full-ui input[type=range] {
            color: var(--app-color);
        }
        .contianer video{
            height: 100%;
        }
    </style>
</head>


<body oncontextmenu="return false" onkeydown="return false;" onmousedown="return false;">
    <div class="contianer">
        <video class="h-100" poster="" data-src="{{$response}}?payload={{csrf_token()}}" id="player">';
            <source data-src="{{$response}}" type="video/mp4" />
            <source data-src="{{$response}}" type="video/webm" />
            {{-- <track kind="captions" label="English captions" src=".vtt" srclang="en" default /> --}}
        </video>
    </div>

    <script src="{{asset("/assets/vendor/plyr/dist/plyr.js")}}"></script>
    <script>
        const video = document.querySelectorAll("#player");
            video.forEach(function(el){
                var data = el.dataset;
                    el.setAttribute("src",data.src);
                    const player = new Plyr(el,{
                        controls: ["play-large", "play", "progress", "current-time", "mute", "volume", "captions", "settings", "airplay", "fullscreen"],
                            resetOnEnd: false,
                            autoplay: false,
                            muted: false,
                        });

            });
        const contianer = document.querySelector(".contianer");

        window.addEventListener("ready",function(){
            contianer.setAttribute("style","width :"+ window.innerWidth+"px;height :"+ window.innerHeight+"px");
        });
        window.addEventListener("resize",function(){
            contianer.setAttribute("style","width :"+ window.innerWidth+"px;height :"+ window.innerHeight+"px");
        });
    </script>
</body>

</html>
