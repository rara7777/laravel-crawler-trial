<?php

namespace Tests\Feature;

use App\Http\Repositories\CrawlLogRepository;
use App\Http\Services\CrawlService;
use App\Models\CrawlLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class CrawlTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_crawl()
    {
        $crawlLog = CrawlLog::factory()->create([
            'input_url' => 'https://example.com',
        ]);

        $formattedCrawlLog = [
            'id' => $crawlLog->id,
            'inputUrl' => $crawlLog->input_url,
            'url' => $crawlLog->url,
            'screenshot' => $crawlLog->screenshot,
            'title' => $crawlLog->title,
            'parsedBody' => $crawlLog->parsed_body,
            'description' => $crawlLog->description,
            'createdAt' => $crawlLog->created_at->format('Y-m-d H:i:s'),
        ];

        $this->mock(CrawlService::class, function (MockInterface $mock) use ($formattedCrawlLog) {
            $mock->shouldReceive('startCrawling')
                ->once()
                ->with('https://example.com')
                ->andReturnNull();

            $mock->shouldReceive('getCrawlLogs')
                ->once()
                ->with('https://example.com')
                ->andReturn([$formattedCrawlLog]);
        });

        $response = $this->json('POST', '/api/crawl', [
            'url' => 'https://example.com',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'items' => [
                    [
                        'id' => $crawlLog->id,
                        'inputUrl' => $crawlLog->input_url,
                        'url' => $crawlLog->url,
                        'screenshot' => $crawlLog->screenshot,
                        'title' => $crawlLog->title,
                        'parsedBody' => $crawlLog->parsed_body,
                        'description' => $crawlLog->description,
                        'createdAt' => $crawlLog->created_at->format('Y-m-d H:i:s'),
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_can_get_crawl_log_details()
    {
        $crawlLog = CrawlLog::factory()->create([
            'input_url' => 'https://example.com'
        ]);

        $response = $this->json('GET', '/api/details/' . $crawlLog->id);

        $response->assertStatus(200)
            ->assertJson([
                'item' => [
                    'id' => $crawlLog->id,
                    'inputUrl' => $crawlLog->input_url,
                    'url' => $crawlLog->url,
                    'screenshot' => $crawlLog->screenshot,
                    'title' => $crawlLog->title,
                    'parsedBody' => $crawlLog->parsed_body,
                    'description' => $crawlLog->description,
                    'createdAt' => $crawlLog->created_at->format('Y-m-d H:i:s'),
                ]
            ]);
    }

    /** @test */
    public function it_cant_crawl_if_input_is_invalid()
    {
        $response = $this->json('POST', '/api/crawl', [
            'url' => '',
        ]);
        $response->assertStatus(422);

        $response = $this->json('POST', '/api/crawl', [
            'url' => 'test',
        ]);
        $response->assertStatus(422);
    }
}
