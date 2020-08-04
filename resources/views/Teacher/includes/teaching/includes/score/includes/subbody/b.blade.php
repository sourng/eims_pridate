<tbody class="list">
    @if ($response["success"])
    @include(config("pages.parent").".includes.teaching.includes.score.includes.subbody.c")
    @else
    <tr class="empty text-center">
        <td colspan="{{count($response['study_subject'])+ 4 }}" scope="rowgroup">
            <p class="m-0">
                <svg width="64" height="41" viewBox="0 0 64 41" xmlns="http://www.w3.org/2000/svg">
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
            <div>
                <span class="text-pre-wrap">{{ $response["message"] }}</span>
            </div>
            <div>
                <a href="#filter" data-toggle="collapse" class="btn btn-sm mb-3" role="button" aria-expanded="false">
                    <i class="fa fa-filter m-0"></i>
                    <span class="d-none d-sm-inline">
                        {{Translator::phrase("filter")}}
                    </span>
                </a>
            </div>
        </td>
    </tr>
    @endif
</tbody>
