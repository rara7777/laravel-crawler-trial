<?php

namespace App\Http\Repositories;

use App\Models\CrawlLog;
use Exception;

class CrawlLogRepository
{
    /**
     * @return mixed
     * @throws Exception
     */
    public function getLogs(string $inputUrl)
    {
        try {
            return CrawlLog::where('input_url', $inputUrl)
                ->orderBy('created_at', 'desc')
                ->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param int $id
     *
     * @return mixed
     * @throws Exception
     */
    public function getLogById(int $id)
    {
        try {
            return CrawlLog::findOrFail($id);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
