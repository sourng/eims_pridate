<div class="container my-3">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <!--mail inbox start-->
                <div class="mail-box">
                    @include('Mailbox.includes.navLeft')
                    <aside class="lg-side">
                        <div class="inbox-head">
                            <h3 class="text-white"> {{Translator::phrase(config("pages.parameters.param1"))}}</h3>
                            <form class="pull-right position" action="#">
                                <div class="input-append">
                                    <input type="text" placeholder="Search Mail" class="sr-input">
                                    <button type="button" class="btn sr-btn" data-original-title="" title=""><i
                                            class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="inbox-body">
                            @if($response["success"])
                            @foreach ($response["data"] as $row)
                            <div class="sender-info">
                                <div class="row">
                                    <div class="col-md-8">
                                        <img alt="" data-src="{{$row["user"]["profile"]}}">
                                        <strong>{{$row["user"]["name"]}}</strong>
                                        <span>[{{$row["user"]["email"]}}]</span>

                                        {{-- {{Translator::phrase("to")}}
                                        <strong>{{Translator::phrase("me")}}</strong>
                                        <a class="sender-dropdown " href="javascript:;">
                                            <i class="fa fa-chevron-down"></i>
                                        </a> --}}
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <small class="date" datetime="{{$row["created_at"]}}"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="heading-inbox row">
                                <div class="col-md-12">
                                    <h4>{{$row["subject"]}}</h4>
                                </div>
                            </div>

                            <div class="view-mail ql-editor ql-snow">
                                {!!$row["message"]!!}
                            </div>
                            <div class="attachment-mail">
                                <div id="gallery" data-toggle="gallery">
                                    @if ($row["attachment_images"])
                                    <p>
                                        <span><i class="fa fa-paperclip"></i> {{count($row["attachment_images"])}} —
                                        </span>
                                        <a href="#">Download all attachments</a>
                                    </p>
                                    <ul>
                                        @foreach ($row["attachment_images"] as $image)
                                        <li>
                                            <a class="atch-thumb">
                                                <img class="img-responsive" data-original="{{$image}}"
                                                    data-src="{{$image}}">
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif


                            </div>
                            <div class="py-3">
                                <a class="btn btn-sm btn-primary" data-toggle="collapse" href="#collapseFormReply">
                                    <i class="fa fa-reply"></i>
                                    {{Translator::phrase("reply")}}
                                </a>
                                <button class="btn btn-sm " data-original-title="" title=""><i
                                        class="fa fa-arrow-right"></i> {{Translator::phrase("forward")}}</button>
                                <button title="" data-placement="top" data-toggle="tooltip" type="button"
                                    data-original-title="{{Translator::phrase("print")}}"
                                    class="btn  btn-sm tooltips"><i class="fa fa-print"></i>
                                </button>
                                @if (config("pages.parameters.param1") != "trash")
                                <button title="" data-placement="top" data-toggle="tooltip"
                                    data-original-title="{{Translator::phrase("move_trash")}}"
                                    class="btn btn-sm tooltips"><i class="fas fa-trash"></i></button>
                                @endif

                            </div>
                            <div class="collapse" id="collapseFormReply">
                                <form role="{{config("pages.form.role")}}" class="needs-validation" novalidate=""
                                    method="POST"
                                    action="{{str_replace("add","reply",config("pages.form.action.add"))}}"
                                    data-toggle="mailbox-reply" enctype="multipart/form-data"
                                    data-validation="{{json_encode(config('pages.form.validate'))}}">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-row">
                                                <input type="hidden" name="mailbox_id" value="{{$row["id"]}}">
                                                <input type="hidden" name="recipient[]" value="{{$row["user"]["id"]}}">
                                                <input type="hidden" name="subject" value="{{$row["subject"]}}">
                                                <div class="col-md-12">
                                                    <label class="form-control-label d-none" for="message">
                                                        {{ Translator:: phrase('message') }}
                                                        @if(config("pages.form.validate.rules.message")) <span
                                                            class="badge badge-md badge-circle badge-floating badge-danger"
                                                            style="background:unset"><i
                                                                class="fas fa-asterisk fa-xs"></i></span>
                                                        @endif

                                                    </label>
                                                    <div>
                                                        <div data-name="message" id="message"
                                                            data-placeholder="{{ Translator::phrase("message") }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <a href="" name="scrollTo"></a>
                                            <button class="btn btn-primary ml-auto float-right" type="submit">
                                                {{ Translator:: phrase("send_message") }}

                                            </button>
                                        </div>
                                    </div>


                                </form>
                            </div>
                            @endforeach
                            @endif

                        </div>
                    </aside>
                </div>
                <!--mail inbox end-->
            </div>
        </div>
    </div>
</div>
