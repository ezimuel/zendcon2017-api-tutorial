<?php

namespace BookTest\Action;

use Book\Action\AllBookAction;
use Book\Model\BookModel;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;

class AllBookActionTest extends TestCase
{
    public function setUp()
    {
        $this->response           = $this->prophesize(ResponseInterface::class);
        $this->serverRequest      = $this->prophesize(ServerRequestInterface::class);
        $this->halResponseFactory = $this->prophesize(HalResponseFactory::class);
        $this->resourceGenerator  = $this->prophesize(ResourceGenerator::class);
        $this->delegate           = $this->prophesize(DelegateInterface::class);
        $this->bookModel          = $this->prophesize(BookModel::class);
    }

    public function testConstructor()
    {
        $bookAction = new AllBookAction(
            $this->bookModel->reveal(),
            $this->halResponseFactory->reveal(),
            $this->resourceGenerator->reveal()
        );
        $this->assertInstanceOf(AllBookAction::class, $bookAction);
        $this->assertInstanceOf(MiddlewareInterface::class, $bookAction);
    }
}
