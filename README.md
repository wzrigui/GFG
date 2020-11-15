

### How to Run?

The fast way to run the service is by executing ``install_server.sh`` script from root folder of the repository:
```
./install_server.sh
```
> If you get the error `Can't connect to local MySQL server through socket` just run manually the db setup from in `install_server.sh` 

### How to destroy it?
```
./destroy_server.sh
```

The Product Service is now ready to receive API requests.

## REST API Documentation for Products
**_Find All Products_** 

Send a `GET` Request to `http://localhost:8080/products`

**_Find a Product with Id 1_**

Send a `GET` Request to `http://localhost:8080/products/1`

**_Add New Product_**

Send a `POST` request to `http://localhost:8080/products`

Sample Request Body
```json
{
    "name": "Jeans",
    "brand": "LEVIS",
    "stock": "50"
}
```

**_Update a Product with Id 1_**

Send a `PUT` request to `http://localhost:8080/products/1`

Sample Request Body
```json
{
    "brand": "Lois",
    "stock": "22"
}
```
Response
```json
{
    "id": 2,
    "uuid": "94d8899e-14a1-11eb-8584-0242ac130002",
    "name": "Pure Linen Plain Shirt",
    "brand": "Lois",
    "stock": 22
}
```

**_Delete a Product with Id 1_**

Send a `DELETE` request to `http://localhost:8080/products/1`

If delete is successful `true` is returned in response, if failed then `false` is returned

**Sorting&Pagination**

The Request : `http://localhost:8080/products?size=2&page=0&sort=brand`
Response
 ```json
"_links": {
        "first": {
            "href": "http://localhost:8080/products?page=0&size=2&sort=brand,asc"
        },
        "self": {
            "href": "http://localhost:8080/products?page=0&size=2&sort=brand,asc"
        },
        "next": {
            "href": "http://localhost:8080/products?page=1&size=2&sort=brand,asc"
        },
        "last": {
            "href": "http://localhost:8080/products?page=1&size=2&sort=brand,asc"
        }
 },
 "page": {
    "size": 2,
    "totalElements": 3,
    "totalPages": 2,
    "number": 0
 }
```
