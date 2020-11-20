<?php

declare(strict_types=1);

namespace Daa\Library\Mail\Event;

use Daa\Library\Mail\Message\MessageInterface;

final class MessageWillBeRendered
{
    /**
     * @var MessageInterface
     */
    private $message;

    public function __construct(MessageInterface $message)
    {
        $this->message = $message;
    }

    public function getMessage(): MessageInterface
    {
        return $this->message;
    }
}
