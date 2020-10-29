## GOALS
The Product Service is a REST API that provides endpoints to perform CRUD operations for products.
The [README.md](README.md) provides instructions to run the application in its current state.
This assignment has the following 3 goals:
1. **_Refactor_** - Improve current Code
2. **_Production Ready_** - Make the current code production ready
3. **_New Functionality_** - Add features to the product service

To achieve above goals the following 2 tasks must be completed.

### Task 1 - Refactor and Production Ready - First Version
> Create a new Branch `product_service-task-1` your `master` branch 

The current code has `violations` in the following areas
- _REST Usage_
- _API Documentation_
- _Test Coverage_
- _Violations of design principles or good practices_

> This is NOT an exhaustive list, there could be more you can identify during your analysis.

#### Your Task:
1. List all the **_violations_** you have noticed in [VIOLATIONS.md](VIOLATIONS.md) file.
2. **_Refactor_** the current code to fix ALL the violations you have listed in [VIOLATIONS.md](VIOLATIONS.md)
3. Make the code **_Production Ready_**.
4. This will be the **_first version_** of product-service. 

### Task 2 - New Features - Second Version
> Create a new Branch `product_service-task-2` from the `product_service-task-1` branch

While the **_first_** version is now in production, some clients have requested for 5 additional features. 
The **_first_** version should still be available for other clients along with the new version.

The 5 new features are as follows:

**1.** Ability to provide sorted results on any field

**2.** The response must provide a self link to the product and links for all available actions that can be performed on the product.
**_For example_**, current implementation with such links would look like the following:

Request - `http://localhost:8080/products/findById/1`
```json
{
    "id": 1,
    "uuid": "94d8899e-14a1-11eb-8584-0242ac130002",
    "name": "Pure Linen Plain Shirt",
    "brand": "Lois",
    "stock": 22,
    "_links": {
        "self": {
            "href": "http://localhost:8080/products/findById/1",
            "type": "POST"
        },
        "create": {
            "href": "http://localhost:8080/products/new",
            "type": "POST"
        },
        "update": {
            "href": "http://localhost:8080/products/updateById/1",
            "type": "POST"
        },
        "delete": {
            "href": "http://localhost:8080/products/deleteById/1",
            "type": "POST"
        }
    }
}    
```
> The links Url should vary depending upon the refactorings done in Task 1. The above links are only for representational purposes.

**3.** The API should offer paginated results when client sets a page size. The result should also contain pagination links. 

**_For example_**: 

Get All Products query with `size=2, page=0 and sort=brand in ascending order` should contain the pagination links similar to ones shown below

The Request : `http://localhost:8080/products/findAll?size=2&page=0&sort=brand`
 ```json
"_links": {
        "first": {
            "href": "http://localhost:8080/products/findAll?page=0&size=2&sort=brand,asc"
        },
        "self": {
            "href": "http://localhost:8080/products/findAll?page=0&size=2&sort=brand,asc"
        },
        "next": {
            "href": "http://localhost:8080/products/findAll?page=1&size=2&sort=brand,asc"
        },
        "last": {
            "href": "http://localhost:8080/products/findAll?page=1&size=2&sort=brand,asc"
        }
 },
 "page": {
    "size": 2,
    "totalElements": 3,
    "totalPages": 2,
    "number": 0
 }
```
> The links Url should vary depending upon the refactorings done in Task 1. The above links are only for representational purposes.

**4.** Search API for products.

The `product-service` should provide an API to Search a product using any of its fields, can also be more than 1 field.

For example -> `Name is jeans` and `brand is GAS`

The Search API result must containing sorting, pagination and other links mentioned above in #1, #2 and #3.
In other words, the Search API result should be exactly like find all case, only difference being that the products in the result will be filtered based on the search criteria.

**5.** Notifications by SMS

Currently, whenever a product gets its stock modified, an `email` is sent to the seller (via a mock email provider).
The application should incorporate the possibility to send these notifications via some alternative medium (e.g.: `SMS`). 
It should be also possible to set up the application to use both notifications mechanisms.

This completes the assignment. You should now have 2 branches with 'Task 1` and `Task 2` respectively, ready to Submit.

> Don't hesitate to use any code style and code quality validation tools, we would love to see them!

## Submit YOUR code

**_IMPORTANT_** : Don't apply any changes to this repository.

1. Clone this repository into you own private repository on github.

2. Create new branches (for `Task 1` and `Task 2` as indicated above) with your changes (_as many `commits` as you wish_). 

Please follow this naming convention for the branch name:

`{first name}_{last name}_task_{number}`

Give repository access to the person/s from our organization that you should have been indicated by now. 
Ask the Hiring Manager if you did not get them yet. (_Currently these would be `@javighrock`, `@fdiazarce`, `@nikhilvasaikar` and `@wolframite`_)

> Please grant "Admin" access to these users since they might need to grant access to some other colleagues in turn.

Notify the **_Hiring Manager_** when you are done and provide a `link` to your repository.

**_`Happy Coding !`_**
