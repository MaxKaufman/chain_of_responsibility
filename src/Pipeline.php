<?php
declare(strict_types = 1);

class Pipeline
{
    /** @var Pipes\PipeInterface[] */
    private $pipes = [];

    /**
     * @param \Pipes\PipeInterface $pipe
     * @return Pipeline
     */
    public function pipe(Pipes\PipeInterface $pipe): self
    {
        $this->pipes[] = $pipe;
        return $this;
    }

    /**
     * @param \Entity\Subscription $subscription
     * @param \Entity\Subscription $nextSubscription
     * @return \Entity\Alert|null
     */
    public function getAlert(Entity\Subscription $subscription, Entity\Subscription $nextSubscription): ?Entity\Alert
    {
        $request = new \DataValue\Request($subscription, $nextSubscription);
        $index = 0;

        $lambda = function () use ($request, &$index, &$lambda) {
            if ($index <= (count($this->pipes) - 1)) {
                return $this->pipes[$index++]->handler($request, $lambda);
            }

            return null;
        };

        return $lambda();
    }
}
