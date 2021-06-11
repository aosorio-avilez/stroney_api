<?php

namespace App\Features\Core\Framework\Firebase;

class FirebaseBuilder
{
    /**
     * Firebase api key
     *
     * @var string
     */
    public $apiKey;

    /**
     * Notification content
     *
     * @var array
     */
    public $content;

    /**
     * Firebase builder constructor
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->data = [];
        $this->apiKey = $apiKey;
    }

    /**
     * Create firebase builder instance
     *
     * @param string $token
     * @return FirebaseBuilder
     */
    public static function create(string $token): FirebaseBuilder
    {
        return new FirebaseBuilder($token);
    }

    /**
     * Set device token
     *
     * @param string $token
     * @return FirebaseBuilder
     */
    public function setToken(string $token): FirebaseBuilder
    {
        $this->content['to'] = $token;
        return $this;
    }

    /**
     * Set registrations ids
     *
     * @param array $tokens
     * @return FirebaseBuilder
     */
    public function setRegistrationsIds(array $tokens): FirebaseBuilder
    {
        $this->content['registration_ids'] = $tokens;
        return $this;
    }

    /**
     * Set notification data
     *
     * @param array $data
     * @return FirebaseBuilder
     */
    public function setData(array $data): FirebaseBuilder
    {
        $this->content['data'] = $data;
        return $this;
    }

    /**
     * Set notification priority
     *
     * @param bool $value
     * @return FirebaseBuilder
     */
    public function setPriority(string $value): FirebaseBuilder
    {
        $this->content['priority'] = $value;
        return $this;
    }

    /**
     * Set notification content available
     *
     * @param bool $value
     * @return FirebaseBuilder
     */
    public function setContentAvailable(bool $value): FirebaseBuilder
    {
        $this->content['content_available'] = $value;
        return $this;
    }

    /**
     * Set mutable content available
     *
     * @param bool $value
     * @return FirebaseBuilder
     */
    public function setMutableContent(bool $value): FirebaseBuilder
    {
        $this->content['mutable_content'] = $value;
        return $this;
    }

    /**
     * Set dry run
     *
     * @return FirebaseBuilder
     */
    public function setDryRun(): FirebaseBuilder
    {
        $this->content['dry_run'] = true;
        return $this;
    }

    /**
     * Set notification info
     *
     * @param array $notification
     * @return FirebaseBuilder
     */
    public function setNotification(array $notification): FirebaseBuilder
    {
        $this->content['notification'] = $notification;
        return $this;
    }

    /**
     * Set notification topic
     *
     * @param string $topic
     * @return FirebaseBuilder
     */
    public function setTopic(string $topic): FirebaseBuilder
    {
        $this->content['to'] = "/topics/$topic";
        return $this;
    }

    /**
     * Build firebase notification
     *
     * @return Firebase
     */
    public function build(): Firebase
    {
        return new Firebase($this);
    }
}
