<h1>send email </h1>
<div>

<form action="mail1" method="post">
@csrf
<input type="text" name="to" placeholder="enter the email" id="">

<br>
<br>
<input type="text" name="subject" placeholder="enter subject" id="">
<br>
<br>
<textarea type="text" name="message" placeholder="enter the msg" id=""></textarea>
<br>
<br>
<button>send email</button>

</form>
</div>