<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">    <style>
            .otp-card {
            max-width: 480px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        
        .otp-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .otp-inputs {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .otp-input {
            width: 60px;
            height: 60px;
            font-size: 24px;
            text-align: center;
            border-radius: 8px;
            border: 2px solid #ced4da;
        }
        
        .otp-input:focus {
            border-color:#2D8C40;
            box-shadow: 0 0 0 0.25rem rgba(13, 253, 85, 0.336);
            outline: none;
        }
        
        .btn-verify {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            font-weight: 500;
        }
        
        .timer {
            text-align: center;
            margin-top: 20px;
            color: #000000;
            font-size: 16px;
        }

    </style>
</head>
<body class="bg-light">

    <div class="d-flex flex-column justify-content-center align-items-center vh-100">
        <div class="mb-3 mt-2 text-center">
            <img src="{{ asset('images/logo.png') }}" alt="MyWishlist Logo" style="height: 50px;">
        </div>
        <div class="container">
            <div class="otp-card">
                <div class="otp-header">
                    <h2 class="mb-2">OTP Verification</h2>
                    <p class="text-secondary">Enter the verification code sent to your device</p>
                </div>
                    
        
            <form action="{{ route('reset') }}" method="POST">
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


              <div class="otp-inputs">
                    <input type="text" name="token1" id="input1" maxlength="1" class="otp-input" oninput="moveAndCount(this, 'input2')">
                    <input type="text" name="token2" id="input2" maxlength="1" class="otp-input" oninput="moveAndCount(this, 'input3')">
                    <input type="text" name="token3" id="input3" maxlength="1" class="otp-input" oninput="moveAndCount(this, 'input4')">
                    <input type="text" name="token4" id="input4" maxlength="1" class="otp-input" oninput="moveAndCount(this, null)">
                </div>

                <button type="submit" class="btn btn-success btn-verify">Verify OTP</button>

                <div class="timer">
                    <span>Expires in: <span id="counter">05:00</span></span>
                </div>


            </form>
            

        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        
    <script>
    function moveAndCount(currentInput, nextId) {
        // Move to next input if current has a value
        if (currentInput.value.length === 1 && nextId) {
            document.getElementById(nextId).focus();
        }

    }
     let timeLeft = 300; // 5 minutes in seconds

    function startTimer() {
        const counter = document.getElementById("counter");
        const timerInterval = setInterval(function () {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            counter.innerText = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

            timeLeft--;

            if (timeLeft < 0) {
                clearInterval(timerInterval);
                counter.innerText = "Token Expired";
                // Optional: Disable inputs or redirect
                disableInputs();
            }
        }, 1000);
    }

    function disableInputs() {
        for (let i = 1; i <= 4; i++) {
            document.getElementById('input' + i).disabled = true;
        }
    }

    // Start the timer on page load
    window.onload = startTimer;
</script>

</body>
</html>