<?php

declare(strict_types=1);

namespace App\Domain\Model\Income;

use InvalidArgumentException;

final class IncomeName
{
    private const MIN_WORD_COUNT = 1;
    private const MAX_WORD_COUNT = 100;

    private readonly string $name;

    public function __construct(
        string $name
    )
    {
        $this->assertWordCount($name);
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->name;
    }

    /**
     * @param string $value
     * @return void
     */
    private function assertWordCount(string $value): void
    {
        $word_count = mb_strlen($value);

        if ($word_count < self::MIN_WORD_COUNT) {
            throw new InvalidArgumentException('名前は1文字以上です。');
        }

        if ($word_count > self::MAX_WORD_COUNT) {
            throw new InvalidArgumentException('名前は100文字以下です。');
        }
    }
}
