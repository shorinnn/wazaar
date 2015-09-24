<?php

class DeliveredHelper
{

    protected $endpoint = '';
    protected $curl;

    public function __construct()
    {

    }

    /**
     * Request to process an email
     * @param string $requestType - immediate, sequence
     * @param integer|null $templateId - The ID of an existing template to use for this email
     * @param integer|null $userId - The User ID of an existing user to receive this email
     * @param string(json) $variables - The JSON representation of the variables to replace placeholders on a template
     * @param string(json) $template - The JSON representation of the Template model(see addTemplate method parameters)
     * @param string(json) $user - The JSON representation of a User model (see addUser method parameters)
     * @return mixed|null
     */
    public function executeEmailRequest($requestType, $templateId = null, $userId = null, $variables = '', $template = '', $user = '')
    {
        $call = $this->_call('email-requests/create',compact('requestType', 'templateId','userId', 'variables', 'template', 'user'));
        return $call;
    }

    /**
     * Get all templates associated to the client
     * @return mixed|null
     */
    public function getTemplates()
    {
        $call = $this->_call('templates',[],'get');
        return $call;
    }

    /**
     * Add an email template
     * @param $templateName
     * @param $subject
     * @param $fromName
     * @param $fromAddress
     * @param $body
     * @return mixed|null
     */
    public function addTemplate($templateName,$subject,$fromName,$fromAddress,$body)
    {
        $call = $this->_call('templates', compact('templateName','subject','fromName','fromAddress','body'));
        return $call;
    }

    /**
     * Update an email template
     * @param $id
     * @param $templateName
     * @param $subject
     * @param $fromName
     * @param $fromAddress
     * @param $body
     * @return mixed|null
     */
    public function updateTemplate($id,$templateName,$subject,$fromName,$fromAddress,$body)
    {
        $call = $this->_call('templates/' . $id, compact('templateName','subject','fromName','fromAddress','body'),'put');
        return $call;
    }

    /** Delete an email template
     * @param $id
     * @return mixed|null
     */
    public function deleteTemplate($id)
    {
        $call = $this->_call('templates/' . $id,[], 'delete');
        return $call;
    }
    
    /**
     * Get all users associated to the client
     * @return mixed|null
     */
    public function getUsers()
    {
        $call = $this->_call('users',[],'get');
        return $call;
    }

    /**
     * @param array $tagNames
     * @return mixed|null
     */
    public function getUsersByTagNames($tagNames = [])
    {
        $call = $this->_call('users/find-by-tag-names',compact('tagNames'));
        return $call;
    }

    /**
     * @param array $tags
     * @return mixed|null
     */
    public function getUsersByTags($tags = [])
    {
        $call = $this->_call('users/find-by-tags',compact('tags'),'post');
        return $call;
    }

    /**
     * Add a user under a client
     * @param $firstName
     * @param $lastName
     * @param $email
     * @return mixed|null
     */
    public function addUser($firstName, $lastName, $email)
    {
        $call = $this->_call('users', compact('firstName', 'lastName', 'email'));
        return $call;
    }

    /**
     * @param $usersJson
     * @return mixed|null
     */
    public function addBatchUsers($usersJson)
    {
        $call = $this->_call('users/batch', ['users' => $usersJson]);
        return $call;
    }
    /**
     * Update User
     * @param $id
     * @param $firstName
     * @param $lastName
     * @param $email
     * @return mixed|null
     */

    public function updateUser($id, $firstName, $lastName, $email)
    {
        $call = $this->_call('users/' . $id, compact('firstName', 'lastName', 'email'),'put');
        return $call;
    }

    /**
     * Delete User
     * @param $id
     * @return mixed|null
     */
    public function deleteUser($id)
    {
        $call = $this->_call('users/' . $id,[], 'delete');
        return $call;
    }

    public function findUser($keyword)
    {
        $call = $this->_call('users/find',compact('keyword'));
        return $call;
    }

    /**
     * Assign tag to a user
     * @param $tagName
     * @param $tagType
     * @param $tagValue
     * @param $userId
     * @return mixed|null
     */
    public function addTag($tagName, $tagType, $tagValue, $userId)
    {
        $call = $this->_call('tags',compact('tagName', 'tagType', 'tagValue', 'userId'));
        return $call;
    }

    /**
     * @param $id
     * @param $userId
     * @param $tagName
     * @param $tagType
     * @param $tagValue
     * @return mixed|null
     */

    public function updateTag($id, $userId, $tagName, $tagType, $tagValue)
    {
        $call = $this->_call('tags/' . $id,compact('tagName', 'tagType', 'tagValue', 'userId'),'put');
        return $call;
    }

    public function deleteTag($id)
    {
        $call = $this->_call('tags/' . $id,[],'delete');
        return $call;
    }

    /**
     * Add a List or Group
     * @param $groupName
     * @param $groupDescription
     * @return mixed|null
     */
    public function addList($groupName, $groupDescription)
    {
        $call = $this->_call('lists',compact('groupName', 'groupDescription'));
        return $call;
    }
    
    /**
     * Get all lists associated to the client
     * @return mixed|null
     */
    public function getLists()
    {
        $call = $this->_call('lists',[],'get');
        return $call;
    }

    /**
     * Assign a set of users(ID) or a user to a list
     * @param $listId
     * @param array $userIds
     * @return mixed|null
     */
    public function addUsersToList($listId, $userIds = [])
    {
        $userIds = json_encode($userIds);
        $call = $this->_call('lists/users',compact('listId', 'userIds'));
        return $call;
    }

    /**
     * Execute CURL request to delivered API
     * @param $uri
     * @param array $params
     * @param string $method
     * @return mixed|null
     */
    private function _call($uri, $params = [], $method = 'post')
    {
        $key   = Config::get('wazaar.DELIVERED_API_KEY','U1527uCqeGUJdRF8');
        $token = Config::get('wazaar.DELIVERED_TOKEN','eyJpdiI6IndRR1JcL2FkUzVEUk1nWWxoYjEzWEFnPT0iLCJ2YWx1ZSI6IngzTnRhZEpsTWZrVTMreTNiaHY2bE8yZFhjR2NmZ3JCc29ySXkyM3FDblU9IiwibWFjIjoiODY0NDQzMzgwYjg3NWEwNWI3YjI2ZTI3YjdjNzFiNGIyOGQ2NmNhMTgzM2YxMTQyM2ViNWVhMWRhYjVlMTgxZSJ9');
        $endpoint = trim(Config::get('wazaar.DELIVERED_ENDPOINT','http://delivered.cocorium.com/api'));
        $curl = new \anlutro\cURL\cURL();


        $url = $curl->buildUrl($endpoint . '/' . $uri,['apiKey' => $key, 'token' => $token]);

        $request = null;

        switch ($method){
            case 'post' : $request = $curl->post($url,$params);break;
            case 'get'  : $request = $curl->get($url);break;
            case 'put'  : $request = $curl->put($url, $params);break;
            case 'delete' : $request = $curl->delete($url);break;
        }

        if ($request){ 
            return json_decode($request->body,true);
        }

        return null;
    }
}