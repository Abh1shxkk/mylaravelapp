
    <h2>Login Form</h2>
    <form action="rq1" method="POST">
        @csrf <!-- Laravel security token -->

        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="user" placeholder="Enter your name" required>
        </div>

        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div>

        <button type="submit">Submit</button>
    </form>

