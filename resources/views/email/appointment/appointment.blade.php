<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title }}</title>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            min-height: 100vh;
            width: 100vw;
        }

        a {
            text-transform: capitalize;
        }

        .mainbody {
            display: flex;
            justify-content: center;
            align-items: center;
            /* min-height: 100vh; */
            width: 100%;
            background-color: white;
        }

        .card {
            background-color: white;
            padding: 20px;
            border: 2px solid #ccc;
            box-shadow: 0px 0px 8px 8px #0c0909;
            width: 600px;
            border-radius: 5px;
        }

        .card .logo {
            text-align: center;
        }

        .card .logo img {
            height: 50px;
        }

        .card .name {
            margin: 20px 0;
        }

        .card .name h3 {
            font-weight: 600;
        }

        .card .heading {
            margin-bottom: 20px;
        }

        .card .heading p {
            font-weight: 100;
        }

        .card .credentials {
            margin-bottom: 20px;
        }

        .card .credentials span {
            color: blue;
            font-weight: bold;
            text-transform: capitalize;
        }

        .card .link {
            margin-bottom: 20px;
        }

        .card .link a {
            color: blue;
        }

        .card .button {
            text-align: center;
            margin-bottom: 20px;
        }

        .card .button a {
            background-color: #0e82fd;
            padding: 10px 20px;
            border-radius: 10px;
            color: white;
            text-decoration: none;
            font-weight: bold;
            text-transform: capitalize;
        }

        .card .thanks {
            margin-bottom: 20px;
            /* font-weight: bold; */
        }

        .card .thanks span {
            font-weight: bold;
            color: #0e82fd;
        }

        .card .copyright {
            text-align: center;
        }

        .card .copyright a {
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="mainbody">
        <div class="card" bgcolor="#fff">
            <div class="logo">
                <img src="https://sitara.my/site/assets/img/logo.png" alt="SITARA" title="SITARA LOGO" />
            </div>
            <div class="name">
                <h3>Hello, {{ $name }}</h3>
            </div>
            <div class="heading">
                <p>{!! $title !!}</p>
            </div>

            <div class="credentials">
                <b>Appointment Details</b> <br>

                <b>Clinic's Name: </b> <span>{{ $clinic_name }}</span> <br />
                <b>Scheduled Date: </b> <span>{{ $schedule_date }}</span> <br />
                <b>Scheduled Time: </b> <span>{{ $schedule_time }}</span> <br />
                <b>Appointment Status: </b> <span>{{ $appointment_status }}</span> <br />
                <b>Cause: </b> <span>{{ $cause }}</span> <br />
            </div>

            <div class="link">
                <p>
                    <b>Use this link:</b>
                    <a href="{{ $link }}">{{ $link }}</a>
                    or click the button below follow process:
                </p>
            </div>

            <div class="button">
                <a href="{{ $link }}">{{ $linktitle }}</a>
            </div>

            <div class="thanks">
                <p>
                    Thank You,<br />
                    <span>{{ config('app.name') }}</span>
                </p>
            </div>

            <div class="copyright">
                <p>
                    &copy; 2023 <a href="https://sitara.my/">Sitara</a> All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>

</html>
