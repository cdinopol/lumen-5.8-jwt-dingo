# Lumen 5.8 with JWTAuth & Dingo Boilerplate

Nothing fancy. Basic integration of [JWT Auth](https://github.com/tymondesigns/jwt-auth) and [Dingo API](https://github.com/dingo/api) into Lumen 5.8

## Quick Start

- Clone this repo or download it's release archive and extract it somewhere
- You may delete `.git` folder if you get this code via `git clone`

- Copy `.env.example` and rename to `.env`
    - setup your db (create your db first)
    - add the following at the bottom:
    ```
    API_PREFIX=api
    API_VERSION=v1
    ```

- Run `composer install`
- Run `php artisan key:generate`
- Run `php artisan jwt:secret`
- Run `php artisan migrate --seed`
- Run `php artisan serve`

# Test It! 
`Use postman to simplify your life.`

- Login

    POST: 

    ```
    http://localhost:8000/api/auth/login
    ```

    BODY form-data:

    ```
    email: admin@admin.com
    password: password
    ```

    Response:

    ```
      {"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9rdWxiYWhpbmFtLmxvY2FsXC9hcGlcL2F1dGhcL2xvZ2luIiwiaWF0IjoxNTYxMDAwNjQ2LCJleHAiOjE1NjEwMDQyNDYsIm5iZiI6MTU2MTAwMDY0NiwianRpIjoiOXFNQjlyV2R2S01pek9LQiIsInN1YiI6MSwicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.C5iQ98SOeqNn52bBjnkNQYQqzZuSByjzo3y6D1iEzfk"}
    ```

- Test Demo Function

    GET: 

    ```
    http://localhost:8000/api/user_test
    ```

    Authorization (Type: Bearer Token):
    
    ```
    use the token generated from logging in.
    ```

    Response: 
    
    ```
    {
        "message": "Good job! Good luck with your API!",
        "data": {
            "id": 1,
            "name": "admin",
            "email": "admin@admin.com",
            "role": 99,
            "created_at": "2019-06-20 06:52:17",
            "updated_at": "2019-06-20 06:52:17"
        }
    }
    ```

## License
```
Laravel and Lumen is a trademark of Taylor Otwell
Sean Tymon officially holds "Laravel JWT" license
```
