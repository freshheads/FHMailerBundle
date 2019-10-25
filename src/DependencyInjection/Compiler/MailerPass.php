<?php
declare(strict_types=1);

namespace FH\MailerBundle\DependencyInjection\Compiler;

use FH\MailerBundle\Email\Composer\ComposerIdentifiers;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class MailerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $mailers = $container->findTaggedServiceIds('fh_mailer.' . ComposerIdentifiers::TEMPLATED_EMAIL);

        foreach ($mailers as $mailerId => $tags) {
            foreach ($tags as $tag) {
                $composerId = $this->createComposerId($tag['composer']);

                $mailer = $container->getDefinition($mailerId);
                $mailer->setArgument('$composer', new Reference($composerId));
            }
        }
    }

    private function createComposerId(string $composerName): string
    {
        return sprintf('fh_mailer.%s.%s', ComposerIdentifiers::TEMPLATED_EMAIL, $composerName);
    }
}
