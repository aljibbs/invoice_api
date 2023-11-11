<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Invoice Api

Using the PHP laravel framework, design an invoicing REST Backend
API.

### Api Documentation

-   **Endpoint Base Url: /api**

-   **Accept Header application/json**

-   **POST /auth/register**

    -   Parameters
        -   email
        -   password
        -   password_confirmation

-   **POST /auth/login**

    -   Parameters
        -   email
        -   password

-   **GET /auth/logout**

    -   Authorization Token
        -   Bearer {token}

-   **GET /me (Get current User's Profile)**
    -   Authorization Token
        -   Bearer {token}

## License

The Invoice Api is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
