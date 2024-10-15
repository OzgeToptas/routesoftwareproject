<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('main.css') }}">
    <title>Document</title>
</head>
<body class="bg-light login-container">
  <section class="py-3 py-md-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
          <div class="card border border-light-subtle rounded-3 shadow-sm">
            <div class="card-body p-3 p-md-4 p-xl-5">
              <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Sign in to your account</h2>
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
              <form action="{{ route('authenticate') }}" method="POST">
                <div class="row gy-2 overflow-hidden">
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" value="test@example.com" required />
                      <label for="email" class="form-label">Email</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="123456" required />
                      <label for="password" class="form-label">Password</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="d-flex gap-2 justify-content-between">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" name="remember" id="remember" />
                        <label class="form-check-label text-secondary" for="remember">
                          Keep me logged in
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="d-grid my-3">
                      <button class="btn btn-primary btn-lg" type="submit">Log in</button>
                    </div>
                  </div>
                </div>
                @csrf
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
