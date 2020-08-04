<aside class="sm-side sticky-top">
    <div class="p-2">
        <a href="{{str_replace("/add","compose",config("pages.form.action.add"))}}"
            class="btn d-block text-white bg-{{config("app.theme_color.name")}}" data-toggle="mailbox-modal"
            data-target="#mailbox-compose" data-backdrop="static" data-keyboard="false">
            {{Translator::phrase("compose")}}
        </a>
    </div>

    <ul class="inbox-nav inbox-divider">
        <li class="{{request()->segment(2) == "inbox" ? "active" : "" }}">
            <a data-toggle="mailbox-nav" href="{{str_replace("/add","inbox",config("pages.form.action.add"))}}">
                <i class="fas fa-inbox"></i>
                {{Translator::phrase("inbox")}}
                <span class="badge badge-danger float-right">{{$inbox_count_unread}}</span>
            </a>
        </li>

        <li class="{{request()->segment(2) == "sent" ? "active" : "" }}">
            <a data-toggle="mailbox-nav" href="{{str_replace("/add","sent",config("pages.form.action.add"))}}">
                <i class="fas fa-rocket"></i>
                {{Translator::phrase("sent")}}
            </a>
        </li>
        <li class="{{request()->segment(2) == "important" ? "active" : "" }}">
            <a data-toggle="mailbox-nav" href="{{str_replace("/add","important",config("pages.form.action.add"))}}">
                <i class="fas fa-bookmark"></i>
                {{Translator::phrase("important")}}
                <span class="badge badge-info float-right">{{$important_count}}</span>
            </a>
        </li>
        <li class="{{request()->segment(2) == "trash" ? "active" : "" }}">
            <a data-toggle="mailbox-nav" href="{{str_replace("/add","trash",config("pages.form.action.add"))}}">
                <i class="fas fa-trash"></i>
                {{Translator::phrase("Trash")}}
                <span class="badge badge-info float-right">{{$trash_count}}</span>
            </a>
        </li>
    </ul>

</aside>
