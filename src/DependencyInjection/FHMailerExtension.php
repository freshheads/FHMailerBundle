<?php
declare(strict_types=1);

namespace FH\MailerBundle\DependencyInjection;

use FH\MailerBundle\Email\Composer\ComposerIdentifiers;
use FH\MailerBundle\Email\Composer\EmailComposer;
use FH\MailerBundle\Email\Composer\TemplatedEmailComposer;
use FH\MailerBundle\Email\MessageOptions;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

final class FHMailerExtension extends ConfigurableExtension
{
    public function loadInternal(array $configs, ContainerBuilder $container): void
    {
        (new YamlFileLoader($container, new FileLocator(__DIR__.'/../../config')))
            ->load('message_composer.yaml');

        foreach ($configs[ComposerIdentifiers::TEMPLATED_EMAIL] as $name => $messageOptions) {
            $this->registerTemplatedEmailComposer($container, $name, $messageOptions);
        }
    }

    private function registerTemplatedEmailComposer(ContainerInterface $container, string $composerName, array $messageOptions): string
    {
        $emailComposerId = $this->registerEmailComposer($container, $composerName, $messageOptions);
        $composerId = $this->createComposerId($composerName, ComposerIdentifiers::TEMPLATED_EMAIL);

        return $this->registerComposer($container, $messageOptions, TemplatedEmailComposer::class, $composerId, $emailComposerId);
    }

    private function registerEmailComposer(ContainerInterface $container, string $composerName, array $messageOptions): string
    {
        $composerId = $this->createComposerId($composerName, ComposerIdentifiers::EMAIL);

        return $this->registerComposer($container, $messageOptions, EmailComposer::class, $composerId);
    }

    private function registerComposer(ContainerInterface $container, array $messageOptions, string $composerClass, string $composerId, string $chainedComposerId = null): string
    {
        $composerDefinition = new ChildDefinition($composerClass);
        $composerDefinition->setArgument('$messageOptions', $messageOptions);

        if (is_string($chainedComposerId)) {
            $composerDefinition->setArgument('$composer', new Reference($chainedComposerId));
        }

        $container->setDefinition($composerId, $composerDefinition);

        return $composerId;
    }

    private function createComposerId(string $composerId, string $composer): string
    {
        return "fh_mailer.$composer.$composerId";
    }
}
