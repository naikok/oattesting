<?php
namespace App\Controller;

use App\BusinessService\ExecutorService;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class SaveQuestionsAndChoicesController
{

    /*
     * Request post example
     *
     * body content =>{"Question":{"Question text":"How are you doing?","choices":["fine thans","bad","too bad"]}}
     *
     */
    public function index(ExecutorService $executorService, Request $request) : string
    {
        try {

            $content = $request->getContent();
            $response = json_decode($content,true);
            $question = $response['Question'];

            if ((!array_key_exists('Question text', $question)) || (strlen($question['Question text']) == 0) || (is_null($question['Question text']))) {
                throw new \Exception("Question text field is required", Response::HTTP_BAD_REQUEST);
            }

            if ((!array_key_exists('choices', $question)) || (!is_array($question['choices'])) || (count($question['choices']) > 3)) {
                throw new \Exception("There are more expected responses for this question", Response::HTTP_BAD_REQUEST);
            }

            $time = $dt = new \DateTime();
            $currentDateTime = $time->format('Y-m-d H:i:s');
            $data = ["Question text" => $question['Question text'], "created At" => $currentDateTime, "Choice 1"=> $question['choices'][0], "Choice" => $question['choices'][1],"Choice 3" => $question['choices'][2]];

            $response = $executorService->saveData($data);

            return new JsonResponse([
                'success' => $response,
                'code' => ($response) ? Response::HTTP_OK : Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => ($response) ? "New data was saved properly" : "We could not save the content into the file"
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