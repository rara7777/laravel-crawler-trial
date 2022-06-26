<?php

namespace Tests\Unit\Services;

use App\Http\Repositories\CrawlLogRepository;
use App\Http\Services\CrawlService;
use App\Models\CrawlLog;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;
use function app;
use function collect;

class CrawlServiceTest extends TestCase
{
    private $crawlLogRepository;
    private $crawlService;

    public function setUp(): void
    {
        parent::setUp();

        $this->crawlLogRepository = Mockery::mock(CrawlLogRepository::class);
        $this->crawlService = new CrawlService($this->crawlLogRepository);
    }

    /** @test */
    public function it_can_format_crawl_logs()
    {
        $crawlLog = new CrawlLog();
        $crawlLog->id = 1;
        $crawlLog->input_url = 'input_url';
        $crawlLog->url = 'url';
        $crawlLog->title = 'title';
        $crawlLog->description = 'description';
        $crawlLog->parsed_body = 'parsed_body';
        $crawlLog->screenshot = 'http://localhost/screenshot/example.jpg';
        $crawlLog->created_at = '2022-06-25T13:06:36.000000Z';

        $this->mock(CrawlLogRepository::class, function (MockInterface $mock) use ($crawlLog) {
            $mock->shouldReceive('getLogs')
                ->once()
                ->with('https://example.com')
                ->andReturn(collect([$crawlLog]));
        });

        $result = app(CrawlService::class)->getCrawlLogs('https://example.com');
        $firstResult = $result[0];

        $this->assertArrayHasKey('id', $firstResult);
        $this->assertArrayHasKey('inputUrl', $firstResult);
        $this->assertArrayHasKey('url', $firstResult);
        $this->assertArrayHasKey('screenshot', $firstResult);
        $this->assertArrayHasKey('title', $firstResult);
        $this->assertArrayHasKey('parsedBody', $firstResult);
        $this->assertArrayHasKey('description', $firstResult);
        $this->assertArrayHasKey('createdAt', $firstResult);

        $this->assertEquals('2022-06-25 13:06:36', $firstResult['createdAt']);
    }
}

