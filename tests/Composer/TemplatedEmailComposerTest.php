<?php
declare(strict_types=1);

namespace FH\Bundle\MailerBundle\Tests\Composer;

use FH\Bundle\MailerBundle\Composer\TemplatedEmailComposer;
use FH\Bundle\MailerBundle\Email\MessageOptions;
use FH\Bundle\MailerBundle\Email\Participants;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\InvalidArgumentException;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class TemplatedEmailComposerTest extends TestCase
{
    private $messageOptions;
    private $templatedEmailComposer;

    protected function setUp(): void
    {
        $sender = new Address('test@freshheads.com', 'Mr. Test');
        $to = new Address('test@freshheads.com', 'Ms. Test');

        $this->messageOptions = new MessageOptions(
            'Test email',
            'test.html.twig',
            'test.txt.twig',
            new Participants(
                $sender,
                [$sender],
                [$sender],
                [$to],
                [$to],
                [$to]
            )
        );

        $this->templatedEmailComposer = new TemplatedEmailComposer($this->messageOptions);
    }

    /**
     * @covers \FH\Bundle\MailerBundle\Composer\TemplatedEmailComposer
     */
    public function testWrongMessageType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->templatedEmailComposer->compose([], new Email());
    }

    /**
     * @covers \FH\Bundle\MailerBundle\Composer\TemplatedEmailComposer
     */
    public function testReturnedMessageType(): void
    {
        $email = $this->templatedEmailComposer->compose([]);

        $this->assertInstanceOf(TemplatedEmail::class, $email);
    }

    /**
     * @covers \FH\Bundle\MailerBundle\Composer\TemplatedEmailComposer
     */
    public function testSelectedTemplate(): void
    {
        $email = $this->templatedEmailComposer->compose([]);

        $this->assertSame('test.txt.twig', $email->getTextTemplate());
        $this->assertSame('test.html.twig', $email->getHtmlTemplate());
    }

    /**
     * @covers \FH\Bundle\MailerBundle\Composer\TemplatedEmailComposer
     */
    public function testContext(): void
    {
        $context = ['foo' => 'bar'];
        $email = $this->templatedEmailComposer->compose($context);

        $this->assertSame($context, $email->getContext());
    }
}
