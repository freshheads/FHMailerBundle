<?php
declare(strict_types=1);

namespace FH\MailerBundle\Tests\DependencyInjection;

use FH\MailerBundle\DependencyInjection\FHMailerExtension;
use FH\MailerBundle\Email\Composer\EmailComposer;
use FH\MailerBundle\Email\Composer\TemplatedEmailComposer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class FHMailerExtensionTest extends TestCase
{
    private $container;
    private $extension;

    public function setUp(): void
    {
        $this->container = new ContainerBuilder();
        $this->extension = new FHMailerExtension();
    }

    public function testExtensionLoadedDefaults(): void
    {
        // TODO load test config and add assertions
        $this->extension->load([], $this->container);

        $this->assertContains(EmailComposer::class, $this->container->getServiceIds());
        $this->assertContains(TemplatedEmailComposer::class, $this->container->getServiceIds());

        // TODO test if the expected services are created
        //$this->assertEquals(FHMailerExtension::class, (string) $this->container->getAlias('fh_mailer.templated_email_composer.REPLACE_ME'));
    }
}
