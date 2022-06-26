<?php

namespace App\Http\Controllers;

use App\Http\Repositories\CrawlLogRepository;
use App\Http\Requests\CrawlRequest;
use App\Http\Services\CrawlService;
use Exception;
use Illuminate\Http\JsonResponse;

class CrawlController extends Controller
{
    private $crawlLogRepository;
    private $crawlService;

    public function __construct(
        CrawlLogRepository $crawlLogRepository,
        CrawlService $crawlService
    ) {
        $this->crawlLogRepository = $crawlLogRepository;
        $this->crawlService = $crawlService;
    }

    /**
     * @param CrawlRequest $request
     *
     * @return JsonResponse
     */
    public function crawl(CrawlRequest $request): JsonResponse
    {
        $url = rtrim($request->url, '/');
        $items = [];
        try {
            $this->crawlService->startCrawling($url);

            $items = $this->crawlService->getCrawlLogs($url);

            return response()->json([
                'items' => $items,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msg' => 'something error! please try again',
                'items' => $items,
            ], 400);
        }
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function showDetails($id): JsonResponse
    {
        try {
            $item = $this->crawlLogRepository->getLogById($id);

            return response()->json([
                'item' => [
                    'id' => $item->id,
                    'inputUrl' => $item->input_url,
                    'url' => $item->url,
                    'screenshot' => $item->screenshot,
                    'title' => $item->title,
                    'parsedBody' => $item->parsed_body,
                    'description' => $item->description,
                    'createdAt' => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : '',
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msg' => 'something error! please try again',
            ], 400);
        }
    }
}
