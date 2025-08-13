<?php

//Important Code

if (!function_exists('cd')) {
    function cd(...$data)
    {
        echo "<pre >";

        foreach ($data as $item) {
            if (is_array($item) || is_object($item)) {
                try {
                    print_r(json_decode(json_encode($item), true));
                } catch (\Throwable $e) {
                    var_dump($item);
                }
            } else {
                echo $item . PHP_EOL;
            }
        }

        echo "</pre>";
        die;
    }
}

//stdobject to Array
if (!function_exists('objectToArray')) {
    function objectToArray($object)
    {
        if (!is_object($object) && !is_array($object)) {
            return $object;
        }
        return array_map('objectToArray', (array) $object);
    }
}


// //Check Numeric URL
// if (!function_exists('checkParamUrl')) {
//     function checkParamUrl($value1, $value2, $value3 = "")
//     {
//         $redirect_url = $value2;
//         if (empty($value1)) {
//             session()->flash("error", "Url is empty");
//             echo redirect($redirect_url);
//         }
//         $url_id = substr($value1, 5);

//         if (empty($value3))
//             $error_flash = "Invalid Url";
//         else
//             $error_flash = $value3;

//         if (!is_numeric($url_id)) {

//             session()->flash("error", $error_flash);
//             echo redirect($redirect_url);
//         }

//         return $url_id;

//     }
// }

if (!function_exists('urlParam')) {
    function urlParam($id)
    {
        return rand(10000, 99999) . $id;

    }
}

if (!function_exists('encodeTo16Char')) {

    function encodeTo16Char($number)
    {

        $characters = 'arstuvwxyzABCDESTUVWXYZ0123456789!@#^&*()';
        $base = strlen($characters);

        $code = '';
        while ($number > 0) {
            $remainder = $number % $base;
            $number = intdiv($number, $base);
            $code = $characters[$remainder] . $code;
        }

        // Pad the code with leading zeros if needed
        $code = str_pad($code, 16, 'a', STR_PAD_LEFT);

        return rtrim(strtr(base64_encode($code), '+/', '-_'), '=');
    }
}
if (!function_exists('decodeFrom16Char')) {
    function decodeFrom16Char($code)
    {
        $characters = 'arstuvwxyzABCDESTUVWXYZ0123456789!@#^&*()';
        $base = strlen($characters);

        $code = str_pad(strtr($code, '-_', '+/'), 16, 'a', STR_PAD_LEFT);
        $code = base64_decode($code);

        $number = 0;
        $length = strlen($code);
        for ($i = 0; $i < $length; $i++) {
            $char = $code[$i];
            $value = strpos($characters, $char);
            $number = $number * $base + $value;
        }

        return $number;
    }
}

function jsonMessage($message, $response = "success", $redirect = "crm")
{
    session()->flash("jsonMessage", "true");
    session()->flash("message", $message);
    session()->flash("response", "$response");
    return redirect()->to($redirect);
}

function jsonMessage2($message, $response = "success", $redirect = "crm")
{
    session()->flash("jsonMessage2", "true");
    session()->flash("message", $message);
    session()->flash("response", $response);
    return redirect()->to($redirect);
}

function Code300($message)
{

    $ssdata = array('status' => 'error', 'code' => '300', 'message' => $message);
    $ssdata = json_encode($ssdata);
    return response()->json($ssdata);
}
function Code302($message)
{
    $ssdata = array('status' => 'error', 'code' => '302', 'message' => $message);
    $ssdata = json_encode($ssdata);
    return response()->json($ssdata);
}

function Code200($message, $messageTitle = "", $data = "", $status = "success")
{
    $ssdata = array('status' => $status, 'code' => '200', 'message' => $message, 'messageTitle' => $messageTitle);
    if (!empty($data))
        $ssdata['data'] = $data;
    $ssdata = json_encode($ssdata);
    return response()->json($ssdata);
}

if (!function_exists('flashMessage')) {
    function flashMessage($responseType = "", $message = "", $redirect = "")
    {
        if (empty($responseType) || empty($message)) {
            throw new InvalidArgumentException("Response type and message cannot be empty.");
        }
        session()->flash($responseType, $message);
        if (!empty($redirect)) {
            return redirect($redirect);
        }

        return null;
    }
}


