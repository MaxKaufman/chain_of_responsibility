<?php
declare(strict_types = 1);

class Factory
{
    /**
     * @return Pipeline
     */
    public static function getForLK(): Pipeline
    {
        return (new Pipeline())
            ->pipe(new Pipes\Upgrade())
            ->pipe(new Pipes\Downgrade())
            ->pipe(new Pipes\Update());
    }

    /**
     * @return Pipeline
     */
    public static function getForShop(): Pipeline
    {
        return (new Pipeline())
            ->pipe(new Pipes\Downgrade())
            ->pipe(new Pipes\Upgrade());
    }

    public static function getForMainBanner(): Pipeline
    {
        return (new Pipeline())
            ->pipe(new Pipes\Downgrade())
            ->pipe(new Pipes\Upgrade())
            ->pipe(new Pipes\Activate())
            ->pipe(new Pipes\Close());
    }
}
