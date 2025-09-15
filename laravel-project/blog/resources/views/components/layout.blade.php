<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
</head>
<body>
    <style>
    .footer p {
        position: absolute;
        bottom: 0;
        background-color: skyblue;
        width: 100%;
        margin: 0;
        padding: 10px;
        text-align: center;
    }

    li {
        display: inline;
    }

    li a {
        text-decoration: none;
    }
</style>
 
    <div class="header">
        <ul>            <li><a href="#">home</a></li>

            <li><a href="#">About</a></li>
            <li><a href="#">Login</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </div>

    <div>
       {{$main}}
    </div>

    <div class="footer">
        <p>Footer page</p>
    </div>
</body>
</html>