<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OTP</title>
</head>
<body>
   <div style="text-align: center; padding: 20px">
    <h4> Hello, {{ $user->name }} . Your reset password otp is- </h4>
    <h1>{{ $otp }}</h1>
   </div>
</body>
</html>
