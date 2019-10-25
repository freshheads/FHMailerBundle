<?php
declare(strict_types=1);

namespace FH\MailerBundle\DependencyInjection;

use FH\MailerBundle\Email\Composer\ComposerIdentifiers;
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
                ->end();
    }

    private function getParticipantsNode(): ArrayNodeDefinition
    {
        $node = $this->getRootNode('participants');

        $node
            ->children()
                ->append($this->getEmailNode('sender'))
                ->append($this->getEmailNode('from'))
                ->append($this->getEmailNode('reply_to'))
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
                ->canBeDisabled()
                ->children()
                    ->scalarNode('address')->isRequired()->end()
                    ->scalarNode('name')->cannotBeEmpty()->end()
                ->end();
        }

        return $node;
    }

    private function getRootNode($rootNodeName, TreeBuilder $treeBuilder = null): ArrayNodeDefinition
    {
        if (!$treeBuilder instanceof TreeBuilder) {
            $treeBuilder = new TreeBuilder($rootNodeName);
        }

        return $treeBuilder->getRootNode();
    }
}
