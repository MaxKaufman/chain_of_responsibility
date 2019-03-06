<?php
declare(strict_types = 1);

namespace DataValue;

use Entity\Subscription;

class Request
{
    /** @var Subscription */
    private $subscription;

    /** @var Subscription */
    private $nextSubscription;

    /**
     * Request constructor.
     * @param Subscription $subscription
     * @param Subscription $nextSubscription
     */
    public function __construct(Subscription $subscription, Subscription $nextSubscription)
    {
        $this->subscription = $subscription;
        $this->nextSubscription = $nextSubscription;
    }

    /**
     * @return Subscription
     */
    public function getSubscription(): Subscription
    {
        return $this->subscription;
    }

    /**
     * @return Subscription
     */
    public function getNextSubscription(): Subscription
    {
        return $this->nextSubscription;
    }
}