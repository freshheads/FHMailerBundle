<?php

declare(strict_types=1);

namespace FH\Bundle\MailerBundle\Transport\Smtp;

use Symfony\Component\Mailer\Transport\AbstractTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;
use Symfony\Component\Mailer\Transport\Smtp\SmtpTransport;
use Symfony\Component\Mailer\Transport\Smtp\Stream\SocketStream;

final class PlainSmtpTransportFactory extends AbstractTransportFactory
{
    /**
     * @return string[]
     */
    protected function getSupportedSchemes(): array
    {
        return ['plainsmtp'];
    }

    public function create(Dsn $dsn): SmtpTransport
    {
        $stream = new SocketStream();
        $stream->disableTls();
        $stream->setPort((int) $dsn->getPort(25));
        $stream->setHost($dsn->getHost());

        return new SmtpTransport($stream, $this->dispatcher, $this->logger);
    }
}
