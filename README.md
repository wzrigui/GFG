## Local Setup

Clone and open the project in your IDE.
### Requirements
1. Docker/Docker Compose
2. Git client

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

Send a `POST` Request to `http://localhost:8080/products/findAll`

**_Find a Product with Id 1_**

Send a `POST` Request to `http://localhost:8080/products/findById/1`

**_Add New Product_**

Send a `POST` request to `http://localhost:8080/products/new`

Sample Request Body
```json
{
    "name": "Jeans",
    "brand": "LEVIS",
    "stock": "50"
}
```

**_Update a Product with Id 1_**

Send a `POST` request to `http://localhost:8080/products/updateById/1`

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

Send a `POST` request to `http://localhost:8080/products/deleteById/1`

If delete is successful `true` is returned in response, if failed then `false` is returned
