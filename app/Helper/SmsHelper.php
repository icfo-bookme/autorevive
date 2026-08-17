<?php

namespace App\Helper;

class SmsHelper
{

    private $api_token;
    private $sid;
    private $domain;
    public function __construct()
    {
        $this->api_token = env('SMS_API_TOKEN');
        $this->sid = env('SMS_SID');
        $this->domain = env('SMS_DOMAIN');
    }


    /**
     * @param $msisdn (Phone Number)
     * @param $messageBody
     * @param $csmsId (Unique)
     */
    function singleSms($msisdn, $messageBody)
    {
        $csmsId = $this->generateCsmsId();

        $params = [
            "api_token" => $this->api_token,
            "sid" => $this->sid,
            "msisdn" => $msisdn,
            "sms" => $messageBody,
            "csms_id" => $csmsId
        ];
        $url = trim($this->domain, '/')."/api/v3/send-sms";
        $params = json_encode($params);

        return $this->callApi($url, $params);
    }

    function callApi($url, $params)
    {
        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($params),
            'accept:application/json'
        ));

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }


    /**
     * @param $msisdns
     * @param $messageBody
     * @param $batchCsmsId
     */
    function bulkSms($msisdns, $messageBody)
    {
        $batchCsmsId = $this->generateCsmsId();

        $params = [
            "api_token" => $this->api_token,
            "sid" => $this->sid,
            "msisdn" => $msisdns,
            "sms" => $messageBody,
            "batch_csms_id" => $batchCsmsId
        ];
        $url = trim($this->domain, '/')."/api/v3/send-sms/bulk";
        $params = json_encode($params);

        return $this->callApi($url, $params);
    }

    function generateCsmsId()
    {
        return substr(md5(mt_rand()), 0, 7);
    }

}
