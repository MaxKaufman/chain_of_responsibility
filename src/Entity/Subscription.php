<?php
declare(strict_types = 1);

namespace Entity;

class Subscription
{
    public const STATUS_CLOSED = 0;
    public const STATUS_ACTIVE = 1;
    public const STATUS_SUSPENDED = 2;

    /** @var float */
    private $price;

    /** @var float */
    private $bonus;

    /** @var int[] */
    private $categoryIds;

    /** @var int[] */
    private $locationIds;

    /** @var int */
    private $statusId;

    /**
     * Subscription constructor.
     * @param float $price
     * @param float $bonus
     * @param int[] $categoryIds
     * @param int[] $locationIds
     * @param int $statusId
     */
    public function __construct(
        float $price = 0.,
        float $bonus = 0.,
        array $categoryIds = [],
        array $locationIds = [],
        int $statusId = self::STATUS_CLOSED
    ) {
        $this->price = $price;
        $this->bonus = $bonus;
        $this->categoryIds = $categoryIds;
        $this->locationIds = $locationIds;
        $this->statusId = $statusId;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return float
     */
    public function getBonus(): float
    {
        return $this->bonus;
    }

    /**
     * @return int[]
     */
    public function getCategoryIds(): array
    {
        return $this->categoryIds;
    }

    /**
     * @return int[]
     */
    public function getLocationIds(): array
    {
        return $this->locationIds;
    }

    /**
     * @return int
     */
    public function getStatusId(): int
    {
        return $this->statusId;
    }
}
