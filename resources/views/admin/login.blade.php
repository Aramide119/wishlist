<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>My Wishlist</title>
    <link rel="shortcut icon" href="{{ asset('logo.png') }}" type="image/x-icon">
     <!-- Google Web Fonts -->
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
 
     <!-- Icon Font Stylesheet -->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
 
  <style>
    body {
  margin: 0;
  padding: 0;
  background-color: #eceff1;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.login-container {
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.login-box {
  background-color: white;
  padding: 40px 30px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  width: 350px;
}

h2 {
  margin-bottom: 5px;
  font-size: 28px;
  color: #333;
}

.login-text {
  color: #555;
  margin-bottom: 20px;
}

.input-group {
  display: flex;
  align-items: center;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 10px;
  background-color: #f9f9f9;
}

.input-group .icon {
  margin-right: 10px;
  font-size: 16px;
  color: #2D8C40;
}

.input-group input {
  border: none;
  background: none;
  outline: none;
  width: 100%;
  font-size: 16px;
}

.options {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 15px 0;
  font-size: 14px;
}

.options a {
  color: #2D8C40;
  text-decoration: none;
}

.options a:hover {
  text-decoration: underline;
}

.login-btn {
  width: 100%;
  background-color: #2D8C40;
  color: white;
  border: none;
  padding: 12px;
  font-size: 16px;
  border-radius: 4px;
  cursor: pointer;
}

.login-btn:hover {
  background-color: #2D8C40;
}

  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-box">
      <p class="login-text">Login</p>
      <form action="{{ route('submit-login') }}" method="post">
        @csrf
         @if(session('error'))
                            <div class="alert alert-danger" role="alert">
                                <strong class="font-bold ">Error!</strong>
                                <span class="block sm:inline">{{ session('error') }}</span>
                                <span onclick="this.parentElement.style.display='none';"
                                      class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer text-green-700">
                                    &times;
                                </span>
                            </div>
                          @endif
        <div class="input-group">
          <i class="fas fa-user icon"></i>
          <input type="email" placeholder="Email"  name="email" required />
        </div>
        <div class="input-group">
          <i class="fas fa-lock icon"></i>
          <input type="password" placeholder="Password" name="password" required />
        </div>
        <div class="options">
          <label><input type="checkbox" /> Remember me</label>
          <a href="#">Forgot your password?</a>
        </div>
        <button type="submit" class="login-btn">Login</button>
      </form>
    </div>
  </div>
</body>
</html>
