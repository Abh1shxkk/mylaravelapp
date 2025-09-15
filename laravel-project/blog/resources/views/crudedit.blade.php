<h1>edit details</h1>

<div>

<form action="/edituser/{{$user->id}}" method="post">
@csrf
<input type="hidden" name="_method" value="put">
<input type="text" name="username" value="{{ $user->name }}">
<br>
<br>

<input type="text" name="email" value="{{ $user->email }}">
<br>
<br>

<input type="text" name="phone" value="{{ $user->phone }}">
<br>
<br>

<button>update</button>
<a href="/crudgetdata">cancel</a></form>



</div>