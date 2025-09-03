<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP with Ajax</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            background: #f6c56f;
            padding: 10px;
            text-align: center;
        }
        #container {
            text-align: center;
            margin-top: 20px;
        }
        table {
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th {
            background: #5bc0de;
            padding: 8px;
        }
        td {
            padding: 8px;
            text-align: center;
        }
    </style>
    <!-- jQuery include -->
    <script src="../jquery/jquery.js"></script>
</head>
<body>

    <h1>PHP with Ajax</h1>

    <div id="container">
        <button id="loadBtn">Load Data</button>

        <!-- Table by default empty hai (sirf headings) -->
        <table id="table-data">
           
    </div>

<script>
$(document).ready(function(){
    $('#loadBtn').on("click", function(){
        $.ajax({
            url : 'ajaxload.php',   
            type : 'POST',
            success : function(data){
            
                $("#table-data").html(data);
            }
        });
    });
});
</script>
</body>
</html>
