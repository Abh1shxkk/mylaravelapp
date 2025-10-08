<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <h4 class="mb-3">Create account</h4>
            <form method="POST" action="/register">
              @csrf
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Full name</label>
                  <input type="text" name="full_name" value="{{ old('full_name') }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Username</label>
                  <input type="text" name="username" value="{{ old('username') }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Email</label>
                  <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                </div>
                <!-- role input removed: default to user on server -->
                <div class="col-md-6">
                  <label class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Confirm Password</label>
                  <input type="password" name="password_confirmation" class="form-control" required>
                </div>
              </div>
              <button class="btn btn-primary w-100 mt-3">Register</button>
            </form>
            <div class="text-center mt-3">
              <a href="/login">Already have an account?</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


