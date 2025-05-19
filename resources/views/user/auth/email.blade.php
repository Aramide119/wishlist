<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   
</head>
<body class="bg-light">

    <div class="d-flex flex-column justify-content-center align-items-center vh-100">
        <div class="mb-3 mt-2 text-center">
            <img src="{{ asset('images/logo.png') }}" alt="MyWishlist Logo" style="height: 50px;">
        </div>
        <div class="bg-white p-4 rounded shadow-lg w-100" style="max-width: 400px;">

            
            <form action="{{route('sendResetEmail')}}" method="POST">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Proceed</button>
            </form>
        </div>
    </div>
</body>
</html>