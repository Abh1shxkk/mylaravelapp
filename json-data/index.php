<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body style="margin: 0px;padding:0px">
    <div  id="main">
        <div id="header" style="color: red; background-color: yellow;">
            <h1>JSON</h1>
        </div>
        <div id="json"></div>
    </div>
<script src="jq/jquery.js"></script>
<script>
    $(document).ready(function(){
        $.ajax({
            url :"json/my.json",
            type :"GET",
            success : function(data){
                // $("#json").append(data.id + "<br>" + data.title + "<br>" + data.body);
                // console.log(data);
                $.each(data,function(key,value){
                      $("#json").append(value.id + "<br>" + value.title + "<br>" + value.body + "<br>");

                })
            }
        })
    })
</script>
</body>
</html>
