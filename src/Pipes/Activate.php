<?php
declare(strict_types = 1);

namespace Pipes;

use Entity\Alert;
use DataValue\Request;

class Activate implements PipeInterface
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

        if ($newStatus === 1 && $newStatus !== $oldStatus) {
            return new Alert(Alert::TYPE_INFO, 'activate', ['status' => 1]);
        }

        return $next($request);
    }
}
