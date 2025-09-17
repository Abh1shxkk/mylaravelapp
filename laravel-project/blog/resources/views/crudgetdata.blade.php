<h1>User Data</h1>

<!-- Insert Form and Table Side by Side -->
<table border="0" width="100%">
    <tr>
        <!-- Insert Form (Left Side) -->
        <td width="50%" valign="top">
            <form action="{{ route('crud.index') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="username" placeholder="enter your name"><br><br>
                <input type="text" name="email" placeholder="enter your email"><br><br>
                <input type="text" name="phone" placeholder="enter your phone"><br><br>
                <input type="file" name="image" accept="image/*"><br><br> 
                <button type="submit">submit</button><br><br>
            </form>
            <!-- Success/Error Message -->
            @if (session('success'))
                <p>{{ session('success') }}</p>
            @endif
            @if (session('error'))
                <p>{{ session('error') }}</p>
            @endif
        </td>

        <!-- Search and Table (Right Side) -->
        <td width="50%" valign="top">
            <form action="{{ url('crudgetdata') }}" method="GET">
                <input type="text" name="search" placeholder="Search by name, email, or phone" value="{{ request('search') }}">
                <button type="submit">Search</button>
            </form><br>

            @if (request('search'))
                <p>Showing results for: <strong>{{ request('search') }}</strong></p>
            @endif

            <form action="{{ route('crud.deleteMultiple') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure you want to delete selected records?')">Delete Selected</button>
                <table border="1">
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>ID</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Phone</td>
                        <td>Created</td>
                        <td>Operations</td>
                    </tr>

                    @foreach ($studentdata as $sd)
                        <tr>
                            <td><input type="checkbox" name="ids[]" value="{{ $sd->id }}"></td>
                            <td>{{ $sd->id }}</td>
                            <td>{{ $sd->name }}</td>
                            <td>{{ $sd->email }}</td>
                            <td>{{ $sd->phone }}</td>
                            <td>{{ $sd->created_at }}</td>
                            <td><a href="{{ route('crud.delete', $sd->id) }}">delete</a> <a href="{{ route('crud.edit', $sd->id) }}">edit</a></td>
                        </tr>
                    @endforeach
                </table>
                <div>
                    {{ $studentdata->appends(['search' => request('search')])->links() }}
                </div>
            </form>
        </td>
    </tr>
</table>

<style>
    .w-5.h-5 { width: 20px; }
</style>