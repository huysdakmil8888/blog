<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $validate=$this->validate($request,[
            'title'=>'required',
            'description'=>'required',
        ]);

        Post::forceCreate($request->all());
        return ['message'=>'create success'];
    }
    public function getToken()
    {
        try {
            $portal = $this->portalService->getPortal('parcel2go');
            $url = 'https://' . $portal->api_url . '/auth/connect/token';

            header('Content-Type: application/json'); // Specify the type of data
            $ch = curl_init($url); // Initialise cURL
            $host = "Host: " . $portal->api_url; // Prepare the authorisation token
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded',$host)); // Inject the token into the header
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1); // Specify the request method as POST
            //$post = json_encode($post); // Encode the data array into a JSON string
            //curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Set the posted fields
            curl_setopt($ch, CURLOPT_POSTFIELDS, "client_id=" . $portal->api_client_id .
                "&client_secret=" . $portal->api_client_secret .
                "&grant_type=" . $portal->api_grant_type);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch); // Execute the cURL statement
            curl_close($ch); // Close the cURL connection

            return json_decode($result)->access_token;

        } catch (\InvalidArgumentException $ex) {
            abort(422, $ex->getMessage());
        }
    }
    public function getApiService($token, $url, $method = 0, $post = []){
        header('Content-Type: application/json'); // Specify the type of data
        $ch = curl_init($url); // Initialise cURL
        $authorization = "Authorization: Bearer ".$token; // Prepare the authorisation token
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization )); // Inject the token into the header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, $method); // Specify the request method as POST
        if($method == 1){
            $post = json_encode($post); // Encode the data array into a JSON string
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Set the posted fields
        }
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
        $result = curl_exec($ch); // Execute the cURL statement
        curl_close($ch); // Close the cURL connection
        return json_decode($result); // Return the received data
    }

    public function getCourierFromPascel(Request $request)
    {
        try {

            $portal = $this->portalService->getPortal('parcel2go');
            $serviceURL = 'https://www.parcel2go.com/api/services';

            // Get token from Pascel2go
            $token = $this->courierService->getToken();


            // Using token to get data from Pascel2go
            $apiService = $this->courierService->getApiService($token, $serviceURL);

            $result= $apiService->Results;
            foreach ($result as $service) {
                $newCollect['CollectionCountries']=$service->CollectionCountries;
            }
            return $newCollect;



            return $apiService;

            // Format data and return to api
            $courier = $this->courierService->formatDataCouriers($apiService, $countryCode);

            return response()->json($courier);

        } catch (\InvalidArgumentException $ex) {
            abort(422, $ex->getMessage());
        }
    }


}
