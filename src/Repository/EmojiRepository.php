<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Repository;

final class EmojiRepository
{
    /**
     * @return string[]
     */
    public function getAwayEmojis(): iterable
    {
        return new \ArrayObject([
            ':desert_island:',
            ':sleeping:',
            ':sleeping_accommodation:',
            ':mobile_phone_off:',
            ':see_no_evil:',
            ':zzz:',
            ':no_entry:',
        ]);
    }

    public function getPresenceEmojis(): iterable
    {
        return new \ArrayObject([
            ':office_worker:',
            ':raised_hands:',
            ':wave:',
            ':mega:',
        ]);
    }
}
