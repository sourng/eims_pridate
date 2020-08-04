<style>
    .pictures {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .pictures>li {
        border: 1px solid transparent;
        float: left;
        height: 200px;
        margin: 0 -1px -1px 0;
        overflow: hidden;
        width: 200px;
    }
    @media (max-width: 576px) {
        .pictures>li {

            height: 100px;
            width: 100px;
        }
    }
    .pictures>li>img {
        cursor: zoom-in;
        width: 100%;
    }
    .viewer-download {
      color: #fff;
      font-family: "Font Awesome 5 Pro", serif;
      font-size: 0.75rem;
      line-height: 1.5rem;
      text-align: center;
    }
    .viewer-download::before {
      content: "\f019";
    }
</style>
<div class="card-body">
    <div id="gallery" data-toggle="gallery">
        <ul class="pictures">
            @if ($response["success"])
                @foreach ($response["data"] as $row)
                <li>
                    <img data-original="{{$row["image"]}}?type=original" data-src="{{$row["image"]}}?type=large"
                        data-alt="{{$row["title"]}}">
                </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
