<?php namespace Delivered\Helpers;

class ClientAuthHelper {

    protected $client;

    public function __construct()
    {
        $this->client = app()->make('Delivered\Repositories\Client\ClientInterface');
    }

    public function authenticate($apiKey, $token)
    {
        try{
            $decryptedToken = \Crypt::decrypt($token);
            $client = $this->client->getByAPIKey($apiKey);

            if ($client){
                if (!\Hash::check($decryptedToken,$client->accessToken)){
                    return 'Invalid Access Token';
                }
            }
            else{
                return 'Invalid API Key';
            }

            return true;
        }
        catch(\Exception $ex){
            return $ex->getMessage();
        }


    }

}