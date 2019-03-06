<?php
declare(strict_types = 1);

namespace Entity;

class Alert
{
    public const TYPE_INFO = 1;
    public const TYPE_ERROR = 2;
    public const TYPE_DEFAULT = 3;

    /** @var int */
    private $type;

    /** @var string */
    private $template;

    /** @var array */
    private $payload;

    /**
     * Alert constructor.
     * @param int $type
     * @param string $template
     * @param array $payload
     */
    public function __construct(int $type, string $template, array $payload = [])
    {
        $this->type = $type;
        $this->template = $template;
        $this->payload = $payload;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return $this->payload;
    }
}
