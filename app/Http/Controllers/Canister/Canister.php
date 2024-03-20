<?php

namespace App\Http\Controllers\Canister;

use Illuminate\Support\Facades\Http;

class Canister
{
    public $APT_URL;
    public $API_PORT;
    public $API;
    public $MODE;
    /*
     * @Canister
     * @Args
     *      URL
     *      PORT
     */
    public function __construct( $mode,$APT_URL, $API_PORT){
        $this->API_PORT = $API_PORT;
        $this->APT_URL = $APT_URL;
        $this->MODE = $mode;
        $this->API = $this->MODE.$this->APT_URL.":".$this->API_PORT;
    }

    public function createAccount($to, $amount) {
        if (!$to || !$amount) {
            return ['error' => 'Missing "account_id" or "amount" parameter'];
        }
        $response = Http::get($this->APT_URL.':'.$this->API_PORT.'/create?account_id='
        .$to.'&amount='.$amount);
        if ($response->successful()) {
            // Retrieve the response body as an array or JSON object
            $data = $response->json();

            // Process the data as needed
            // For example, if the API returns JSON data:
            foreach ($data as $item) {
                // Process each item
                echo "Item: " . $item['name'] . "\n";
            }
            return $data;
        } else {
            // Handle the error
            echo "Error: " . $response->status() . "\n";
            echo "Message: " . $response['message'] . "\n";
        }
        return "";
    }

    public function depositIcp($to, $amount)
    {
        if (!$to || !$amount) {
            return ['message' => 'Missing "account_id" or "amount" parameter'];
        }

        // Call dfx command to perform ICP deposit
        $response = Http::get($this->API."/deposit_icp?to=$to&amount=$amount");

        if ($response->successful()) {
            return $response->json();
        } else {
            return ['message' => 'Failed to deposit ICP'];
        }
    }

    public function withdrawIcp($to, $amount)
    {
        if (!$to || !$amount) {
            return ['message' => 'Missing "account_id" or "amount" parameter'];
        }

        // Call dfx command to perform ICP withdrawal
        $response = Http::get($this->API."/withdraw_icp?to=$to&amount=$amount");

        if ($response->successful()) {
            return $response->json();
        } else {
            return ['message' => 'Failed to withdraw ICP'];
        }
    }

    public function transferIcp($from, $to, $amount)
    {
        if (!$from || !$to || !$amount) {
            return ['message' => 'Missing "from_account_id", "to_account_id", or "amount" parameter'];
        }

        // Call dfx command to perform ICP transfer
        $response = Http::get($this->API."/transfer_icp?from=$from&to=$to&amount=$amount");

        if ($response->successful()) {
            return $response->json();
        } else {
            return ['message' => 'Failed to transfer ICP'];
        }
    }

    public function getBalance($accountId)
    {
        if (!$accountId) {
            return ['message' => 'Missing "account_id" parameter'];
        }

        // Call dfx command to get account balance
        $response = Http::get($this->API."/get_balance?account_id=$accountId");

        if ($response->successful()) {
            return $response->json();
        } else {
            return ['message' => 'Failed to get balance'];
        }
    }
}
