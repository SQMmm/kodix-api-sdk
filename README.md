# kodix-api-sdk
Kodix-api-sdk php client for working with kodix services api.

## Available scopes, entities and methods
  * DealerStorage - contains all data about dealer centeres. All entities have tha same methods (***getList***, ***get***, ***add***, ***update***, ***delete***):
    * dealerships
    * holdings
    * brands
  
### Authorization 
```php
$this->api = new Client();

// set login and pass for authorization (if token has expired)
$this->api->setAccessLogin($params['login']);
$this->api->setAccessPassword($params['password']);

//this callback function is used if token has expired
$this->api->setOnTokenExpiredFunction(function(Client $client) {
    $token = $client->auth();
    if($token){
        //you can save new token

        return true;
    }
    return false;
});

if(isset($params['token'])) {
    $this->api->setAccessToken($params['token']);

}else{
    $token = $this->api->auth();

    if($token){
        // save new token
    }
}
```

### Getting/updating data
```php
// Getting the list of dealerships with brand filtering by ids.
$dealerships = new Dealership($this->api);
$response = $dealerships->getList(['filter' => ['id' => $ids], 'with' => ['brand']]);
$statusCode = $response->getCode();
$errors = $response->getErrors();

if(is_array($errors) && count($errors) > 0 ){
    $items = [];
}else {
    $data = $response->getData();
    $items = $data['items'];
}

```

## Docs
* [Dealer storage documentation](https://kodixauto.atlassian.net/wiki/spaces/DIG/pages/188547201/Dealer.Storage)
