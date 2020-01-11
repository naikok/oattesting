<?php
namespace App\Controller;
use App\BusinessService\ExecutorService;
use App\Service\ManagerDataService;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\FactoryDataManager\ManagerDataFactory;
use App\Entity\Question;
use App\Entity\Choice;

class GetAllQuestionsAndChoicesController
{
    public function index(ExecutorService $executorService, Request $request) : JsonResponse
    {
        try {

            $lang = $request->get('lang');

            if (empty($lang) || is_null($lang)) {
                throw new \Exception("lang parameter is required", Response::HTTP_BAD_REQUEST);
            }

            $translatedQuestions = $executorService->readDataQuestionsToLanguage($lang);

            return new JsonResponse([
                'success' => true,
                'code' => Response::HTTP_OK,
                'message' => $translatedQuestions,
            ]);

        } catch(\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);
        }
    }
}