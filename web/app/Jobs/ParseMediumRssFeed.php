<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Zend\Feed\Reader\Reader;

class ParseMediumRssFeed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = config('custom.medium_rss_url');

//        try {
            $feed = Reader::import($url);
//        } catch (\Throwable $e) {
//            dd($e->getMessage());
//        }


        $posts = [];

        foreach ($feed as $entry) {
            $posts[] = [
                'title' => $entry->getTitle(),
                'link' => $entry->getLink(),
                'pubDate' => $entry->getDateModified(),
                'description' => // mb_substr(
                    strip_tags($entry->getContent(), '<b><strong><i><em><abbr><q><cite><code><kbd><samp><big><small>')
                   // , 0, 250).'...',
//                'author' => $entry->getAuthor(),
            ];
        }

        Cache::put('medium_posts', $posts, 61);
    }
}
