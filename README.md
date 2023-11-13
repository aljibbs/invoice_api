# Api Documentation

## Using the PHP laravel framework, design an invoicing REST Backend API.

-   **IMPORTANT**
    Run database seeder before proceeding to test to seed the database with predefined roles

    ```
    php artisan db:seed
    ```

-   **Endpoint Base Url: /api**

-   **Accept Header application/json**

## Get All Roles

-   **GET /roles**

## Create a new User

-   **POST /auth/register**

    -   Parameters

        ```
        email
        password
        password_confirmation
        role_id
        ```

## Log in User

-   **POST /auth/login**

    -   Parameters

        ```
        email
        password
        ```

## Logout User

-   **GET /auth/logout**

    -   Authorization Token

        ```
        Bearer {token}
        ```

## Get current User's Profile

-   **GET /me**

    -   Authorization Token

        ```
        Bearer {token}
        ```

## Create new product

-   **POST /products**

    -   Authorization Token

        ```
        Bearer {token}
        ```

    -   Parameters

        ```
        name
        quantity (optional)
        cost_price
        selling_price
        ```

## Get single product

-   **GET /products/{product_id}**

    -   Authorization Token

        ```
        Bearer {token}
        ```

## Get all products

-   **GET /products**

    -   Authorization Token

        ```
        Bearer {token}
        ```

## Update a product

-   **PUT /products/{product_id}**

    -   Authorization Token

        ```
        Bearer {token}
        ```

    -   Parameters (Atleast one parameter must be present)

        ```
        name (optional)
        quantity (optional)
        cost_price (optional)
        selling_price (optional)
        ```

## Add quantity to product stock

-   **POST /products/{product_id}/add_stock**

    -   Authorization Token

        ```
        Bearer {token}
        ```

    -   Parameters

        ```
        quantity
        ```

## Get all transactions

-   **GET /transactions**

    -   Authorization Token

        ```
        Bearer {token}
        ```

## Get a single transaction

-   **GET /transactions/{invoiceNumber}**

    -   Authorization Token

        ```
        Bearer {token}
        ```

## Create a new transaction

-   **POST /transactions**

    -   Authorization Token

        ```
        Bearer {token}
        ```

    -   Parameters

        ```
        customer_phone
        customer_name (optional)
        customer_address (optional)
        items (array) [ {product_id, quantity} ]
        ```

## License

The Invoice Api is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
