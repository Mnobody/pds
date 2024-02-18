<?php

declare(strict_types=1);

namespace Shared\Infrastructure\MessageHandler;

use Shared\Infrastructure\Message\TestMessage;

final class TestMessageHandler
{
    public function __invoke(TestMessage $message): void
    {
        echo 'Doing staff... ' . $message->getValue();
        sleep(2);
        echo 'Done.';
        echo "\n";
    }
}
