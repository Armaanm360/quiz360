<!DOCTYPE html>
<html>

<head>
    <!--TITLE-->
    <title>Quiz 360</title>

    <!--SHORTCUT ICON-->
    <link rel="shortcut icon" href="{{asset('public')}}/img/quiz_logo.png">

    <!--META TAGS-->
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

    <!--FONT AWESOME-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--GOOGLE FONTS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Raleway:wght@700;800;900&family=Source+Sans+3:wght@200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!--EXTERNAL STYLE SHEET-->
    <!-- <link rel="stylesheet" href="css/styles.css"> -->
    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --white: #fff;
            --primary: #5693d5;
        }

        body {
            width: 100vw;
            height: 100vh;
            margin: 0;
            overflow: hidden !important;
            font-family: "Source Sans 3", sans-serif !important;
            background: linear-gradient(rgba(1, 1, 1, 0.7), rgba(1, 1, 1, 0.6)),
                url("{{asset('public')}}/img/bg.jpg");
            background-position: center;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            position: relative;
        }

        .content {
            width: 70%;
            text-align: center;
        }

        .content .logo {
            /* width: 13%; */
            position: absolute;
            top: 1rem;
            left: 2vw;
        }

        .content h1 {
            font-size: 4.5em;
            font-family: "Raleway", sans-serif;
            font-weight: 900;
        }

        .content h2 {
            position: relative;
            top: -30px;
            font-weight: 200;
        }

        .content .social_icons {
            position: fixed;
            right: 2vw;
            bottom: 2vh;
        }

        .content .social_icons:before {
            content: "";
            width: 1px;
            height: 100%;
            background-color: var(--white);
            position: absolute;
            top: -100%;
        }

        .content .social_icons a {
            margin: 10px 0px;
            color: var(--white);
            display: block;
            text-decoration: none;
            font-size: 1.5em;
            transition: 0.5s;
        }

        .content .social_icons a:hover {
            color: var(--primary);
        }

        .arrow {
            text-align: center;
            margin: 1% 0;
        }

        .arrow .fa {
            color: var(--white);
            font-weight: 200;
            text-decoration: none;
        }

        .bounce {
            -webkit-animation: bounce 2s infinite;
            animation: bounce 2s infinite;
        }

        @-webkit-keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-30px);
            }

            60% {
                transform: translateY(-15px);
            }
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-30px);
            }

            60% {
                transform: translateY(-15px);
            }
        }

        /* .content .button {
	position: relative;
	top: -10px;
} */
        .quiz-login {
            margin-top: 70px;
        }
        .button {
            position: relative;
            padding: 16px 30px;
            font-size: 1.5rem;
            color: var(--color);
            /* border: 1px solid #fff; */
            border-radius: 8px;
            /* text-shadow: 0 0 15px var(--color); */
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.1rem;
            transition: 0.5s;
            z-index: 1;
            display: inline-block;
            margin-right: 150px;
            background: #fff;
        }
        .button:last-child {
            margin-right: 0;
        }
        .button:hover {
            color: #fff;
            /* border: 2px solid rgba(0, 0, 0, 0, 0);
            box-shadow: 0 0 0px var(--color); */
        }

        .button::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--color);
            z-index: -1;
            transform: scale(0);
            transition: 0.5s;
        }

        .button:hover::before {
            transform: scale(1);
            transition-delay: 0.5s;
            border-radius: 8px;
            /* box-shadow: 0 0 10px var(--color), 0 0 30px var(--color), 0 0 60px var(--color); */
        }

        .button span {
            position: absolute;
            background: var(--color);
            pointer-events: none;
            border-radius: 2px;
            box-shadow: 0 0 10px var(--color),
                0 0 20px var(--color),
                0 0 30px var(--color),
                0 0 50px var(--color),
                0 0 100px var(--color);
            transition: 0.5s ease-in-out;
            transition-delay: 0.25s;
        }

        .button:hover span {
            opacity: 0;
            transition-delay: 0s;
        }

        .button span:nth-child(1),
        .button span:nth-child(3) {
            width: 40px;
            height: 4px;
        }

        .button:hover span:nth-child(1),
        .button:hover span:nth-child(3) {
            transform: translateX(0);
        }

        .button span:nth-child(2),
        .button span:nth-child(4) {
            width: 4px;
            height: 40px;
        }

        .button:hover span:nth-child(1),
        .button:hover span:nth-child(3) {
            transform: translateY(0);
        }

        .button span:nth-child(1) {
            top: calc(50% - 2px);
            left: -50px;
            transform-origin: left;
        }

        .button:hover span:nth-child(1) {
            left: 50%;
        }

        .button span:nth-child(3) {
            top: calc(50% - 2px);
            right: -50px;
            transform-origin: right;
        }

        .button:hover span:nth-child(3) {
            right: 50%;
        }

        .button span:nth-child(2) {
            left: calc(50% - 2px);
            top: -50px;
            transform-origin: top;
        }

        .button:hover span:nth-child(2) {
            top: 50%;
        }

        .button span:nth-child(4) {
            left: calc(50% - 2px);
            bottom: -50px;
            transform-origin: bottom;
        }

        .button:hover span:nth-child(4) {
            bottom: 50%;
        }

        /* .searchBox {
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, 50%);
	border-radius: 40px;
	padding: 5px 10px;
	display: flex;
}

.searchBox:hover > .searchInput {
	width: 240px;
	padding: 10px;
}

.searchBox:hover > .searchButton {
	background: white;
	color: #2f3640;
}

.searchBox:hover {
	background: #2f3640;
}

.searchBox:hover > .searchButton:hover {
	background-color: var(--primary);
	border: 1px solid var(--primary);
	color: var(--white);
} */

        /* .searchButton {
	color: white;
	float: right;
	width: auto;
	padding: 10px 20px;
	border-radius: 40px;
	background: transparent;
	display: flex;
	justify-content: center;
	align-items: center;
	transition: 0.4s;
	border: 0;
	font-style: normal !important;
	font-weight: 600;
	text-align: center;
	border: 1px solid var(--white);
}

.searchInput {
	border: none;
	background: none;
	outline: none !important;
	float: left;
	padding: 0;
	color: white;
	font-size: 16px;
	transition: 0.4s;
	width: 0px;
} */

        @media screen and (max-width: 1020px) {
            .content h1 {
                font-size: 2em;
            }

            .content h2 {
                position: relative;
                top: -10px;
            }
        }

        @media screen and (max-width: 820px) {
            .content {
                width: 100%;
                padding: 1rem;
            }

            .content .logo {
                width: 20%;
            }

            .content h1 {
                font-size: 1.5em;
            }

            .content h2 {
                position: relative;
                top: -10px;
            }

            .content .social_icons {
                position: absolute;
                width: 100%;
                right: 0vw;
                bottom: 1vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .content .social_icons a {
                margin: 0 15px;
            }

            .content .social_icons:before {
                content: "";
                width: 0px;
                height: 0%;
                top: 00%;
            }

            /* .searchBox:hover > .searchInput {
		max-width: 90%;
		width: 90%;
		padding: 5px 6px;
	}
	.searchBox:hover > .searchButton {
		font-size: 13px;
		white-space: nowrap;
	}
	.searchBox:hover {
		display: flex;
		width: 100%;
	} */
        }

        /* .btn {
  
  -webkit-appearance: none;
  border: 0;
  outline: 0;
  
  position: relative;
  background: linear-gradient(
    -45deg,
    #ffd6d6,
    #faffb0,
    #c0ffb6,
    #d0ddff,
    #e1bfff
  );
  background-size: 400% 400%;
  animation: gradientBG 4.5s ease infinite;
  padding: 1.5rem 10rem;
  color: black;
  text-transform: uppercase;
  border-radius: 100px;
  font-size: 1.3rem;
  transition: 0.3s;
} */
        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

    </style>
</head>

<body>
    <div class="content">
        <img src="{{asset('public')}}/img/quiz_logo.png" class="logo" alt="Quiz">
        <h1>Welcome to Quiz 360<br> An Automated Quiz Platform</h1>
        <h2>Want to make Quiz for your Institution? This is the perfect app to utilize your exam system</h2>
        <div class="arrow bounce">
            <a class="fa fa-arrow-down" href="#"></a>
        </div>
        <div class="quiz-login">
            @if (Route::has('login'))
            @auth
            <a class="button m-0" href="{{ url('/home') }}" style="--color:#1e9bff;">

                <span></span>

                <span></span>

                <span></span>

                <span></span>

                Home

            </a>
            @else
            <a class="button" href="{{ route('login') }}" style="--color:#ff1867;">

                <span></span>

                <span></span>

                <span></span>

                <span></span>

                Login

            </a>
            @if (Route::has('register'))
            {{-- {{ route('register') }} --}}
            <a class="button" href="#" style="--color:#55db28;">

                <span></span>

                <span></span>

                <span></span>

                <span></span>

                Register

            </a>
            @endif
            @endauth
            @endif
        </div>
        <!-- <section class="button">
   <div class="searchBox">
    <input class="searchInput" type="email" name="" placeholder="Email address*" required="">
    <button class="searchButton" href="#">Notify Me</button>
   </div>
  </section> -->
        <section class="social_icons">
            <a href="#" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a>
            <a href="#" title="Instagram" target="_blank"><i class="fa fa-instagram"></i></a>
            <a href="#" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a>
            <a href="#" title="Telegram" target="_blank"><i class="fa fa-telegram"></i></a>
        </section>
    </div>
</body>

</html>
