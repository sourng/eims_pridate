<div class="content">
    <div class="title m-b-md">
        Video Chat Rooms
    </div>

    <form action="{{url('room/create')}}" method="post">
        @csrf
        <label for="roomName">Create or Join a Video Chat Room</label>
        <input type="text" name="roomName" id="roomName">
        <button type="submit">Go</button>
    </form>


    @if($rooms)
    @foreach ($rooms as $room)
    <a href=""></a>
    @endforeach
    @endif
</div>
