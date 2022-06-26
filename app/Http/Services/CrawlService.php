<?php

namespace App\Http\Services;

use App\Http\Repositories\CrawlLogRepository;
use Exception;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlProfiles\CrawlInternalUrls;

class CrawlService
{
    private $crawlLogRepository;

    public function __construct(
        CrawlLogRepository $crawlLogRepository
    ) {
        $this->crawlLogRepository = $crawlLogRepository;
    }

    /**
     * @param string $url
     *
     * @return void
     * @throws Exception
     */
    public function startCrawling(string $url)
    {
        try {
             Crawler::create()
                ->ignoreRobots()
                ->setConcurrency(30)
                ->setMaximumDepth(1)
                ->setMaximumResponseSize(1024 * 1024 * 3)
                ->setTotalCrawlLimit(60)
                ->setDelayBetweenRequests(500)
                ->setParseableMimeTypes(['text/html'])
                ->setCrawlProfile(new CrawlInternalUrls($url))
                ->setCrawlObserver(new MyCrawlObserver($url))
                ->startCrawling($url);

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param string $url
     *
     * @return array
     * @throws Exception
     */
    public function getCrawlLogs(string $url): array
    {
        try {
            $items = $this->crawlLogRepository->getLogs($url);
            $formattedItems = [];
            foreach($items as $item) {
                $formattedItems[] = [
                    'id' => $item->id,
                    'inputUrl' => $item->input_url,
                    'url' => $item->url,
                    'screenshot' => $item->screenshot,
                    'title' => $item->title,
                    'parsedBody' => $item->parsed_body,
                    'description' => $item->description,
                    'createdAt' => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : '',
                ];
            }
            return $formattedItems;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
