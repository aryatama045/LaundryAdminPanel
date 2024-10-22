<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function json(string $message = null, $data = [], $status = 200, array $headers = [], $options = 0)
    {
        $content = [];
        if ($message) {
            $content['message'] = $message;
        }

        if (!empty($data)) {
            $content['data'] = $data;
        }

        return response()->json($content, $status, $headers, $options);
    }

    protected function setEnv($key, $value): bool
    {
        try {
            $envFile = app()->environmentFilePath();
            $str = file_get_contents($envFile);

            // Check if the key exists in the .env file
            if (strpos($str, "{$key}=") === false) {
                $str .= "{$key}={$value}\n";
            } else {
                $str = preg_replace("/{$key}=.*/", "{$key}={$value}", $str);
            }

            // Trim both key and value to remove leading/trailing whitespaces
            $str = rtrim($str) . "\n";

            // Update the .env file
            file_put_contents($envFile, $str);

            return true;
        } catch (Exception $e) {
            // Log or report the exception
            Log::error("Error updating environment variable: {$e->getMessage()}");
            return false;
        }
    }
}
