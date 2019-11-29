<?php
declare(strict_types=1);

namespace FH\Bundle\MailerBundle\Tests\DependencyInjection;

use FH\Bundle\MailerBundle\DependencyInjection\FHMailerExtension;
use FH\Bundle\MailerBundle\Composer\EmailComposer;
use FH\Bundle\MailerBundle\Composer\TemplatedEmailComposer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

final class FHMailerExtensionTest extends TestCase
{
    private $container;
    private $extension;

    public function setUp(): void
    {
        $this->container = new ContainerBuilder();
        $this->extension = new FHMailerExtension();
    }

    /**
     * @covers \FH\Bundle\MailerBundle\DependencyInjection\FHMailerExtension
     */
    public function testExtensionLoaded(): void
    {
        $this->extension->load([], $this->container);

        $this->assertContains(EmailComposer::class, $this->container->getServiceIds());
        $this->assertContains(TemplatedEmailComposer::class, $this->container->getServiceIds());
    }

    /**
     * @covers \FH\Bundle\MailerBundle\DependencyInjection\FHMailerExtension
     */
    public function testConfiguredTagsDefined(): void
    {
        $this->extension->load($this->getTestConfig(), $this->container);

        try {
            $templatedEmailDefinition = $this->container->findDefinition('fh_mailer.composer.templated_email.to_ms_test');
            //$templatedEmailService = $this->container->get('fh_mailer.composer.templated_email.to_ms_test');
        } catch (ServiceNotFoundException $exception) {
            $this->fail("Service 'fh_mailer.composer.templated_email.to_ms_test' is not defined");
        }

        $this->assertEquals(
            (string)$templatedEmailDefinition->getArgument('$messageOptions'),
            'fh_mailer.composer.templated_email.to_ms_test._message_options'
        );

        $this->assertCount(0, $templatedEmailDefinition->getErrors());
        // TODO Assert instance type (TemplatedEmailComposer)
    }

    private function getTestConfig(): array
    {
        return [
            'fh_mailer' => [
                'templated_email' => [
                    'to_ms_test' => [
                        'html_template' => 'test.html.twig',
                        'subject' => 'Test email',
                        'participants' => [
                            'from' => [
                                [
                                    'name' => 'Mr. Test',
                                    'address' => 'test@freshheads.com',
                                ],
                            ],
                            'to' => [
                                [
                                    'name' => 'Ms. Test',
                                    'address' => 'test@freshheads.com',
                                ],
                            ],
                        ]
                    ]
                ]
            ]
        ];
    }
}
