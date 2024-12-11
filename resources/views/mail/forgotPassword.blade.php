

<!DOCTYPE html>
<html lang="en">
<head>
    <title> Mail</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Tomorrow&display=swap" rel="stylesheet">
    <style>
        .float-left{

        }
        .float-right{
            float: right; margin-top: 8px;
        }
        @media screen and (max-width: 600px){

        }
    </style>
</head>

<body style="background-color: #F5F5F5;font-family: 'Josefin Sans', sans-serif;">

    <div class="card" style="max-width: 736px; background: #fff; margin: 12px auto;padding: 12px">
        <div style="text-align: center">
            <img src="{{ $setting->websiteLogoPath ?? asset('web/logo.png') }}" width="200px">
        </div>
        <h3 style="font-size: 30px; margin-top: 24px;">Forgot Password!</h3>
        <p style="font-size: 16px; line-height: 24px; margin: 0; color: #1C1917">Hello {{ $user->name }} <br> Email : {{ $user->email }} </p>
        <p style="font-size: 16px; line-height: 24px;margin: 0; color:#57534E;"> Silahkan Klik tautan dibawah ini :  </p>

        <div style="margin-top: 40px">

            <div style="background: #F5F5F4;padding: 16px 8px 16px 16px;">
                <span> <a href="https://smp.suryametalindoparts.com/verifyOtp/{{ $otp }}">https://smp.suryametalindoparts.com/verifyOtp/{{ $otp }} </a></span>
            </div>

            <div style=" padding: 16px 8px; display: block;">
                <span style="color: #1C1917;float: left;font-size: 14px;">Atau Link Berikut jika tautan tidak terbuka </span>
                <span style="color: #1C1917;float: right;font-size: 14px;"></span>
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <a href="https://smp.suryametalindoparts.com/verifyOtp/{{ $otp }}" target="_blank" style="width: 240px; padding: 16px 0;color: #fff; margin: auto; background: #00B894;text-decoration: none; font-size: 16px;border-radius: 4px; display: block">
                    Reset Password
                </a>
            </div>

        </div>
    </div>
    <footer style="width: 280px; margin: 16px auto; font-size: 12px;color: #57534E;line-height: 16px;">
        <span>
            Need help with anything? Whatsapps us:
        </span>
    </footer>

</body>
</html>
