<?php

namespace Book;

use Zend\Expressive\Hal\Metadata\MetadataMap;
use Zend\Expressive\Hal\Metadata\RouteBasedCollectionMetadata;
use Zend\Expressive\Hal\Metadata\RouteBasedResourceMetadata;
use Zend\Hydrator\ObjectProperty as ObjectPropertyHydrator;
use Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

class ConfigProvider
{
    public function __invoke() : array
    {
        return [
            'hydrators'        => $this->getHydrators(),
            MetadataMap::class => $this->getHalMetadataMap(),
            'authentication'   => require __DIR__ . '/../config/authentication.php',
            'dependencies'     => $this->getDependencies(),
            'database'         => require __DIR__ . '/../config/database.php'
        ];
    }

    public function getHalMetadataMap() : array
    {
        return [
            [
                '__class__' => RouteBasedResourceMetadata::class,
                'resource_class' => Entity\BookEntity::class,
                'route' => 'book',
                'extractor' => ObjectPropertyHydrator::class,
            ],
            [
                '__class__' => RouteBasedCollectionMetadata::class,
                'collection_class' => Collection\BookCollection::class,
                'collection_relation' => 'books',
                'route' => 'books',
            ],
            [
                '__class__' => RouteBasedResourceMetadata::class,
                'resource_class' => Entity\ReviewEntity::class,
                'route' => 'review',
                'extractor' => ObjectPropertyHydrator::class,
            ],
            [
                '__class__' => RouteBasedCollectionMetadata::class,
                'collection_class' => Collection\ReviewCollection::class,
                'collection_relation' => 'reviews',
                'route' => 'reviews',
            ],
        ];
    }

    public function getHydrators() : array
    {
        return [
            'factories' => [
                __NAMESPACE__ . '\BookHydrator' => BookHydratorFactory::class,
            ],
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'factories'  => [
                PdoService::class => PdoServiceFactory::class,
                Model\BookModel::class => ReflectionBasedAbstractFactory::class,
                Model\ReviewModel::class => ReflectionBasedAbstractFactory::class,
                Action\AllBookAction::class => ReflectionBasedAbstractFactory::class,
                Action\BookAction::class => ReflectionBasedAbstractFactory::class,
                Action\AllReviewAction::class => ReflectionBasedAbstractFactory::class,
                Action\ReviewAction::class => ReflectionBasedAbstractFactory::class
            ]
        ];
    }
}
