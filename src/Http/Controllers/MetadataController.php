<?php

namespace Trendyminds\Metalink\Http\Controllers;

use Illuminate\Http\Request;
use Statamic\Http\Controllers\CP\CpController;
use Symfony\Component\DomCrawler\Crawler;

class MetadataController extends CpController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $meta = get_meta_tags($request->get('url'));
        $html = file_get_contents($request->get('url'));

        return [
            'title' => $meta['twitter:title'] ?? (new Crawler($html))->filterXPath('//title')->text() ?? '',
            'description' => $meta['twitter:description'] ?? $meta['description'] ?? '',
            'image' => $meta['twitter:image'] ?? $meta['msapplication-tileimage'] ?? '',
            'url' => $request->get('url'),
        ];
    }
}
