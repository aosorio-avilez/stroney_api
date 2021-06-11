<?php

namespace App\Features\Core\Framework\Firebase;

use Illuminate\Support\Facades\Log;

class Firebase
{
    /**
     * Google notifications service url
     *
     * @var string
     */
    const FIREBASE_URL = 'https://fcm.googleapis.com/fcm/send';

    /**
     * Firebase api key
     *
     * @var string
     */
    private $apiKey;

    /**
     * Notification content
     *
     * @var array
     */
    private $content;

    /**
     * Firebase constructor
     *
     * @param FirebaseBuilder $builder
     */
    public function __construct(FirebaseBuilder $builder)
    {
        $this->content = [];
        $this->apiKey = $builder->apiKey;
        $this->content = $builder->content;
    }

    /**
     * Send a notification test
     *
     * @return boolean
     */
    public function sendTest(): bool
    {
        $headers = [
            'Authorization: key=' . $this->apiKey,
            'Content-Type: application/json'
        ];
        $curl = curl_init();

        // Setting the curl url
        curl_setopt($curl, CURLOPT_URL, self::FIREBASE_URL);

        // setting the method as post
        curl_setopt($curl, CURLOPT_POST, true);

        // adding headers
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // disabling ssl support
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        // adding the fields in json format
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($this->content));
        //throw new ApiException(JsonUtils::toJSON($this->content),500);
        // finally executing the curl request
        $responseFirebase = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        $sent = false;

        if ($error) {
            $sent = false;
        } else {
            $body = json_decode($responseFirebase);

            if ($body == null || $body->success != 1) {
                $sent = false;
                return $sent;
            }
            $sent = true;
        }

        return $sent;
    }

    /**
     * Send a notification
     *
     * @return boolean
     */
    public function send(): bool
    {
        $headers = [
            'Authorization: key=' . $this->apiKey,
            'Content-Type: application/json'
        ];

        $curl = curl_init();

        // Setting the curl url
        curl_setopt($curl, CURLOPT_URL, self::FIREBASE_URL);

        // setting the method as post
        curl_setopt($curl, CURLOPT_POST, true);

        // adding headers
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // disabling ssl support
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        // adding the fields in json format
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($this->content));
        //throw new ApiException(JsonUtils::toJSON($this->content),500);
        // finally executing the curl request
        $responseFirebase = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        $sent = false;

        if ($error) {
            Log::error($error, $this->content);
            $sent = false;
        } else {
            $body = (array) json_encode($responseFirebase);
            if ($body == null && $this->isSuccess($body)) {
                Log::error(json_encode($body), $this->content);
                $sent = false;
            } else {
                $sent = true;
            }
        }

        return $sent;
    }

    /**
     * Validates if the response is success
     *
     * @param array $body
     * @return boolean
     */
    private function isSuccess(array $body): bool
    {
        return array_key_exists('success', $body) && $body['success'] == 1
            || array_key_exists('message_id', $body);
    }
}
