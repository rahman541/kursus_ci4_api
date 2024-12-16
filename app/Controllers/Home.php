<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index() // : string
    {
        // return view('welcome_message');
        $client = service('curlrequest', [
            'baseURI' => 'https://api.waktusolat.app/'
        ]);
        return $client->get('zones');
    }

    public function zone() {
        $data = '{
            "zone": "PLS01",
            "year": 2024,
            "month": "DEC",
            "last_updated": "2024-11-15T03:19:23.394Z",
            "prayers": [
                ...
            ]
        }';
        $dataObj = json_decode($data);
        $arrayData = json_decode($data, true);
        dd($dataObj, $arrayData);
    }

    public function zone1() {
        // return view('welcome_message');
        $client = service('curlrequest', [
            'baseURI' => 'https://api.waktusolat.app/'
        ]);
        // return $client->get('v2/solat/PLS01');
        // $dataEncoded = $client->get('v2/solat/PLS01');
        $response = $client->get('v2/solat/PLS01');
        // return $response;
        $body = $response->getBody();
        $data = json_decode($body);
        return $data->zone;
        // dd($data->zone);
    }

    public function dbConnection() {
        $db = db_connect();
        //dd($db->listTables());
    }
}
