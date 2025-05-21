<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Withdrawal Processing</title>
  <style>
    body {
      background-color: #f0f2f5;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 500px;
      margin: 60px auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .logo {
      width: 120px;
      margin-bottom: 20px;
    }

    h2 {
      color: #1e90ff;
      margin-bottom: 10px;
    }

    .details {
      text-align: left;
      margin-top: 20px;
      font-size: 16px;
      line-height: 1.6;
      color: #333;
    }

    .details strong {
      color: #000;
    }

    .info {
      margin-top: 25px;
      color: #555;
    }

    .contact {
      margin-top: 20px;
      font-weight: bold;
    }

    .contact a {
      color: #1e90ff;
      text-decoration: none;
    }

    .contact a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Logo -->
    <img src="{{asset('images/logo.png')}}" alt="Company Logo" class="logo" />

    <!-- Heading -->
    <h2>Withdrawal Processing</h2>
    <p>Your request has been received and is being processed.</p>

    <!-- Details -->
    <div class="details">
      <p><strong>Name:</strong> {{ $user->first_name. " ". $user->last_name}}</p>
      <p><strong>Amount:</strong> ₦{{ number_format($withdrawal->amount, 2)}}</</p>
      <p><strong>Reference ID:</strong> {{$withdrawal->reference}}</p>
      <p><strong>Date:</strong>{{ \Carbon\Carbon::parse($withdrawal->created_at)->format('d M, Y') }}</p>
    </div>

    <!-- Info -->
    <div class="info">
      You will receive the funds within the next 24 hours.
      <br>If you did not make this request, please contact us immediately.
    </div>

    <!-- Contact -->
    <div class="contact">
      Email: <a href="admin@mywishlist.ng">admin@mywishlist.ng</a><br/>
      Phone: <a href="tel:+2348067522171">08067522171</a>
    </div>
  </div>
</body>
</html>
