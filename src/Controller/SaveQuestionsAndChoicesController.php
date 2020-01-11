<?php
namespace App\Controller;

use App\BusinessService\ExecutorService;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class SaveQuestionsAndChoicesController
{

    public function index(ExecutorService $executorService, Request $request)
    {

        try {

            $content = $request->getContent();
            $response = json_decode($content,true);
            $question = $response['Question'];

            if ((strlen($question['Question text']) == 0) || (is_null($question['Question text']))) {
                throw new \Exception("Question text field is required", Response::HTTP_BAD_REQUEST);
            }

            if (count($question['choices']) > 3) {
                throw new \Exception("There are more expected responses for this question", Response::HTTP_BAD_REQUEST);
            }

            $time = $dt = new \DateTime();
            $currentDateTime = $time->format('Y-m-d H:i:s');
            $data = ["Question text" => $question['Question text'], "created At" => $currentDateTime, "Choice 1"=> $question['choices'][0], "Choice" => $question['choices'][1],"Choice 3" => $question['choices'][2]];

            $response = $executorService->save($data);

            return new JsonResponse([
                'success' => true,
                'code' => Response::HTTP_OK,
                'message' => "New data was saved properly"
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