<?php
declare(strict_types = 1);

namespace Pipes;

use Entity\Alert;
use DataValue\Request;

class Close implements PipeInterface
{

    /**
     * @param Request $request
     * @param \Closure $next
     * @return Alert|null
     */
    public function handler(Request $request, \Closure $next): ?Alert
    {
        $oldStatus = $request->getSubscription()->getStatusId();
        $newStatus = $request->getNextSubscription()->getStatusId();

        if ($newStatus === 0 && $oldStatus !== $newStatus) {
            return new Alert(Alert::TYPE_INFO, 'close', ['status' => $newStatus]);
        }

        return $next($request);
    }
}
