<h1>flash session</h1>


{{ session(key: 'message') }}
{{ session(key: 'name') }}

{{ session()->keep('name') }}



<form action="session" method="post">
@csrf
<input type="text" name="username" placeholder="enter username " id="">
<br>
<br>
<input type="text" name="email" placeholder="enter email " id="">
<br>
<br>
<input type="text" name="phone" placeholder="enter phone " id="">
<br>
<br>
<button>submit</button>
</form>
