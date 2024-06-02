<?php
namespace App\Services;

use Goutte\Client;

class ScraperAnOneService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getDownloadLinks($url)
    {
        $crawler = $this->client->request('GET', $url);
        $finalLinks = [];
        // Collect all green download links
        $links = $crawler->filter('a.download_line.green')->each(function ($node) {
            $partialLink = $node->attr('href');
            $size = $node->filter('.size')->text();
            $name = $node->filter('div')->text();

            return [
                'partialLink' => $partialLink,
                'size' => $size,
                'name' => $name,
            ];
        });

        // Iterate over collected links to get final download links
        foreach ($links as $linkInfo) {
            $partialLink = $linkInfo['partialLink'];
            $downloadPageCrawler = $this->client->request('GET', 'https://an1.com' . $partialLink);

            // Extract the final download link
            $finalDownloadLink = [
                'name' => $linkInfo['name'],
                'link' => $downloadPageCrawler->filter('#pre_download')->attr('href'),
                'size' => $linkInfo['size'],
            ];

            $finalLinks[] = $finalDownloadLink;
        }
        // $finalLinks[] = 'v' => $version;

        $crawler->filter('span[itemprop="softwareVersion"]')->text();
        return $finalLinks;
    }


    public function scrapeSearchData($url)
    {
        $crawler = $this->client->request('GET', $url);

        $appData = $crawler->filter('.app_list .item')->each(function ($node) {
            $app = [
                'name' => preg_replace('/\s*\(.*?\)\s*/', '', $node->filter('.name a span')->text()),
                'link' => $node->filter('.name a')->attr('href'),
                'logo' => $node->filter('.img img')->attr('src'),
                'developer' => $node->filter('.developer')->text(),
                'rating' => $this->getRating($node),
            ];

            // Scrape additional data from detail page
            $detailData = $this->scrapeDetailData($app['link']);
            return array_merge($app, $detailData);
        });

        return $appData;
    }

    private function getRating($node)
    {
        $style = $node->filter('.current-rating')->attr('style');
        preg_match('/width:(\d+)%/', $style, $matches);
        return $matches ? (int) $matches[1] / 20 : null;
    }

    private function scrapeDetailData($url)
    {
        $crawler = $this->client->request('GET', $url);

        // Extracting additional data including the green download links
        $downloadLinks = $this->getDownloadLinks($url);

        // Extracting the last category from the breadcrumbs
        $categories = [];
        $categories[] = $crawler->filter('ul.catbar li span[itemprop="name"]')->last()->text();
        $name = $crawler->filter('h1[itemprop="headline"]')->text(); // Adjust the selector to match the name element

        // Add "mod" to categories if the name contains "Mod" or "mod"
        if (stripos($name, 'mod') !== false) {
            $categories[] = 'mod';
        }

        $categoriesString = implode(',', $categories);

        $images = $crawler->filter('.app_screens_list img')->each(function ($node) {
            return $node->attr('src');
        });

        return [
            // 'name' => $name,
            'version' => $crawler->filter('span[itemprop="softwareVersion"]')->text(),
            'operating_system' => $crawler->filter('span[itemprop="operatingSystem"]')->text(),
            'category' => $categoriesString,// Returning the categories array
            'size' => $crawler->filter('span[itemprop="fileSize"]')->text(),
            'download_links' => $downloadLinks,
            'about' => $crawler->filter('div[itemprop="description"]')->text(),
            'image' => $images, // Returning the array of image src attributes
        ];
    }


}
