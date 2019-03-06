<?php

namespace Pipes;

use Entity\Alert;
use DataValue\Request;

interface PipeInterface
{
    public function handler(Request $request, \Closure $next): ?Alert;
}
