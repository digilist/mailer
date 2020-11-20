<?php

declare(strict_types=1);

namespace Daa\Library\Mail\Event;

use Daa\Library\Mail\Message\MailInterface;

final class MailWillBeSent
{
    /**
     * @var MailInterface
     */
    private $mail;

    /**
     * @var bool
     */
    private $sendingStopped = false;

    public function __construct(MailInterface $mail)
    {
        $this->mail = $mail;
    }

    public function getMail(): MailInterface
    {
        return $this->mail;
    }

    /**
     * Prevent the mail from being sent.
     */
    public function stopSendingMail(): void
    {
        $this->sendingStopped = true;
    }

    public function isSendingStopped(): bool
    {
        return $this->sendingStopped;
    }
}
