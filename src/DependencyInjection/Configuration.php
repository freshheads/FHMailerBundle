<?php

declare(strict_types=1);

namespace FH\Bundle\MailerBundle\DependencyInjection;

use FH\Bundle\MailerBundle\Composer\ComposerIdentifiers;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public const CONFIG_ID = 'fh_mailer';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(self::CONFIG_ID);
        $rootNode = $this->getRootNode(self::CONFIG_ID, $treeBuilder);

        $this->addMessageComposersNode($rootNode);

        return $treeBuilder;
    }

    private function addMessageComposersNode(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode(ComposerIdentifiers::TEMPLATED_EMAIL)
                    ->useAttributeAsKey('identifier')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('subject')->defaultNull()->end()
                                ->scalarNode('html_template')->defaultNull()->end()
                                ->scalarNode('text_template')->defaultNull()->end()
                                ->append($this->getParticipantsNode())
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->children()
                ->arrayNode(ComposerIdentifiers::EMAIL)
                    ->useAttributeAsKey('identifier')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('subject')->defaultNull()->end()
                                ->append($this->getParticipantsNode())
                            ->end()
                        ->end()
                    ->end()
                ->end();
    }

    private function getParticipantsNode(): ArrayNodeDefinition
    {
        $node = $this->getRootNode('participants');

        $node
            ->children()
                ->append($this->getEmailNode('sender'))
                ->append($this->getEmailNode('from', true))
                ->append($this->getEmailNode('reply_to', true))
                ->append($this->getEmailNode('to', true))
                ->append($this->getEmailNode('cc', true))
                ->append($this->getEmailNode('bcc', true))
            ->end();

        return $node;
    }

    private function getEmailNode(string $rootName, bool $multiple = false): ArrayNodeDefinition
    {
        $node = $this->getRootNode($rootName);

        if ($multiple) {
            $node
                ->prototype('array')
                    ->children()
                        ->scalarNode('address')->isRequired()->end()
                        ->scalarNode('name')->cannotBeEmpty()->end()
                    ->end()
                ->end();
        } else {
            $node
                ->children()
                    ->scalarNode('address')->isRequired()->end()
                    ->scalarNode('name')->cannotBeEmpty()->end()
                ->end();
        }

        return $node;
    }

    private function getRootNode(string $rootNodeName, TreeBuilder $treeBuilder = null): ArrayNodeDefinition
    {
        if (!$treeBuilder instanceof TreeBuilder) {
            $treeBuilder = new TreeBuilder($rootNodeName);
        }

        /* @phpstan-ignore-next-line */
        return $treeBuilder->getRootNode();
    }
}
