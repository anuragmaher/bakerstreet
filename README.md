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
    "content": {
        "token": "58712b8969a5a"
    }
}
```

###Example
```
curl -i "https://bakerstreetwala.herokuapp.com/authtoken/create"\
	  -d "username=admin&password=admin"
```


###POINTS TO NOTE

1) every time you create a new token, previous token will be invalidated. 

2) all requests should have token as authentication field. 


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
curl -i "https://bakerstreetwala.herokuapp.com/products"\
	  -d "name=cake&description=test"\
	  -H "authtoken: 58712b8969a5a"
```
**NOTE** : name and description are required fields

###Response
```
HTTP/1.1 200 OK
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

### Get a Product 
```
GET /products/{productid}
```

#### Example
```
curl -i "https://bakerstreetwala.herokuapp.com/products/1" \
	  -H "authtoken: 58712b8969a5a"
```
###Response
HTTP/1.1 200 OK
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

#### Example
```
curl -i "https://bakerstreetwala.herokuapp.com/products" \
	  -H "authtoken: 58712b8969a5a"
```

#### Response
```
HTTP/1.1 200 OK
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

### Edit the product 

```
PUT /products/{productid}
```

```
curl -i "https://bakerstreetwala.herokuapp.com/products/1"\
	  -X "PUT" \
	  -d "name=newname&description=new+description&status=deleted"\
	  -H "authtoken: 58712b8969a5a"
```

**NOTE : name and description are required fields**

#### Response
```
HTTP/1.1 200 OK
{
   "product": 
   {
	  "id": "1",
	  "name": "newname",
	  "description": "new description",
	  "status": "deleted",
	  "created_time": "2016-06-05T17:38:06-0700",
	  "updated_time": "2016-06-05T20:09:23-0700"
   }
}
```

### Delete 

```
DELETE /products/1
```

#### Example

```
curl -i "https://bakerstreetwala.herokuapp.com/products/19" \
     -X "DELETE" \
	  -H "authtoken: 58712b8969a5a"

```

#### Response
```
HTTP/1.1 200 OK
{
    "status":"done"
}
```


### Search 

```
GET /products?name=cake
```

#### Example

```
curl -i "https://bakerstreetwala.herokuapp.com/products?name=latest" \
	  -H "authtoken: 58712b8969a5a"
```

**Note: Currently search is available for name only**

#### Response
```
HTTP/1.1 200 OK
{
   "products": 
   {
	  "id": "20",
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

**Get the code from GitHub**

```
$ git clone https://github.com/anuragmaher/bakerstreet.git # or clone your own fork
$ cd bakerstreet
```
**Heroku login and creating an app**

```
$ heroku login
$ heroku create herokuappname
```
**Now create a mysql instance**

```
$ heroku addons:create cleardb:ignite
```

**Make sure CLEARDB_DATABASE_URL ENV is set to the mysql URI** 

**Adding heroku as remote for pushing and deploying**

```
$ heroku git:remote -a herokuappname
```
**Pushing code to heroku directory**

```
$ git push heroku master
```

**Running Database migrations, creating of tables and creating admin user**

```
$ heroku open migrate/db

```

## Executing Test cases 

```
$ heroku open tests/start
```

### Sample Test Cases Execution

####Automated Testing

###Test Cases for Authentication: 
***

**Test 1- username**: usernotpresent and password: junk 

*Test case passed*

**Test 2- username**: admin and password: junk 

*Test case passed*

**Test 3- username**: admin and password: admin 

*Test case passed*

**All tests for authtication passed New Token: 587280c834e05**

Now all the tests will use this token : 587280c834e05 for authentication

**Test 4** : Get products without authtication GET /products 

*Test case passed*

**Test 5** : Get products without authtication GET /products and token

*Test case passed*

**Test 6** : Get products without authtication GET /products and token: 587280c834e05 

*Test case passed*


###Test Cases for Products: 
***

**Test 7** : POST /products with token and name and description 
Product created with id: 2 

*Test case passed*

**Test 8** : GET /products/2 with token and productid 
Product created with id: 2

*Test case passed*

**Test 9** : PUT /products/2 with token and name and description 

*Test case passed*


**Test 10** : DELETE /products/2 with token 

*Test case passed*


"All Tests Passed"