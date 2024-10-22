<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SMSGatewaySetupController extends Controller
{
    public function index()
    {
        return view('sms-gateway.index');
    }

    public function update(Request $request)
    {

        if(
            $this->setEnv('SMS_BASE_URL', $request->url) &&
            $this->setEnv('SMS_USER_NAME', $request->user_name) &&
            $this->setEnv('SMS_PASSWORD', $request->password) &&
            $this->setEnv('SMS_ORIGINATOR', $request->originator) &&
            $this->setEnv('SMS_ROUTE', $request->route)
        ){
            Artisan::call('config:cache');
            Artisan::call('config:clear');
            return back()->with('success', 'SMS configuration is setuped successful.');
        }

        return back()->with('error' ,'Failed to open stream Permission denied');
    }

    function setEnv($key, $value): bool
    {
        try{
            $envFile = app()->environmentFilePath();
            $str = file_get_contents($envFile);

            $keyPosition = strpos($str, "{$key}=");
            $endOfLinePosition = strpos($str, "\n", $keyPosition);
            $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

            $str = str_replace($oldLine, "{$key}={$value}", $str);

            $str = substr($str, 0, -1);
            $str .= "\n";

            file_put_contents($envFile, $str);
            return true;
        }catch(Exception $e){
            return false;
        }
    }
}
