<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Builder;

use Barth\SlackUpdater\Repository\EmojiRepository;
use Symfony\Component\Console\Input\InputInterface;

final class ContextBuilder
{
    public function __construct(private EmojiRepository $emojiRepository) {}

    /**
     * @return array<string>
     */
    public function build(InputInterface $input): array
    {
        $context = [];
        $context['custom_emoji'] = $this->getEmoji($input);

        if ($input->hasOption('message') && $input->getOption('message') !== null) {
            $context['custom_message'] = $input->getOption('message');
        }

        return $context;
    }


    private function getEmoji(InputInterface $input): string
    {
        if ($input->hasOption('emoji') && $input->getOption('emoji') !== null) {
            return $input->getOption('emoji');
        }

        if (!$input->hasOption('type')) {
            return '';
        }

        $emojiList = match ($input->getOption('type')) {
            'active' => $this->emojiRepository->getPresenceEmojis()->getArrayCopy(),
            'away' => $this->emojiRepository->getAwayEmojis()->getArrayCopy(),
        };

        \shuffle($emojiList);

        return $emojiList[0];
    }
}
