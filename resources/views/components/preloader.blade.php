    <style>
        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
            font-family: 'Open Sans';
        }

        h1 {
            margin: 0;
        }

        section {
            width: 100%;
            height: 100%;
            background-size: cover;
            text-align: center;
            color: white;
        }

        section .top {
            height: calc(100% - 87px);
            background-size: cover;
            background-position: center;
        }

        section .bottom {
            color: black;
        }

        section .bottom h1 {
            font-size: 35px;
            font-weight: 100;
            padding: 20px 0;
        }

        section:nth-of-type(1) .top {
            background-image: url(https://tinyurl.com/mbkue7u);
        }

        section:nth-of-type(2) .top {
            background-image: url(https://tinyurl.com/nsvqqjd);
        }

        section:nth-of-type(3) .top {
            background-image: url(http://unsplash.it/g/3840/2160?image=515);
        }

        section:nth-of-type(4) .top {
            background-image: url(http://unsplash.it/g/3840/2160);
        }

        section:nth-of-type(5) .top {
            background-image: url(http://unsplash.it/g/3840/2160?image=433);
        }

        .overlay {
            position: fixed;
            width: 100%;
            height: 100%;
            background: white;
            z-index: 100;
        }

        .wrapper {
            width: 100px;
            height: 100px;
            background: white;
            display: flex;
            flex-flow: row wrap;
            position: relative;
            transform: translate(-50%, -50%);
            padding: 3px;
            left: 38%;
            bottom: 15%;
        }

        .box {
            width: 50%;
            height: 50%;
            flex: 50%;
            transition: 0.5s;
            border: 2px solid white;
        }

        .box:nth-child(1) {
            animation: load 1s infinite;
        }

        .box:nth-child(2) {
            animation: load2 1s infinite;
            animation-delay: 0.2s;
        }

        .box:nth-child(3) {
            animation: load3 1s infinite;
            animation-delay: 0.7s;
        }

        .box:nth-child(4) {
            animation: load4 1s infinite;
            animation-delay: 0.5s;
        }

        @keyframes load {
            0% {
                background: rgba(231, 76, 60, 0);
            }

            30% {
                background: rgb(231, 76, 60);
            }

            100% {
                background: rgba(231, 76, 60, 0);
            }
        }

        @keyframes load2 {
            0% {
                background: rgba(46, 204, 113, 0);
            }

            30% {
                background: rgb(46, 204, 113);
            }

            100% {
                background: rgba(46, 204, 113, 0);
            }
        }

        @keyframes load3 {
            0% {
                background: rgba(230, 126, 34, 0);
            }

            30% {
                background: rgb(230, 126, 34);
            }

            100% {
                background: rgba(230, 126, 34, 0);
            }
        }

        @keyframes load4 {
            0% {
                background: rgba(241, 196, 15, 0);
            }

            30% {
                background: rgb(241, 196, 15);
            }

            100% {
                background: rgba(241, 196, 15, 0);
            }
        }
    </style>


    <div class="overlay">
        <div class="wrapper">
            <div class="box"></div>
            <div class="box"></div>
            <div class="box"></div>
            <div class="box"></div>
        </div>
    </div>
