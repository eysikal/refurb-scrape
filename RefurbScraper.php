<?php
use Goutte\Client;

class RefurbScraper
{
    public $products = [];

    public function __construct()
    {
        // Set timezone so Guzzle doesn't complain
        date_default_timezone_set('America/Denver');

        // Pull list products from file
        $this->products = require_once 'products.php';

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