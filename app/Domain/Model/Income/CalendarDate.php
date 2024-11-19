<?php

namespace App\Domain\Model\Income;

final readonly class CalendarDate
{
    private string $date;

    public function __construct(
        string $date
    )
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->date;
    }
}
