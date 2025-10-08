<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 Page Not Found</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  </head>

  <style>
   @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

    .admin-form{
      background: radial-gradient(circle, #0dcaf0 0%, rgba(23, 23, 23, 1) 100%);
      font-family: "Montserrat", sans-serif;
      min-height:100vh;
      display:flex;
      justify-content:center;
      align-items:center;
      color:#212529;
    }

    .error-box {
      background: #fff;
      border-radius: 20px;
      padding: 50px;
      text-align: center;
      box-shadow: rgba(13, 202, 240, 0.3) 0px 4px 20px;
    }

    .error-box h1 {
      font-size: 120px;
      font-weight: 900;
      background: linear-gradient(217deg, #0dcaf0, #212529);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 20px;
    }

    .error-box h4 {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 15px;
      color:#212529;
    }

    .error-box p {
      font-size: 16px;
      margin-bottom: 30px;
      color: #6c757d;
    }

    .error-box a.btn {
      border-radius: 50px;
      padding: 12px 30px;
      border: 1px solid #0dcaf0;
      background: linear-gradient(217deg, #0dcaf0 0%, #212529 100%);
      color: #fff;
      transition: all 0.4s ease-in-out;
    }

    .error-box a.btn:hover {
      background-position: 100% 0;
      box-shadow: rgba(13, 202, 240, 0.4) 0px 4px 12px;
      transform: translateY(-2px);
      color:#fff;
    }

  </style>
  <body>

    <div class="container-fluid p-0 m-0 admin-form">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-lg-8 offset-lg-2 col-md-8 offset-md-2">
            <div class="error-box">
              <h1>404</h1>
              <h4>Oops! Page Not Found</h4>
              <p>The page you’re looking for doesn’t exist or has been moved.</p>
              <a href="{{ url('/') }}" class="btn">Go Back Home</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
