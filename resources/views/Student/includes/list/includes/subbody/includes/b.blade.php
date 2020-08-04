<table class="table table-xs table-bordered">
    <tbody>
        <tr>
            <th colspan="3">{{ Translator::phrase("guardian") }}</th>

        </tr>
        <tr>
            <td>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>{{ Translator::phrase("father") }}</th>
                        </tr>
                        <tr>
                            <td>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>{{ Translator::phrase("name") }}</th>
                                            <th>{{ Translator::phrase("occupation") }}</th>
                                            <th>{{ Translator::phrase("phone") }}</th>
                                            <th>{{ Translator::phrase("email") }}</th>
                                        </tr>
                                        <tr>
                                            <td>{{$row["student_guardian"]["father"]["name"]}}</td>
                                            <td>{{$row["student_guardian"]["father"]["occupation"]}}</td>
                                            <td>{{$row["student_guardian"]["father"]["phone"]}}</td>
                                            <td>{{$row["student_guardian"]["father"]["email"]}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ Translator::phrase("extra_info") }}</td>
                                            <td colspan="4" class="text-center text-wrap">
                                                {{$row["student_guardian"]["father"]["extra_info"]}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>{{ Translator::phrase("mother") }}</th>
                        </tr>
                        <tr>
                            <td>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>{{ Translator::phrase("name") }}</th>
                                            <th>{{ Translator::phrase("occupation") }}</th>
                                            <th>{{ Translator::phrase("phone") }}</th>
                                            <th>{{ Translator::phrase("email") }}</th>
                                        </tr>
                                        <tr>
                                            <td>{{$row["student_guardian"]["mother"]["name"]}}</td>
                                            <td>{{$row["student_guardian"]["mother"]["occupation"]}}</td>
                                            <td>{{$row["student_guardian"]["mother"]["phone"]}}</td>
                                            <td>{{$row["student_guardian"]["mother"]["email"]}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ Translator::phrase("extra_info") }}</td>
                                            <td colspan="4" class="text-center text-wrap">
                                                {{$row["student_guardian"]["mother"]["extra_info"]}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>{{ Translator::phrase("guardian") }}</th>
                        </tr>
                        <tr>

                            @if ($row["student_guardian"]["guardian_is"] == "father")
                                <td> {{ Translator::phrase("father_is_guardian") }} </td>
                            @elseif ($row["student_guardian"]["guardian_is"] == "mother")
                                <td> {{ Translator::phrase("mother_is_guardian") }} </td>
                            @else
                            <td>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>{{ Translator::phrase("name") }}</th>
                                            <th>{{ Translator::phrase("occupation") }}</th>
                                            <th>{{ Translator::phrase("phone") }}</th>
                                            <th>{{ Translator::phrase("email") }}</th>
                                        </tr>
                                        <tr>
                                            <td>{{$row["student_guardian"]["guardian"]["name"]}}</td>
                                            <td>{{$row["student_guardian"]["guardian"]["occupation"]}}</td>
                                            <td>{{$row["student_guardian"]["guardian"]["phone"]}}</td>
                                            <td>{{$row["student_guardian"]["guardian"]["email"]}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ Translator::phrase("extra_info") }}</td>
                                            <td colspan="4" class="text-center text-wrap">
                                                {{$row["student_guardian"]["guardian"]["extra_info"]}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            @endif

                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>


    </tbody>
</table>
