<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JSON Table</title>
    <script src="jq/jquery.js"></script>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
            text-align: center;
        }
        th {
            background: yellow;
            color: red;
        }
    </style>
</head>
<body>
    <h1 style="text-align:center; color:red;">JSON Data in Table</h1>

    <table id="dataTable" align="center">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>City</th>
            <th>Course</th>
            <th>Batch</th>
            <th>Year</th>
            <th>Age</th>
            <th>DOB</th>
        </tr>
    </table>

<script>
$(document).ready(function(){
    $.getJSON("fetch.php", { id: 4 }, function(data){
        $.each(data, function(key, value){
            $("#dataTable").append(
                "<tr><td>"+value.id+"</td><td>"+value.name+"</td><td>"+value.city+
                "</td><td>"+value.course+"</td><td>"+value.batch+"</td><td>"+value.year+
                "</td><td>"+value.age+"</td><td>"+value.dob+"</td></tr>"
            );
        });
    });
});
</script>
</body>
</html>
