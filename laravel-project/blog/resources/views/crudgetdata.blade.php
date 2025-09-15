
<h1>User Data</h1>

<div>
    <form action="{{ url('crudgetdata') }}" method="GET">
        <input type="text" name="search" placeholder="Search by name, email, or phone" value="{{ request('search') }}">
        <button type="submit">Search</button>
    </form>
    <br>
    <a href="{{ url('insert') }}">Insert the data</a>
</div>
<br>

@if (request('search'))
    <p>Showing results for: <strong>{{ request('search') }}</strong></p>
@endif

<form action="{{ url('delete-multiple') }}" method="POST">
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
        <tr><td><input type="checkbox" name="ids[]" value="{{ $sd->id }}"></td>
            <td>{{ $sd->id }}</td>
            <td>{{ $sd->name }}</td>
            <td>{{ $sd->email }}</td>
            <td>{{ $sd->phone }}</td>
            <td>{{ $sd->created_at }}</td>
            
            <td><a href="{{ 'delete/' . $sd->id }}">delete</a>  <a href="{{ 'edit/' . $sd->id }}">edit</a></td>

        </tr>

    @endforeach


</table>
<div>
    {{ $studentdata->appends(['search' => request('search')])->links() }}

</div>
<style>
    .w-5.h-5{

        width: 20px;
    }
</style>