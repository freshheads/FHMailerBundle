<?php
declare(strict_types=1);

namespace FH\Bundle\MailerBundle\Transport\Smtp;

use Symfony\Component\Mailer\Transport\AbstractTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;
use Symfony\Component\Mailer\Transport\Smtp\SmtpTransport;
use Symfony\Component\Mailer\Transport\Smtp\Stream\SocketStream;
use Symfony\Component\Mailer\Transport\TransportInterface;

final class PlainSmtpTransportFactory extends AbstractTransportFactory
{
    /**
     * @return string[]
     */
    protected function getSupportedSchemes(): array
    {
        return [ 'plainsmtp' ];
    }

    /**
     * @return SmtpTransport
     */
    public function create(Dsn $dsn): TransportInterface
    {
        $stream = new SocketStream();
        $stream->disableTls();
        $stream->setPort($dsn->getPort(25));
        $stream->setHost($dsn->getHost());

        return new SmtpTransport($stream, $this->dispatcher, $this->logger);
    }
}
