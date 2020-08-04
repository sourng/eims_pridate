<div class="container mt-3">
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
                            <div class="mail-option">
                                <div class="chk-all">
                                    <div data-type="checkbox" data-key="null" width="1">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" id="table-check-all"
                                                data-toggle="table-checked" data-checked-controls="table-checked"
                                                data-checked-show-controls='["read","important","trash"]'
                                                type="checkbox">
                                            <label class="custom-control-label" for="table-check-all"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <a href="#"
                                        data-href="{{str_replace("add","move-trash",config("pages.form.action.add"))}}"
                                        class="btn btn-danger disabled" data-toggle="sweet-alert"
                                        data-sweet-alert="confirm" sweet-alert-controls-id="" data-checked-show="trash">
                                        <i class="fas fa-trash m-0"></i>
                                        <span class="d-none d-sm-inline">
                                            {{Translator::phrase("move_trash")}}
                                        </span>
                                    </a>
                                </div>
                                @if($response["success"])
                                <ul class="unstyled inbox-pagination">
                                    <li>
                                        <span>
                                            {{$response["pages"]["from"]}}-{{$response["pages"]["to"]}} of
                                            {{$response["pages"]["total"]}}
                                        </span>
                                    </li>
                                    <li>
                                        <a href="{{$response["pages"]["prev_page_url"]}}" class="np-btn">
                                            <i class="fas fa-angle-left  pagination-left"></i></a>
                                    </li>
                                    <li>
                                        <a href="{{$response["pages"]["next_page_url"]}}" class="np-btn">
                                            <i class="fas fa-angle-right pagination-right"></i></a>
                                    </li>
                                </ul>
                                @endif
                            </div>
                            <table class="table table-inbox table-hover">
                                <tbody>
                                    @if($response["success"])
                                    @foreach ($response["data"] as $row)
                                    <tr class="">
                                        <td width="1">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" data-toggle="table-checked"
                                                    id="table-check-{{$row["id"]}}"
                                                    data-checked-show-controls='["read","important","trash"]'
                                                    type="checkbox" data-checked="table-checked" value="{{$row["id"]}}">
                                                <label class="custom-control-label"
                                                    for="table-check-{{$row["id"]}}"></label>
                                            </div>
                                        </td>

                                        <td class="view-message  dont-show">{{$row["recipient"]["name"]}}</td>
                                        <td class="view-message ">{{$row["subject"]}}</td>
                                        <td class="view-message  inbox-small-cells"><i class="fas fa-paperclip"></i>
                                        </td>
                                        <td class="view-message  text-right" datetime="{{$row["created_at"]}}"></td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="{{$row["action"]["view"]}}">
                                                        <i class="fas fa-eye"></i>
                                                        {{Translator::phrase("view")}}
                                                    </a>



                                                    <a class="dropdown-item" data-toggle="sweet-alert"
                                                        data-sweet-alert="confirm" data-sweet-id="{{$row["id"]}}"
                                                        href="{{$row["action"]["delete"]}}">
                                                        <i class="fas fa-trash-undo"></i>
                                                        {{Translator::phrase("delete_from_important")}}</a>

                                                    <div class="dropdown-divider"></div>

                                                    <a class="dropdown-item" data-toggle="sweet-alert"
                                                        data-sweet-alert="confirm" data-sweet-id="{{$row["id"]}}"
                                                        href="{{$row["action"]["move_trash"]}}">
                                                        <i class="fas fa-trash"></i>
                                                        {{Translator::phrase("move_trash")}}</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else

                                    <div class="text-center p-4">
                                        <p class="m-0">
                                            <svg width="64" height="41" viewBox="0 0 64 41"
                                                xmlns="//www.w3.org/2000/svg">
                                                <g transform="translate(0 1)" fill="none" fill-rule="evenodd">
                                                    <ellipse fill="#F5F5F5" cx="32" cy="33" rx="32" ry="7"></ellipse>
                                                    <g fill-rule="nonzero" stroke="#D9D9D9">
                                                        <path
                                                            d="M55 12.76L44.854 1.258C44.367.474 43.656 0 42.907 0H21.093c-.749 0-1.46.474-1.947 1.257L9 12.761V22h46v-9.24z">
                                                        </path>
                                                        <path
                                                            d="M41.613 15.931c0-1.605.994-2.93 2.227-2.931H55v18.137C55 33.26 53.68 35 52.05 35h-40.1C10.32 35 9 33.259 9 31.137V13h11.16c1.233 0 2.227 1.323 2.227 2.928v.022c0 1.605 1.005 2.901 2.237 2.901h14.752c1.232 0 2.237-1.308 2.237-2.913v-.007z"
                                                            fill="#FAFAFA"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                        </p>
                                        <span>{{$response["message"]}}</span>
                                    </div>

                                    @endif


                                </tbody>
                            </table>
                        </div>
                    </aside>
                </div>
                <!--mail inbox end-->
            </div>
        </div>
    </div>
</div>
