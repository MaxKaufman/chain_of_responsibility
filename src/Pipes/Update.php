<?php
declare(strict_types = 1);

namespace Pipes;

use Entity\Alert;
use DataValue\Request;

class Update implements PipeInterface
{
    /**
     * @param Request $request
     * @param \Closure $next
     * @return Alert|null
     */
    public function handler(Request $request, \Closure $next): ?Alert
    {
        $deltaPrice = (int) ($request->getNextSubscription()->getPrice() - $request->getSubscription()->getPrice());
        $deltaBonus = (int) ($request->getNextSubscription()->getBonus() - $request->getSubscription()->getBonus());
        $categoryChanged = count($request->getSubscription()->getCategoryIds())
        === count($request->getNextSubscription()->getCategoryIds())
        && array_diff($request->getSubscription()->getCategoryIds(), $request->getNextSubscription()->getCategoryIds())
        === array_diff($request->getNextSubscription()->getCategoryIds(), $request->getSubscription()->getCategoryIds());
        $locationChanged = count($request->getSubscription()->getLocationIds())
        === count($request->getNextSubscription()->getLocationIds())
        && array_diff($request->getSubscription()->getLocationIds(), $request->getNextSubscription()->getLocationIds())
        === array_diff($request->getNextSubscription()->getLocationIds(), $request->getSubscription()->getLocationIds());
        $deltaStatus = $request->getNextSubscription()->getStatusId() - $request->getSubscription()->getStatusId();


        if (($deltaPrice === 0) && ($deltaBonus !== 0) ||
            ($deltaPrice === 0) && ($categoryChanged) ||
            ($deltaPrice === 0) && ($locationChanged) ||
            ($deltaPrice === 0) && ($deltaStatus !== 0)) {
                return new Alert(Alert::TYPE_INFO, 'update', [
                    'bonus' => $deltaBonus,
                    'category' => $request->getNextSubscription()->getCategoryIds(),
                    'location' => $request->getNextSubscription()->getLocationIds(),
                    'status' => $deltaStatus
                ]);
        }

        return $next($request);
    }
}
