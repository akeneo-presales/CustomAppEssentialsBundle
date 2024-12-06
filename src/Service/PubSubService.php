<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\Service;

use Google\Cloud\PubSub\Message;
use Google\Cloud\PubSub\PubSubClient;

class PubSubService
{
    private PubSubClient $pubSubClient;

    public function __construct(string $projectDir='') {
        if(isset($_SERVER['APP_ENV']) && ($_SERVER['APP_ENV'] == 'dev' || $_SERVER['APP_ENV'] == 'test')) {
            $filepath = $projectDir.'/'.$_SERVER['GOOGLE_APPLICATION_CREDENTIALS_PUB_SUB'];
            if(file_exists($filepath)) {
                $options =['credentials' => json_decode(file_get_contents($filepath), true)];
            } else {
                $options = [];
            }
        } else {
            $options = [];
        }

        $this->pubSubClient = new PubSubClient($options);

    }

    public function pullMessageFromSubscription($subscription)
    {
        // Get an instance of a previously created topic.
        $subscription = $this->pubSubClient->subscription($subscription);

        // Pull all available messages.
        $messages = $subscription->pull();

        $result = [];
        foreach ($messages as $message) {
            $object = json_decode($message->data());
            $record = ['id' => $object->id, 'time' => $object->time, 'type' => $message->attribute('type'), 'data' => $object->data, 'pubsubMessage' => $message, 'subscription' => $subscription];
            $result[] = $record;
        }

        usort($result, function ($a, $b) {
            return strtotime($a['time']) - strtotime($b['time']);
        });

        return $result;
    }

    public function acknowledgeMessage(string $subscription, Message $message)
    {
        $this->pubSubClient->subscription($subscription)->acknowledge($message);
    }
    public function acknowledgeMessages(string $subscription, array $messages)
    {
        $this->pubSubClient->subscription($subscription)->acknowledgeBatch($messages);
    }

}
