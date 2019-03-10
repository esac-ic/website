<?php
/**
 * Created by PhpStorm.
 * User: Niek
 * Date: 10-3-2019
 * Time: 18:41
 */

namespace App\CustomClasses\MailList;


use GuzzleHttp\Client;

class MailMan
{
    private $_client;
    private $_baseUrl;

    public function __construct()
    {
        $this->_baseUrl = env('MAIL_MAN_URL');
        $this->_client = new Client();
    }

    public function get($url){
        return $this->call("GET",$url);
    }

    private function call(string $method,string $url,array $body = []){
        $response = $this->_client->request($method,$this->_baseUrl . $url,[
            "json" => $body,
            "auth" => [
                env('MAIL_MAN_USERNAME'),
                env('MAIL_MAN_PASSWORD')
            ]
        ]);

        return json_decode($response->getBody()->getContents());
    }
}