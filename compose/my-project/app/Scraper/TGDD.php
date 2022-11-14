<?php

namespace App\Scraper;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\Product;

class TGDD
{

    public function scrape()
    {
        $product = new Product();
        $product->name = "tesst";
        $product->price = 12;
        $product->rate = 5;

        $a = $product->save();  
        var_dump($product);exit;
      
        $url = 'https://www.thegioididong.com/dtdd';

        $client = new Client();
   

        $crawler = $client->request('GET', $url);
        $crawler->filter('ul.listproduct li.item')->each(
            function (Crawler $node) {
                $name = $node->filter('h3')->text();

                $price = $node->filter('.price strong')->text();
                $wholeStar = $node->filter('.icontgdd-ystar')->count();
                $halfStar = $node->filter('.icontgdd-hstar')->count();
                $rate = $wholeStar + 0.5 * $halfStar;

                $price = preg_replace('/\D/', '', $price);
                $product = new Product;
                $product->name = $name;
                $product->price = $price;
                $product->rate = $rate;
                $product->save();
            }
        );
    
    }
}