//Check Numeric URL
if (!function_exists('checkParamUrl')) {
    function checkParamUrl($url, $redirect_url = "homepage", $errorMessage = "")
    {
        if (empty($errorMessage))
            $error_flash = "Invalid Url";
        else
            $error_flash = $errorMessage;
        if (empty($url)) {
            session()->flash("error", "Url is empty");
            echo redirect($redirect_url);
        }
        if (!is_numeric($url)) {
            session()->flash("error", $error_flash);
            echo redirect($redirect_url);
        }
        $url_id = substr($url, 5);
        return $url_id;
    }
}

if (!function_exists('ConvertToTimesAgo')) {
    function ConvertToTimesAgo($time)
    {
        $current_time = strtotime(now());
        $database_time = strtotime($time);
        $remaining_time = $current_time - $database_time;

        if ($remaining_time < 60) {
            $remaining_time = $remaining_time . " seconds ago";
        } elseif ($remaining_time < 3600) {
            $minutes = floor($remaining_time / 60);
            $remaining_time = $minutes . " minute" . ($minutes > 1 ? "s" : "") . " ago";
        } elseif ($remaining_time < 86400) {
            $hours = floor($remaining_time / 3600);
            $remaining_time = $hours . " hour" . ($hours > 1 ? "s" : "") . " ago";
        } else {
            $days = floor($remaining_time / 86400);
            $remaining_time = $days . " day" . ($days > 1 ? "s" : "") . " ago";
        }
        echo $remaining_time;
    }
}

if (!function_exists('saveImages')) {
    function saveImages($data, $path = "images")
    {
        $finalResult = null;
        $result = [];
        if (!empty($data) && is_array($data)) {
            foreach ($data as $key => $eImage) {
                $upload_filename = "image_{$key}" . session()->get("userId") . time() . "-ws." . $eImage->getClientOriginalExtension();
                $eImage->storeAs("public/uploads/{$path}/", $upload_filename);
                $imagePath = asset("storage/uploads/{$path}/" . $upload_filename);
                $result[$key] = $imagePath;
            }
        }

        $finalResult['images'] = $result;
        return $finalResult;
    }

}


function getImageByType($images, $type)
{
    $image = collect($images)->firstWhere('image_type', $type);
    return $image ? $image['image'] : ''; // If found, return the image URL, otherwise return an empty string
}


if (!function_exists('getRangeFromArray')) {
    function getRangeFromArray($array)
    {
        $keys = array_keys($array);
        $lowest = min($keys);
        $highest = max($keys);
        return "$lowest-$highest";
    }
}



if (!function_exists('ApiResponse')) {

    function ApiResponse($message, $status = 'success', $code = 200, $data = null, $messageTitle = "")
    {
        $response = [
            'status' => $status,
            'code' => $code,
            'message' => $message,
        ];

        if (!empty($messageTitle)) {
            $response['messageTitle'] = $messageTitle;
        }

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }
}


if (!function_exists('sendOtp')) {
    function sendOtp($modelType, $modelId)
    {
        try {
            $otpCode = rand(100000, 999999);

            DB::table('otp')->insert([
                'otpable_id' => $modelId,
                'otpable_type' => $modelType,
                'otp_code' => $otpCode,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return true;
            // return ApiResponse('OTP has been sent successfully.', 'success', 200, ['otp_code' => $otpCode]);

        } catch (\Exception $e) {
            // Handle any errors (e.g., database errors)
            return false;
            // return ApiResponse('Failed to send OTP. Please try again.', 'error', 500);
        }
    }
    if (!function_exists('getMenuItems')) {
        function getMenuItems()
        {
            return
                [App\Models\ModelPizza::class => "Pizzas", App\Models\ModelProducts::class => "Products", App\Models\ModelDeals::class => "Deals"];
        }
    }


    if (!function_exists('getDealItems')) {
        function getDealItems()
        {
            return
                [App\Models\ModelPizza::class => "Pizzas", App\Models\ModelProducts::class => "Products", App\Models\ModelDealChoices::class => "Choices"];
        }
    }

}

function getSubmittedFormCounts($formData)
{
    $counts = [];
    if (!isset($formData['data']) ) {
        return $counts;
    }

    foreach ($formData['data'] as $entry) {
        $formName = $entry['form']['name'] ?? 'Unknown';
        $isSubmitted = !empty($entry['submitted_on']);

        if ($isSubmitted) {
            $counts[$formName] = ($counts[$formName] ?? 0) + 1;
        }
    }

    return $counts;
}











?>