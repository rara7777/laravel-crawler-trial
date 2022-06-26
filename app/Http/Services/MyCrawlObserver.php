<?php

namespace App\Http\Services;

use App\Models\CrawlLog;
use App\Utils\StringFormatter;
use Exception;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Browsershot\Browsershot;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use function collect;
use function now;
use function public_path;
use function url;

class MyCrawlObserver extends CrawlObserver
{
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function willCrawl(UriInterface $url)
    {
        //
    }

    /**
     * @param UriInterface $url
     * @param ResponseInterface $response
     * @param UriInterface|null $foundOnUrl
     *
     * @return void
     * @throws Exception
     */
    public function crawled(UriInterface $url, ResponseInterface $response, ?UriInterface $foundOnUrl = null)
    {
        try {
            $parsedUrl = parse_url($url);
            $fileName = now()->format('Y_m_d_H_i_s') . '_' . Str::random(6) . '.jpg';
            $fileBasePath = '/screenshots/' . $parsedUrl['host'];
            $filePath = public_path($fileBasePath . '/'. $fileName);

            if (!file_exists(public_path($fileBasePath))) {
                mkdir(public_path($fileBasePath));
            }

            Browsershot::url($url)
                ->setOption('landscape', true)
                ->windowSize(1920, 1080)
                ->waitUntilNetworkIdle()
                ->save($filePath);

            $rawBody = $response->getBody();
            $title = StringFormatter::getTitle($rawBody);
            $description = StringFormatter::getDescription($rawBody);
            $parsedBody = StringFormatter::parseBody($rawBody);

            CrawlLog::updateOrCreate([
                'input_url' => $this->url,
                'url' => $url,
            ],[
                'title' => $title,
                'description' => $description,
                'raw_body' => $rawBody,
                'parsed_body' => $parsedBody,
                'status' => $response->getStatusCode(),
                'screenshot' => url($fileBasePath . '/' . $fileName),
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function crawlFailed(UriInterface $url, RequestException $requestException, ?UriInterface $foundOnUrl = null)
    {
        Log::channel('crawl')->error('crawlFailed: ' . $url);
    }

    public function finishedCrawling()
    {
        //
    }
}
