<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Unexpected Error - Page Not Available</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
</head>
<body>
    
<section class="py-5 min-vh-100 d-flex justify-content-center align-items-center page_not_found">
  <div class="container">
    <div class="row">
      <div class="col-md-8 offset-md-2 text-center">
        <h2 class="display-4 mb-4">Oops! An unexpected error occurred.</h2>
        <p class="lead mb-4">We're sorry, but something went wrong while processing your request. Please try again later.</p>
        <span class="back-btn-box"><a class="bsb-btn-5xl btn-warning px-5 fs-6 m-0 shadow-none" href="{{ route('home') }}" >Back to Home</a></span>
      </div>
    </div>
  </div>
</section>

</body>
</html>