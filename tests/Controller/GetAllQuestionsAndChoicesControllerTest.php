<?php

namespace App\Tests\Service\Translators;
use App\Controller\GetAllQuestionsAndChoicesController;
use App\BusinessService\ExecutorService;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetAllQuestionsAndChoicesControllerTest extends WebTestCase
{
    public function testGetAllQuestionsAndChoicesReturnsJsonResponse()
    {
        $request = $this->getMock("Symfony\Component\HttpFoundation\Request");
        $executorService = $this->getMockBuilder(ExecutorService::class)->disableOriginalConstructor()->getMock();
        $lang = "fr";

        $request->expects($this->once())
            ->method("get")
            ->with($this->equalTo('lang'))
            ->will($this->returnValue($lang));

        $arrayresult = []; //this must be containing a response array format, right now as example I put and empty array

        $executorService ->expects($this->once())
        ->method('readDataQuestionsToLanguage')
        ->with($this->equalTo($lang))
        ->willReturn($arrayresult);

        $controller = new GetAllQuestionsAndChoicesController();
        $result = $controller->index($request, $executorService);
        $this->assertTrue($result instanceof JsonResponse);
    }
}