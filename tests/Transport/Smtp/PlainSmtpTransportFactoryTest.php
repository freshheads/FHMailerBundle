<?php
declare(strict_types=1);

namespace FH\Bundle\MailerBundle\Tests\Transport\Smtp;

use FH\Bundle\MailerBundle\Transport\Smtp\PlainSmtpTransportFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\Transport\Dsn;
use Symfony\Component\Mailer\Transport\Smtp\SmtpTransport;
use Symfony\Component\Mailer\Transport\Smtp\Stream\SocketStream;

final class PlainSmtpTransportFactoryTest extends TestCase
{

    private $factory;

    protected function setUp(): void
    {
        $this->factory = new PlainSmtpTransportFactory();
    }

    /**
     * @covers \FH\Bundle\MailerBundle\Transport\Smtp\PlainSmtpTransportFactory
     */
    public function testSupported(): void
    {
        $dsn = new Dsn('plainsmtp', 'localhost');

        $supports = $this->factory->supports($dsn);

        $this->assertTrue($supports);
    }

    /**
     * @covers \FH\Bundle\MailerBundle\Transport\Smtp\PlainSmtpTransportFactory
     */
    public function testUnsupported(): void
    {
        $dsn = new Dsn('smtp', 'localhost');

        $supports = $this->factory->supports($dsn);

        $this->assertFalse($supports);
    }

    /**
     * @covers \FH\Bundle\MailerBundle\Transport\Smtp\PlainSmtpTransportFactory
     */
    public function testCreateTransport(): void
    {
        $dsn = new Dsn('plainsmtp', 'localhost');
        $transport = $this->factory->create($dsn);
        /** @var SocketStream $stream */
        $stream = $transport->getStream();

        $this->assertInstanceOf(SmtpTransport::class, $transport);
        $this->assertEquals('localhost', $stream->getHost());
        $this->assertEquals(25, $stream->getPort());
        $this->assertFalse($stream->isTLS(), 'TLS should not be enabled');
    }

    /**
     * @covers \FH\Bundle\MailerBundle\Transport\Smtp\PlainSmtpTransportFactory
     */
    public function testCreateTransportNoDefaultPort(): void
    {
        $dsn = new Dsn('plainsmtp', 'localhost', null, null, 30);
        $transport = $this->factory->create($dsn);
        /** @var SocketStream $stream */
        $stream = $transport->getStream();

        $this->assertInstanceOf(SmtpTransport::class, $transport);
        $this->assertEquals('localhost', $stream->getHost());
        $this->assertEquals(30, $stream->getPort());
        $this->assertFalse($stream->isTLS(), 'TLS should not be enabled');
    }
}
