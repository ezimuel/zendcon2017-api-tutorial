<?php

namespace Book;

use Zend\Expressive\Authentication;
use Zend\Expressive\Hal\Metadata\MetadataMap;
use Zend\Expressive\Hal\Metadata\RouteBasedCollectionMetadata;
use Zend\Expressive\Hal\Metadata\RouteBasedResourceMetadata;
use Zend\Hydrator\ObjectProperty as ObjectPropertyHydrator;
use Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Zend\ServiceManager\Factory\InvokableFactory;

class ConfigProvider
{
    public function __invoke() : array
    {
        return [
            'hydrators'        => $this->getHydrators(),
            MetadataMap::class => $this->getHalMetadataMap(),
            'authentication'   => require __DIR__ . '/../config/authentication.php',
            'dependencies'     => $this->getDependencies(),
            'database'         => require __DIR__ . '/../config/database.php',
            'input_filters'    => $this->getInputFilters()
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
                'collection_class' => Collection\BookReviewCollection::class,
                'collection_relation' => 'reviews',
                'route' => 'reviews',
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
    public function getDependencies(): array
    {
        return [
            'aliases' => [
                Authentication\AuthenticationInterface::class => Authentication\Adapter\BasicAccess::class,
                Authentication\UserRepositoryInterface::class => Authentication\UserRepository\PdoDatabase::class
            ],
            'factories'  => [
                PdoService::class => PdoServiceFactory::class,
                Model\BookModel::class => ReflectionBasedAbstractFactory::class,
                Model\ReviewModel::class => ReflectionBasedAbstractFactory::class,
                Action\AllBookAction::class => ReflectionBasedAbstractFactory::class,
                Action\BookAction::class => ReflectionBasedAbstractFactory::class,
                Action\AllReviewAction::class => ReflectionBasedAbstractFactory::class,
                Action\ReviewAction::class => ReflectionBasedAbstractFactory::class,
                Middleware\AddReviewValidationMiddleware::class => Middleware\ContentValidationMiddlewareFactory::class,
                Action\AddReviewAction::class => ReflectionBasedAbstractFactory::class,
                Middleware\UpdateReviewValidationMiddleware::class => Middleware\ContentValidationMiddlewareFactory::class,
                Action\UpdateReviewAction::class => ReflectionBasedAbstractFactory::class
            ]
        ];
    }

    public function getInputFilters(): array
    {
        return [
            'factories' => [
                InputFilter\Review::class => InvokableFactory::class,
            ],
        ];
    }
}
