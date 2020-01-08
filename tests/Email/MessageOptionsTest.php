<?php
declare(strict_types=1);

namespace FH\Bundle\MailerBundle\Tests\Email;

use FH\Bundle\MailerBundle\Email\MessageOptions;
use PHPUnit\Framework\TestCase;

/**
 * @covers \FH\Bundle\MailerBundle\Email\MessageOptions
 */
final class MessageOptionsTest extends TestCase
{
    private $messageOptions;

    protected function setUp(): void
    {
        $this->messageOptions = MessageOptions::fromArray([
            'html_template' => 'test.html.twig',
            'text_template' => 'test.text.twig',
            'subject' => 'Test email',
            'participants' => [
                'from' => [
                    [
                        'name' => 'Mr. Test',
                        'address' => 'test@freshheads.com',
                    ],
                ],
                'reply_to' => [
                    [
                        'name' => 'Mr. Test',
                        'address' => 'mr.test@freshheads.com',
                    ],
                ],
                'to' => [
                    [
                        'name' => 'Ms. Test',
                        'address' => 'test@freshheads.com',
                    ],
                ],
                'cc' => [
                    [
                        'name' => 'Ms. Test',
                        'address' => 'test1@freshheads.com',
                    ],
                ],
                'bcc' => [
                    [
                        'name' => 'Ms. Test',
                        'address' => 'test2@freshheads.com',
                    ],
                ],
        ]]);
    }

    public function testFromArray(): void
    {
        $this->assertTrue($this->messageOptions->hasSubject());
        $this->assertSame('Test email', $this->messageOptions->getSubject());

        $this->assertTrue($this->messageOptions->hasHtmlTemplate());
        $this->assertSame('test.html.twig', $this->messageOptions->getHtmlTemplate());

        $this->assertTrue($this->messageOptions->hasTextTemplate());
        $this->assertSame('test.text.twig', $this->messageOptions->getTextTemplate());

        $participants = $this->messageOptions->getParticipants();
        $this->assertCount(1, $participants->getFrom());
        $this->assertSame('Mr. Test', $participants->getFrom()[0]->getName());
    }
}
