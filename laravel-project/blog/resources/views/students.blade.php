{{ print_r($students) }}

<table border="1">

    <tr>
        <td>name</td>
                <td>email</td>
        <td>batch</td>

        
    </tr>
    @foreach ($students as $student)

    <tr>
        <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>

                        <td>{{ $student->batch }}</td>

    </tr>
    
    @endforeach
</table>