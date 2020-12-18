LUMEN API BOILERPLATE WITH JWT + DINGO (DOCKERIZED)
============================================

## Start

### 1. You may want to delete .git folder if you get this code via git clone
### 2. Copy .env.example and rename to .env, then update values necessary
### 3. Run and build docker
```sh
cd ~/lumen-jwt-dingo/
docker-compose up --build
```

---

## Test

#### 1. Register
```sh
curl --location --request POST 'http://localhost:8080/api/users' \
--header 'Content-Type: application/json' \
--data-raw '{
    "email": "admin@email.com",
    "password": "password",
    "name": "admin"
}'
```

- Response:
```
Code: 201
Content:
registration success
```

#### 2. Login
```sh
curl --location --request POST 'http://localhost:8080/api/auth/login' \
--header 'Content-Type: application/json' \
--data-raw '{
    "email": "admin@admin.com",
    "password": "password"
}'
```

- Response:
```
Code: 200
Content:
{
    "access_token": "<token string>",
    "expires_in_epoch": <timestamp>,
    "expires_in_iso": "<datetime iso>"
}
```

#### 3. Demo Function (open - no auth)
```sh
curl --location --request GET 'http://localhost:8080/api/users'
```

- Response:
```
Code: 200
Content:
[
    {<user object>}
]
```

#### 4. Demo Function (auth - token required)
```sh
curl --location --request GET 'http://localhost:8080/api/auth/me' \
--header 'Authorization: Bearer <token string>'
```

- Response:
```
Code: 200
Content:
{<user object>}
```

---

## Credits
[Lumen](https://github.com/laravel/lumen) is a trademark of Taylor Otwell
Sean Tymon officially holds ["JWT Auth"](https://github.com/tymondesigns/jwt-auth/) license
Jason Lewis officially holds ["Dingo API"](https://github.com/dingo/api) license

---

## License
This package is licensed under the [BSD 3-Clause license](https://opensource.org/licenses/BSD-3-Clause).
