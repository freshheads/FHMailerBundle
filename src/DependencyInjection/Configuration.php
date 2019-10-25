<?php
declare(strict_types=1);

namespace FH\MailerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public const CONFIG_ID = 'fh_mailer';
    public const SERVICE_TAG = 'freshheads.mailer';
    public const COMPOSER_PREFIX = 'fh_mailer.composer_templated_email.';

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
            ->arrayNode('message_composers')
            ->useAttributeAsKey('identifier')
            ->beforeNormalization()
            ->ifArray()
            ->then(static function ($v) {
                foreach ($v as $key => $value) {
                    if (is_string($value)) {
                        $v[$key] = ['template' => $value];
                    }
                }

                return $v;
            })
            ->end()
            ->prototype('array')
            ->children()
            ->scalarNode('template')->isRequired()->end()
            ->scalarNode('emogrifier_id')->cannotBeEmpty()->end()
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
            ->append($this->getEmailNode('to', true))
            ->append($this->getEmailNode('cc', true))
            ->append($this->getEmailNode('bcc', true))
            ->scalarNode('subject')->defaultNull()->end()
            ->scalarNode('htmlTemplate')->defaultNull()->end()
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

    private function getRootNode($rootNodeName, TreeBuilder $treeBuilder = null): ArrayNodeDefinition
    {
        if (!$treeBuilder instanceof TreeBuilder) {
            $treeBuilder = new TreeBuilder($rootNodeName);
        }

        return $treeBuilder->getRootNode();
    }
}
