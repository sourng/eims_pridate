<div id="post-media" class="collapse">
    <hr class="my-2">
    <ul id="media-list" class="horizontal dragscroll clearfix">
        <li class="myupload">
            <span>
                <label for="media-upload">
                    <input type="file" id="media-upload" class="media-upload" multiple name="media"
                        data-url="{{str_replace("post","upload",config("pages.form.action.detect"))}}"
                        accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv, image/*, image/heic, image/heif">
                </label>
            </span>
        </li>
    </ul>
</div>
