<?php

namespace Daa\Library\Mail;

use Daa\Library\Mail\Event\MailSent;
use Daa\Library\Mail\Event\MailWillBeSent;
use Daa\Library\Mail\Message\MailInterface;
use Daa\Library\Mail\Sender\NullSender;
use Daa\Library\Mail\Sender\SmtpSender;
use Daa\Library\Mail\TemplateRenderer\TemplateRendererInterface;
use Daa\Library\Mail\TemplateResolver\TemplateResolverInterface;
use Daa\Library\Mail\Transport\NullTransport;
use Daa\Library\Mail\Transport\SwiftMailTransport;
use Daa\Library\Mail\Transport\TransportInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * The mailer is responsible for the rendering and sending of messages.
 */
class Mailer extends AbstractMailer
{
    /**
     * @var TransportInterface[]
     */
    private $transports;

    /**
     * {@inheritDoc}
     */
    public function __construct(
        TemplateResolverInterface $templateResolver,
        TemplateRendererInterface $templateRenderer,
        EventDispatcherInterface $eventDispatcher
    ) {
        parent::__construct($templateResolver, $templateRenderer, $eventDispatcher);

        $this->registerTransport(SmtpSender::class, new SwiftMailTransport());
        $this->registerTransport(NullSender::class, new NullTransport());
    }

    /**
     * Add a transport for mails which have a sender of the given class.
     */
    public function registerTransport(string $senderClass, TransportInterface $transport): void
    {
        $this->transports[$senderClass] = $transport;
    }

    public function sendMail(MailInterface $mail): void
    {
        $event = new MailWillBeSent($mail);
        $this->eventDispatcher->dispatch($event, MailerEvents::beforeSending);

        if (!$event->isSendingStopped()) {
            $transport = $this->transports[get_class($mail->getSender())];
            $transport->sendMail($mail);

            $this->eventDispatcher->dispatch(new MailSent($mail), MailerEvents::afterSending);
        }
    }
}
