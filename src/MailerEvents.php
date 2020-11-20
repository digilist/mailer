<?php

namespace Daa\Library\Mail;

// @codingStandardsIgnoreFile

/**
 * This class contains constants for events that the mailer dispatches.
 */
final class MailerEvents
{
    /**
     * Dispatched before rendering a mail.
     *
     * @Event("Daa\Library\Mail\Event\MessageWillBeRendered")
     */
    const beforeRendering = 'mailer.before_rendering';

    /**
     * Dispatched after a message was rendered.
     *
     * @Event("Daa\Library\Mail\Event\MessageRendered")
     */
    const afterRendering = 'mailer.after_rendering';

    /**
     * Dispatched before a mail will be sent.
     *
     * @Event("Daa\Library\Mail\Event\MailWillBeSent")
     */
    const beforeSending = 'mailer.before_sending';

    /**
     * Dispatched after a mail has been sent.
     *
     * @Event("Daa\Library\Mail\Event\MailSent")
     */
    const afterSending = 'mailer.after_sending';
}
