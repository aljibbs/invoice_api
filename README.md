<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Api Documentation

Using the PHP laravel framework, design an invoicing REST Backend
API.

-   **Endpoint Base Url: /api**

-   **Accept Header application/json**

-   **POST /auth/register**

    -   Parameters

    ```
    - email,
    - password,
    - password_confirmation,
    ```

-   **POST /auth/login**

    -   Parameters

        `-   email`
        `-   password`

-   **GET /auth/logout**

    -   Authorization Token
        -   Bearer {token}

-   **GET /me (Get current User's Profile)**

    -   Authorization Token
        -   Bearer {token}

-   **POST /products (Create new product)**

    -   Authorization Token

        -   Bearer {token}

    -   Parameters
        -   name
        -   quantity (optional)
        -   cost_price
        -   selling_price

-   **GET /products/{product_id} (Get product)**

    -   Authorization Token
        -   Bearer {token}

-   **GET /products (Get all products)**

    -   Authorization Token
        -   Bearer {token}

-   **PUT /products/{product_id} (Update product)**

    -   Authorization Token

        -   Bearer {token}

    -   Parameters (Atleast one parameter must be present)
        -   name (optional)
        -   quantity (optional)
        -   cost_price (optional)
        -   selling_price (optional)

-   **POST /products/{product_id}/add_stock (Add new stock quantity)**

    -   Authorization Token

        -   Bearer {token}

    -   Parameters
        -   quantity

## License

The Invoice Api is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
