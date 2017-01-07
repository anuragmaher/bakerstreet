# REST API for Baker Street Store

Welcome to the REST API for Baker Street! You can use our API to create view and edit products on Baker Street Online Store.
Baker Street is inspired from Sherlock Homes :) 


Baker Street API is built using REST principles and without any framework in mind. This API follows HTTP rules, enabling a wide range of HTTP clients can be used to interact with the API.

URL is https://bakerstreetwala.heroku.com *I could not get bakerstreet on heroku*


## Getting Started
All Baker Street API calls requires a minimum of one mandatory header.

```
Authorization token - Authentication request header.
```
   
## Authentication
All Baker Street API calls need to be authenticated using an authtoken.

You can obtain an authtoken by the following way:

Submit an HTTP POST request to the below URL.

https://bakerstreetwala.herokuapp.com/authtoken/create.

Below are the mandatory case sensitive fields to be passed in POST request. 

Example: 

parameter     | value
------------- | -------------
username      | admin
password      | admin


Return value will be like 

```
{
    "error": null,
    "content": {
        "expires": 1408109484,       // yet to be implemented
        "token": "633uq4t0ee23dsfd1mdllnv2h1vs32"
    }
}
```
**TODO: expires is not implemented yet**

###Example
```
POST /authtoken/create HTTP/1.1
Host: bakerstreetwala.herokuapp.com
Cache-Control: no-cache
Content-Type: multipart/form-data; boundary=----DATA

------DATA
Content-Disposition: form-data; name="username"

admin
------DATA
Content-Disposition: form-data; name="password"

admin
------DATA
Content-Disposition: form-data; name=""

```


###POINTS TO NOTE

1) every time you create a new token, previous token will be invalidated. 

2) token response will have a expiry time for the token, after which you will have to re generate the token.

3) all requests should have token as authentication field. 


## HTTP Methods
Baker Street API uses appropriate HTTP verbs for every action.

Method        |    Description
------------- |    -------------
GET           |    Used for retrieving resources and SEARCHing through records.
POST          |    Used for creating resources and performing resource actions
PUT           |    Used for updating resources.
DELETE        |    Used for deleting resources.



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


Status Code        | Description
------------- | -------------
200 | OK
201 | CREATED
400 | Bad request   
401 | Unauthorized (Invalid AuthToken)
404 | URL Not Found
405 | Method Not Allowed (Method you have called is not supported for the invoked API)
500 | Internal Error


## Products 
A product refers to the item present in the Baker Street Store. 

### ATTRIBUTES

Attribute        | type
-----------------| --------------
id               | **string** - unique id generated by the server for the product
name             | **string** - name of the product 
description      | **string** - description for the product 
status           | **string** - If a product is active 
created_at       | **date**   - Unixdate time format 
updated_at       | **data**   - Last time when product was updated  

### Example
```
{
  "id": "1",
  "name": "Cake",
  "description": "Eggless Dark Choclate",
  "status": "active",
  "created_time": "2016-06-05T17:38:06-0700",
  "updated_time": "2016-06-05T20:09:23-0700"
}
```

### Create a product
Creating a product 

```
POST /products
```

POST attributes: 

Attribute        | type
-----------------| --------------
name             | **string** - name of the product 
description      | **string** - description for the product 

#### Example: 

```
POST /products HTTP/1.1
Host: bakerstreetwala.herokuapp.com
authtoken: 586fcd5e3315d
Cache-Control: no-cache
Content-Type: multipart/form-data; boundary=----DATA

------DATA
Content-Disposition: form-data; name="name"

Cake
------DATA
Content-Disposition: form-data; name="description"

Eggless Dark Choclate
------DATA--
```
**NOTE** : name and description are required fields

###Response
```
{
   "product": 
   {
	  "id": "1",
	  "name": "Cake",
	  "description": "Eggless Dark Choclate",
	  "status": "active",
	  "created_time": "2016-06-05T17:38:06-0700",
	  "updated_time": "2016-06-05T20:09:23-0700"
   }
}
```


### Listing all the products

```
GET /products
```

####Response
```
{
   "products": 
   [
   {
	  "id": "1",
	  "name": "Cake",
	  "description": "Eggless Dark Choclate",
	  "status": "active",
	  "created_time": "2016-06-05T17:38:06-0700",
	  "updated_time": "2016-06-05T20:09:23-0700"
   },
   {
   	  "id": "2",
	  "name": "Cake new one",
	  "description": "Eggless Dark Choclate",
	  "status": "active",
	  "created_time": "2016-06-05T17:38:06-0700",
	  "updated_time": "2016-06-05T20:09:23-0700"
    }
   ]
}
```

#### Example:
```
GET /products HTTP/1.1
Host: bakerstreetwala.herokuapp.com
authtoken: 58707bf7b4132
Cache-Control: no-cache

```


### Delete 

```
DELETE /products/1
```


```
DELETE /products/10 HTTP/1.1
Host: bakerstreetwala.herokuapp.com
authtoken: 58707e2008771
Cache-Control: no-cache
Content-Type: multipart/form-data; boundary=----DATA


```

####Response
```
{
    "status":"done"
}
```


### Edit the product 

```
PUT /products/1
```


```
PUT /products/1 HTTP/1.1
Host: bakerstreetwala.herokuapp.com
authtoken: 58707e2008771
Content-Type: application/x-www-form-urlencoded
Cache-Control: no-cache

name=latest+cake+12&description=new+cake&status=deleted
```

**NOTE** : name and description are required fields

#### Response
```
{
   "product": 
   {
	  "id": "1",
	  "name": "latest cake",
	  "description": "new cake",
	  "status": "active",
	  "created_time": "2016-06-05T17:38:06-0700",
	  "updated_time": "2016-06-05T20:09:23-0700"
   }
}
```

### Search 

```
GET /products?name=cake
```

#### Example

```
GET /products?name=cake HTTP/1.1
Host: bakerstreetwala.herokuapp.com
authtoken: 58707bf7b4132
Cache-Control: no-cache
```

#### Response
```
{
   "products": 
   {
	  "id": "1",
	  "name": "latest cake",
	  "description": "new cake",
	  "status": "active",
	  "created_time": "2016-06-05T17:38:06-0700",
	  "updated_time": "2016-06-05T20:09:23-0700"
   }
}
```


## Deploying

Install the [Heroku Toolbelt](https://toolbelt.heroku.com/).

```sh
$ git clone git@github.com:anuragmaher/bakerstreet.git # or clone your own fork
$ cd bakerstreet
$ heroku create
$ git push heroku master
$ heroku open
```

## Testing

```
http://bakerstreetwala.herokuapp.com/tests/auth
```