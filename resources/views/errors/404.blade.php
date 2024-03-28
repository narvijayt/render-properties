<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 | Page Not Found</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
</head>
<body>
    
<section class="py-3 py-md-5 min-vh-100 d-flex justify-content-center align-items-center page_not_found">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="text-center">
          <h2 class="d-flex justify-content-center align-items-center gap-2 mb-4">
            <div>
                <strong class="display-1 fw-bold text-dark">4</strong>
                <i class="fa-regular fa-circle text-danger display-4"></i>
                <strong class="display-1 fw-bold bsb-flip-h text-dark">4</strong>
            </div>
          </h2>
          <h3 class="h2 mb-2">Oops! You're lost.</h3>
          <p class="mb-5">The page you are looking for was not found.</p>
          <span class="back-btn-box"><a class="bsb-btn-5xl btn-dark px-5 fs-6 m-0 shadow-none" href="{{ route('home') }}" >Back to Home</a></span>
        </div>
      </div>
    </div>
  </div>
</section>

</body>
</html>