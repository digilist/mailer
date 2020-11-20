<?php

declare(strict_types=1);

namespace Daa\Library\Mail\Event;

use Daa\Library\Mail\Message\MailInterface;

final class MailSent
{
    /**
     * @var MailInterface
     */
    private $mail;

    public function __construct(MailInterface $mail)
    {
        $this->mail = $mail;
    }

    public function getMail(): MailInterface
    {
        return $this->mail;
    }
}
