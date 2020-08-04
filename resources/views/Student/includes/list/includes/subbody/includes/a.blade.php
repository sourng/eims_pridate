<table class="table table-xs table-bordered">
    <tbody>
        <tr>
            <th colspan="2">{{ Translator::phrase("address") }}</th>
        </tr>
        <tr>
            <td>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>{{ Translator::phrase("place_of_birth") }}</th>
                        </tr>
                        <tr>
                            <td>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>{{ Translator::phrase("province") }}</th>
                                            <th>{{ Translator::phrase("district") }}</th>
                                            <th>{{ Translator::phrase("commune") }}</th>
                                            <th>{{ Translator::phrase("village") }}</th>
                                        </tr>
                                        <tr>
                                            <td>{{$row["place_of_birth"]["province"]["name"]}}</td>
                                            <td>{{$row["place_of_birth"]["district"]["name"]}}</td>
                                            <td>{{$row["place_of_birth"]["commune"]["name"]}}</td>
                                            <td>{{$row["place_of_birth"]["village"]["name"]}}</td>
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
                            <th>{{ Translator::phrase("current_resident") }}</th>
                        </tr>
                        <tr>
                            <td>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>{{ Translator::phrase("province") }}</th>
                                            <th>{{ Translator::phrase("district") }}</th>
                                            <th>{{ Translator::phrase("commune") }}</th>
                                            <th>{{ Translator::phrase("village") }}</th>
                                        </tr>
                                        <tr>
                                            <td>{{$row["current_resident"]["province"]["name"]}}</td>
                                            <td>{{$row["current_resident"]["district"]["name"]}}</td>
                                            <td>{{$row["current_resident"]["commune"]["name"]}}</td>
                                            <td>{{$row["current_resident"]["village"]["name"]}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>

        <tr>
            <td>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>{{ Translator::phrase("permanent_address") }}</td>
                            <td class="text-center text-wrap"> {{$row["permanent_address"]}} </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>{{ Translator::phrase("temporaray_address") }}</td>
                            <td class="text-center text-wrap"> {{$row["temporaray_address"]}} </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
