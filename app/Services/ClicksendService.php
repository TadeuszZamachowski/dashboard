<?php

namespace App\Services;
use ClickSend\Configuration;
use ClickSend\Api\SMSApi;
use GuzzleHttp\Client;
use Exception;
class ClicksendService
{
    protected $apiInstance;
    public function __construct()
    {
        $config = Configuration::getDefaultConfiguration()
        ->setUsername(env('CLICKSEND_USER'))
        ->setPassword(env('CLICKSEND_API_KEY'));   

        $this->apiInstance = new SMSApi(new Client(), $config); 
    }

    public function sendSMS($to, $message) 
    {
        $msg = new \ClickSend\Model\SmsMessage();
        $msg->setSource("byronbaybikes.com");
        $msg->setBody($message);
        $msg->setTo($to);
        $msg->setFrom("+61418883631");

        $sms_messages = new \ClickSend\Model\SmsMessageCollection();
        $sms_messages->setMessages([$msg]);

        
        $result = $this->apiInstance->smsSendPost($sms_messages);

        $resultDecode = json_decode($result, true);
        $success = $resultDecode['data']['messages'][0]['status'];

        if(substr_count(strtolower($success), 'success') >= 1) {
            return 1;
        } else {
            return 0;
        }
    }
}
