<!DOCTYPE html>
<html lang="en">

<head>
    <title>elahady.site</title>
    <link rel="icon" type="image/x-icon" href="https://hpanel.hostinger.com/favicons/hostinger.png">
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta content="Default page" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap" rel="stylesheet">
    <!-- <link href="style.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            margin: 0px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100vw;
            height: 100vh;
            min-height: 675px;
            background-color: #F4F5FF;
            background: url('background.jpg') no-repeat center fixed;
            background-size: cover;
        }

        p {
            width: 100%;
            left: 0px;
            font-size: 16px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            letter-spacing: 0px;
            text-align: center;
            vertical-align: top;
            max-width: 550px;
            color: #727586;
            margin: 0px;
        }

        a:hover {
            cursor: pointer;
            color: #673DE6;
            text-decoration: underline;
        }

        h1 {
            font-family: 'DM Sans', sans-serif;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 0px;
            text-align: center;
            margin: 8px;
        }

        .content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .ic-launch {
            margin-left: 10.5px;
            width: 21px !important;
            height: 20px !important;
        }

        .link-container {
            margin-top: 32px;
            margin-bottom: 32px;
        }

        .link {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            font-family: 'DM Sans', sans-serif;
            font-style: normal;
            font-weight: 700;
            font-size: 14px;
            color: #673DE6;
            margin-top: 8px;
            text-decoration: none;
        }

        .main-image {
            width: 100%;
            max-width: 650px;
            max-height: 406px;
            height: auto;
        }

        .navigation {
            width: 100%;
            height: 72px;
            display: flex;
            margin: 0;
            padding: 0;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            background-color: #36344D;
        }

        @media screen and (max-width: 580px) and (min-width: 0px) {

            h1,
            p,
            .link-container {
                width: 80%;
            }
        }

        @media screen and (min-width: 650px) and (min-height: 0px) and (max-height: 750px) {
            .link-container {
                margin-top: 12px;
            }

            h1 {
                margin-top: 0px;
                margin-bottom: 0px;
            }
        }
    </style>
</head>

<body style="background: url('{{ asset('storage/background.jpg') }}') no-repeat center fixed; background-size: cover;">
    <div class="logo_al_kaukaba">
        <img src="{{ asset('storage/logo_putih.svg') }}" width="250" height="133">
    </div>
    <div class="content">
        <img src="{{ asset('storage/moon_transparent.svg') }}" alt="Trulli" width="600" height="333">
    </div>
</body>

</html>