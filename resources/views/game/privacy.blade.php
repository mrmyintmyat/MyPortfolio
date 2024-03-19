<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - ZYNN GAMES</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    /* Reset CSS */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Basic styles */
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
    }

    .container {
        width: 80%;
        margin: 0 auto;
        padding: 20px 0;
    }

    header,
    footer {
        background-color: #100d0d;
        color: #17de56;
        padding: 10px 0;
    }

    header nav ul {
        list-style-type: none;
    }

    header nav ul li {
        display: inline;
        margin-right: 20px;
    }

    header nav ul li a {
        color: #fff;
        text-decoration: none;
    }

    main {
        padding: 20px 0;
    }

    .privacy-policy,
    .terms-of-service,
    .contact {
        margin-top: 20px;
    }

    .privacy-policy h2,
    .terms-of-service h2,
    .contact h2 {
        margin-bottom: 10px;
    }

    footer {
        text-align: center;
    }
</style>

<body>

    <header>
        <div class="container">
            <h1>Privacy Policy</h1>
            <nav>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/">Games</a></li>
                    <li><a href="/profile">Profile</a></li>
                    @if (Auth::check())

                        <li><a type="button" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();"
                                id="focus_tag" class="text-decoration-none btn btn-light fw-semibold border shadow-sm">
                                Logout
                            </a></li>
                    @else
                        <li><a href="/login">Login</a></li>
                    @endif
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="privacy-policy">
            <div class="container">
                <h2>Privacy Policy</h2>
                <p>This Privacy Policy outlines the types of personal information collected, and how it is used, shared,
                    and protected on our ZYNN GAMES.</p>
                <p>We collect personal information such as name, email, and profile picture to create user accounts,
                    enable commenting, and personalize user experiences.</p>
                <p>We use cookies and similar technologies to enhance user experience, analyze usage patterns, and
                    improve our services.</p>
            </div>
        </section>

        <section class="terms-of-service">
            <div class="container">
                <h2>Terms of Service</h2>
                <p>By accessing or using our ZYNN GAMES, you agree to abide by our Terms of Service. These terms govern
                    your use of the platform and outline your rights and responsibilities.</p>
                <p>You must be at least 13 years old to use our platform. You are responsible for maintaining the
                    confidentiality of your account and for all activities that occur under your account.</p>
            </div>
        </section>

        <section class="contact">
            <div class="container">
                <h2>Contact Us</h2>
                <p>If you have any questions about our Privacy Policy or Terms of Service, please contact us:</p>
                <ul>
                    <li>Email: {{ env('MAIL_FROM_ADDRESS') }}</li>
                    <li>Telegram: <a style="color: #17de56;" href="{{ env('TELEGRAM') }}">{{ env('TELEGRAM') }}</a></li>
                    <li>Facebook: <a style="color: #17de56;" href="{{ env('FACEBOOK') }}">{{ env('FACEBOOK') }}</a></li>
                    <li>Phone: {{ env('PHONE') }}</li>
                </ul>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 ZYNN GAMES. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>
