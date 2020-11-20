<?php

declare(strict_types=1);

namespace Daa\Library\Mail\Event;

use Daa\Library\Mail\Message\MailInterface;
use Daa\Library\Mail\Message\MessageInterface;

final class MessageRendered
{
    /**
     * @var MessageInterface
     */
    private $message;

    /**
     * @var MailInterface
     */
    private $mail;

    public function __construct(MessageInterface $message, MailInterface $mail)
    {
        $this->message = $message;
        $this->mail = $mail;
    }

    public function getMessage(): MessageInterface
    {
        return $this->message;
    }

    public function getMail(): MailInterface
    {
        return $this->mail;
    }
}
