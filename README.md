# REST API for Baker Street

Welcome to the REST API for Baker Street! You can use our API to create view and edit products on Baker Street Online Store.
Baker Street is inspired from Sherlock Homes :) 


Baker Street API is built using REST principles. This API follows HTTP rules, enabling a wide range of HTTP clients can be used to interact with the API.

## Getting Started
All Baker Street API calls requires a minimum of one mandatory header.

```
Authorization - Authentication request header.
```
    
$URL = "bakerstreetwala"; // I could not get bakerstreet on heroku

## Authentication
All Baker Street API calls need to be authenticated using an authtoken.

You can obtain an authtoken by the following way:

Submit an HTTP POST request to the below URL.

https://bakerstreetwala.herokuapp.com/authtoken/create.

The POST body should include a string in the below format.

?username=[username]&password=[password]

Below are the mandatory case sensitive fields to be passed in the URL. Example is mentioned below
```
?username=admin&password=admin
```
Return value will be like 
```
{
    "error": null,
    "content": {
        "expires": 1408109484,
        "token": "633uq4t0qdtd1mdllnv2h1vs32"
    }
}
```

###POINTS TO NOTE

1) every time you create a new token, previous token will be invalidated. 
2) token response will have a expiry time for the token, after which you will have to re generate the token.
3) all requests should have token as authentication field. 


## HTTP Methods
Baker Street API uses appropriate HTTP verbs for every action.

```
GET     -   Used for retrieving resources.
POST    -   Used for creating resources and performing resource actions.
PUT     -   Used for updating resources.
DELETE  -   Used for deleting resources.
```

## DATE
All timestamps are returned in the ISO 8601 format - YYYY-MM-DDThh:mm:ssTZD.
```
Example: 2016-06-11T17:38:06-0700
```

## Errors
Baker Street API uses HTTP status codes to indicate success or failure of an API call. In general, 
status codes in the 2xx range means success, 
4xx range means there was an error in the provided information, and 
those in the 5xx range indicates server side errors. Commonly used HTTP status codes are listed below.

200 - OK
201 - CREATED
400 - Bad request
401 - Unauthorized (Invalid AuthToken)
404 - URL Not Found
405 - Method Not Allowed (Method you have called is not supported for the invoked API)
500 - Internal Error

## Products
A product refers to the item present in the Baker Street Store. 

### ATTRIBUTES

### Example
```
{
  "product_id": "1",
  "name": "Cake",
  "description": "Eggless Dark Choclate",
  "status": "active",
  "created_time": "2016-06-05T17:38:06-0700",
  "updated_time": "2016-06-05T20:09:23-0700"
}
```

### Create a product
```
POST /products
```

ARGUMENTS: 
name (* * required *)
description (* * required *)

### Get all the products
```
GET /products
```

## Deploying

Install the [Heroku Toolbelt](https://toolbelt.heroku.com/).

```sh
$ git clone git@github.com:heroku/php-getting-started.git # or clone your own fork
$ cd php-getting-started
$ heroku create
$ git push heroku master
$ heroku open
```

or

## Documentation
