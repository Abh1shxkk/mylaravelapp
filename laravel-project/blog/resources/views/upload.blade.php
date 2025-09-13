
<h1>upload a file</h1>
<form action="uploaddata" method="post" enctype="multipart/form-data">

@csrf

<input type="file" name="file" placeholder="upload ur file " >

<br>
<br>
<button>upload </button>

</form>