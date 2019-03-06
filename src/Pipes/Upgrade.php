<?php
declare(strict_types = 1);

namespace Pipes;

use Entity\Alert;
use DataValue\Request;

class Upgrade implements PipeInterface
{
    /**
     * @param Request $request
     * @param \Closure $next
     * @return Alert|null
     */
    public function handler(Request $request, \Closure $next): ?Alert
    {
        $deltaPrice = $request->getNextSubscription()->getPrice() - $request->getSubscription()->getPrice();

        if ($deltaPrice > 0) {
            return new Alert(Alert::TYPE_INFO, 'upgrade', ['delta' => $deltaPrice,]);
        }

        return $next($request);
    }
}
