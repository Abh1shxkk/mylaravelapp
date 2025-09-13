<h1>hello</h1>

<h1>the username is {{ session('user') }}</h1>

@if (session('user') )
<h1>welcome {{ session('user')  }}</h1>
@else
<h1>no user found  <a href="login">login</a>
</h1>
@endif

<a href="logout">logout</a>

<h1>all data </h1>

{{ session('allData')['password'] }}