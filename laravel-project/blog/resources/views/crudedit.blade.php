<h1>edit details</h1>

<div>@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="/edituser/{{$user->id}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" value="put">
        <input type="text" name="username" value="{{ $user->name }}"><br><br>
        <input type="text" name="email" value="{{ $user->email }}"><br><br>
        <input type="text" name="phone" value="{{ $user->phone }}"><br><br>
        @if ($user->image)
            <p>Current Image: <img src="{{ asset('storage/' . $user->image) }}" alt="Current Image"
                    style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;"></p>
        @else
            <p>No current image</p>
        @endif
        <input type="file" name="image"><br><br> <!-- New Image Upload --> <button>update</button>
        <a href="/crudgetdata">cancel</a>
    </form>
</div>