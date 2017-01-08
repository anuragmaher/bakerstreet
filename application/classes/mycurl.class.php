<?php

class MyCurl{

	public static function callAPI($method, $url, $data = false, $token = false, $needHeader = true)
    {
        $curl = curl_init();
        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "DELETE":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        $headers = array(
    		'authtoken: '. $token,
		);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        if($needHeader)
        {
            curl_setopt($curl, CURLOPT_HEADER, true);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT,10);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }	

}