<?php
declare(strict_types=1);

namespace FH\Bundle\MailerBundle\Tests\Transport\Smtp;

use FH\Bundle\MailerBundle\Transport\Smtp\PlainSmtpTransportFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\Transport\Dsn;
use Symfony\Component\Mailer\Transport\Smtp\SmtpTransport;
use Symfony\Component\Mailer\Transport\Smtp\Stream\SocketStream;

class PlainSmtpTransportFactoryTest extends TestCase
{

    private $factory;

    protected function setUp(): void
    {
        $this->factory = new PlainSmtpTransportFactory();
    }

    /**
     * @covers \FH\Bundle\MailerBundle\Composer\ApplyEmailMessageOptions
     */
    public function testCreateTransport(): void
    {
        $dsn = new Dsn('smtp', 'localhost');
        $transport = $this->factory->create($dsn);
        /** @var SocketStream $stream */
        $stream = $transport->getStream();

        $this->assertInstanceOf(SmtpTransport::class, $transport);
        $this->assertEquals('localhost', $stream->getHost());
        $this->assertEquals(25, $stream->getPort());
        $this->assertFalse($stream->isTLS(), 'TLS should not be enabled');
    }

    /**
     * @covers \FH\Bundle\MailerBundle\Composer\ApplyEmailMessageOptions
     */
    public function testCreateTransportNoDefaultPort(): void
    {
        $dsn = new Dsn('', 'localhost', null, null, 30);
        $transport = $this->factory->create($dsn);
        /** @var SocketStream $stream */
        $stream = $transport->getStream();

        $this->assertInstanceOf(SmtpTransport::class, $transport);
        $this->assertEquals('localhost', $stream->getHost());
        $this->assertEquals(30, $stream->getPort());
        $this->assertFalse($stream->isTLS(), 'TLS should not be enabled');
    }
}
