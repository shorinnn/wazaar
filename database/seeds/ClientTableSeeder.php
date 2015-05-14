<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ClientTableSeeder extends  Seeder{

    public function run()
    {
        Model::unguard();
        $apiKey = Str::random();
        $token = Str::random(16);
        $encryptedToken = Crypt::encrypt($token);

        \Delivered\Client::create([
            'clientName' => 'Wazaar',
            'contactNumber' => '000013140114011144',
            'websiteUrl' => 'wazaar.jp',
            'apiKey' => $apiKey,
            'accessToken' => Hash::make($token),
            'encryptedAccessToken' => $encryptedToken
        ]);
    }
}