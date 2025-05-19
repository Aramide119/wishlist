<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="js.js" type="text/Javascript">
    <title>Document</title>
</head>

<body style="max-width: 640px;  margin: auto; height: 100%; box-sizing: border-box;background-color: #FAFAFA;">

    <main style="margin-left: 20px; margin-right: 20px; width: auto; min-height: 640px; display: flex; flex-direction: column; background-color: #FFFFFF;">
        <div style=" height: 100px; border-bottom: 1px solid #ECE9FF; padding-left: 24px;">
            <img src="{{asset('images/logo.png')}}" alt="" style="width: 128px; height: 43px; margin-top: 28px;">
        </div>

        <section style="height: 118px; margin-left: 24px; margin-right: 24px; margin-top: 32px;">

            <h2 style="color:black">Hello, {{ $user->first_name." ". $user->last_name }}</h2>

            <hr style="border: 1px solid #1ABC943B;">

            <p
                style="color: var(--Neutrals-Grey-2, #384860); font-family: Gotham Pro; font-size: 16px; font-style: normal; font-weight: 400; line-height: 150%; letter-spacing: 0.2px;">
                Your Password Reset Code Is:</p>

            </section>

            <h1
                style="color: #1ABC94; font-family: Gotham Pro; font-size: 32px; font-style: normal; font-weight: 700; line-height: 150%; letter-spacing: 0.2px; margin-top: 33px; text-align: center;">
                {{ $send_token }}
            </h1>

        <hr style="border: 1px solid #1ABC943B; margin-left: 24px; margin-top: 80px;">


        <section style="margin-top: auto;">

            <p
                style=" margin-left: 24px; color: var(--Neutrals-Grey-2, #384860); font-family: Gotham Pro; font-size: 12px; font-style: normal; font-weight: 400; line-height: 150%; letter-spacing: 0.2px;">
                {{ config('app.name') }} &copy;{{ date('Y') }} | All rights reserved
            </p>


    <!-- Footer Section -->
    <footer class="footer">
        <div class="footer-content">
            <div class="copyright">
                Copyright © 2025, All rights reserved
            </div>
            <div class="social-icons">
                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>

        </section>

    </main>
</body>

</html>
