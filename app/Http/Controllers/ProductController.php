<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Show the new product view
     */
    public function getNewProduct()
    {
        return view('new-product');
    }

    /**
     * AJAX handler for creating a new product
     */
    public function postNewProduct(Request $req)
    {
        // Defaults
        $errors = [];
        $images = [];
        $url = \Config::get('app.url');

        // Get form values
        $title = $req->input('title', '');
        $description = $req->input('description', '');
        $vendor = $req->input('vendor', '');
        $productType = $req->input('product_type', '');
        $imageString = $req->input('images', '');

        // These attributes would be part of an array of variants
        $sku = $req->input('sku', '');
        $price = $req->input('price', '');
        $weight = $req->input('weight', '');

        // Validate entered data
        if (empty($title)) {
            $errors[] = 'Please enter a product title';
        }

        if (empty($description)) {
            $errors[] = 'Please enter a product description';
        }

        if (empty($vendor)) {
            $errors[] = 'Please enter a product vendor';
        }

        if (empty($productType)) {
            $errors[] = 'Please enter a product type';
        }

        // These attributes would be part of an array of variants
        if (empty($sku)) {
            $errors[] = 'Please enter a product SKU';
        }

        if (empty($price)) {
            $errors[] = 'Please enter a price';
        }

        if (empty($weight) || intval($weight) === 0) {
            $errors[] = 'Please enter a valid weight in grams';
        }

        if (!empty($imageString)) {
            // Remove trailing comma if there is one (there most likely will be)
            $imageString = preg_replace('{,$}', '', $imageString);

            // Turn the string into an array
            $imageArray = explode(',', $imageString);

            // Correctly format each item in the array for Shopify's API
            foreach ($imageArray as $imageItem) {
                $images[] = ['src' => $url . '/uploads/' . $imageItem];
            }
        }

        if (!empty($errors)) {
            // Return errors if there have been any
            return response()->json([
                'status' => 'error',
                'errors' => $errors
            ]);
        }

        // Everything looks fine, let's create the product
        $shopify = new \App\Helpers\Shopify;
        $create = $shopify->createProduct($title, $description, $vendor, $productType, $sku, $price, $weight, $images);

        if (!$create) {
            // Error creating product
            return response()->json(['status' => 'error', 'errors' => ['There was an error saving the product to Shopify']]);
        }

        // Product created successfully, define flash message and send redirect location
        \Session::flash('notification', 'Product added successfully');

        return response()->json(['status' => 'success', 'location' => '/']);
    }

    /*
     * AJAX handler for uploading and saving images. Resize processing code -could- be considered here, but as Shopify will do this anyway it seems like that's potentially an unnecessary piece of code to write in any case.
     */
    public function postNewProductImageUpload()
    {
        // Define the allowed file types for upload
        $allowedFileTypes = ['jpg', 'jpeg'];

        if (empty($_FILES)) {
            // No uploaded file found
            return response()->json([
                'error' => true,
                'message' => 'No uploaded file found',
                'code' => 500
            ], 500);
        }

        // Get the file extension of the upload file
        $fileExtension = strtolower(end((explode('.', $_FILES['productImage']['name']))));

        if (!in_array($fileExtension, $allowedFileTypes)) {
            // Not an allowed file type
            return response()->json([
                'error' => true,
                'message' => 'The file you uploaded is not in the list of allowed file types (' . implode(', ', $allowedFileTypes) . ')',
                'code' => 500
            ], 500);
        }

        // Get a hash for the filename to avoid conflicts
        $filename = sha1($_FILES['productImage']['name'] . time()) . '.' . $fileExtension;

        // Save file to disk
        move_uploaded_file($_FILES['productImage']['tmp_name'], public_path() . '/uploads/' . $filename);

        // Return success response
        return response()->json(['status' => 'success', 'filename' => $filename]);
    }

}
