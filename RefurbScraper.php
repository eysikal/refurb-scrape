<?php
use Goutte\Client;

class RefurbScraper
{
    public $products = [
        '512GB_29GHz_i5' => [
            'name' => '512GB_29GHz_i5',
            'url' => 'https://www.apple.com/shop/product/G0QP0LL/A/refurbished-133-inch-macbook-pro-27ghz-dual-core-intel-i5-with-retina-display',
            'email_sent' => false
        ],
        '1TB_29GHz_i5' => [
            'name' => '1TB_29GHz_i5',
            'url' => 'https://www.apple.com/shop/product/G0QP1LL/A/refurbished-133-inch-macbook-pro-27ghz-dual-core-intel-i5-with-retina-display',
            'email_sent' => false
        ],
        '1TB_31GHz_i7' => [
            'name' => '1TB_31GHz_i7',
            'url' => 'https://www.apple.com/shop/product/G0QP2LL/A/refurbished-133-inch-macbook-pro-31ghz-dual-core-intel-i7-with-retina-display',
            'email_sent' => false
        ],
        '512GB_31GHZ_i7' => [
            'name' => '512GB_31GHZ_i7',
            'url' => 'https://www.apple.com/shop/product/G0QP3LL/A/refurbished-133-inch-macbook-pro-27ghz-dual-core-intel-i7-with-retina-display',
            'email_sent' => false
        ],
//        'in_stock_test' => [
//            'name' => 'in_stock',
//            'url' => 'https://www.apple.com/shop/product/FLH12LL/A/Refurbished-133-inch-Macbook-Pro-29GHz-Dual-core-Intel-Core-i5-with-Retina-Display-Space-Gray',
//            'email_sent' => false
//        ]
    ];

    public function __construct()
    {
        // Set timezone so Guzzle doesn't complain
        date_default_timezone_set('America/Denver');

        $this->client = new Client();
    }

    public function go()
    {
        foreach ($this->products as $product) {
            $crawler = $this->client->request('GET', $product['url']);
            if ($crawler->filter('button[name=add-to-cart][disabled=disabled]')->count() < 1) {
                // Add to cart button is active, which means it's in stock. Let's go!
                $this->sendEmail($product);
            }
            // Print a . on the console so we can see that the scraper process is running
            echo '.';
            // Pause for 10 seconds so we aren't hammering the site
            sleep(10);
        }

        exit();
    }

    private function sendEmail($product)
    {
        // Pull email address from file outside version control
        $email = require_once 'email.php';
        if (!mail($email, sprintf('%s model is in stock!', $product['name']), $product['url'])) {
            echo "\n", sprintf('Email failed to send for model %s. Link: %s', $product['name'], $product['url']);
        }
    }
}