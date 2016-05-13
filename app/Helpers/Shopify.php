<?php namespace App\Helpers;

use \Config;
use GuzzleHttp\Client;

class Shopify
{
    public $url = null;

    public function __construct()
    {
        // Construct the private application URL
        $this->url = 'https://' . Config::get('shopify.api_key') . ':' . Config::get('shopify.api_password') . '@' . Config::get('shopify.api_url');
    }

    /**
     * Create a new product in Shopify based on supplied parameters
     * @param  [string] $title       Product title
     * @param  [string] $description Product description
     * @param  [string] $vendor      Vendor
     * @param  [string] $productType Type of product
     * @param  [string] $sku         Product SKU
     * @param  [decimal] $price      Price
     * @param  [int] $weight         Weight
     * @param  [array]  $images      Array of images for the product
     * @return [bool]                  Status of the production creation operation
     */
    public function createProduct($title, $description, $vendor, $productType, $sku, $price, $weight, $images = [])
    {
        // Construct payload
        $payload = [
            'product' => [
                'title' => $title,
                'body_html' => $description,
                'vendor' => $vendor,
                'product_type' => $productType,
                'variants' => [
                    0 => [
                        'sku' => $sku,
                        'price' => $price,
                        'weight' => $weight
                    ]
                ],
                'images' => $images
            ]
        ];

        try {
            // Attempt to send the payload to Shopify
            $guzzleClient = new Client;
            $guzzleRequest = $guzzleClient->request('POST', $this->url . '/admin/products.json', [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($payload),
            ]);
        } catch (\Exception $e) {
            // Log error and return false;
            \Log::error(__CLASS__ . ': Error creating product: ' . $e->getMessage());
            return false;
        }

        // Return true if the API call was successful
        return true;
    }

}