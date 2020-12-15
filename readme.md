LARAVEL LUMEN WITH JWT + DINGO (DOCKERIZED)
============================================

# 1. Installation

### 1. Setup Server (Ubuntu 18+)
- Install minimum dependencies
```sh
sudo apt-get update && sudo apt-get upgrade -y
sudo apt-get install -y apache2 git tmux
```

### 2. Download project repo
```sh
cd ~/
git clone git@github.com:cdinopol/lumen-jwt-dingo.git
```

### 3. Install Docker (Linux)
```sh
cd ~/lumen-jwt-dingo/scripts
./docker_install.sh
```

---

# 2. Start

### 1. You may want to delete .git folder if you get this code via git clone
### 2. Copy .env.example and rename to .env, then update values necessary
### 3. Run and build docker
```sh
cd ~/lumen-jwt-dingo/
docker-compose up --build
```

---

# 3. Test

### 1. Register
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

### 1. Login
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
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODA4MFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTU5ODQzMDExMSwiZXhwIjoxNTk4NDMzNzExLCJuYmYiOjE1OTg0MzAxMTEsImp0aSI6IjVaUkxaVkJYd2x6UkZvdXUiLCJzdWIiOjIwMDAwMTgsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.iDln2EULa3i1Mz_BPFq9d0dueJ9rW3qScMZzv-1YgKw",
    "expires_in_epoch": 1598433711,
    "expires_in_iso": "2020-08-26T09:21:51+0000"
}
```

### 3. Demo Function (open - no auth)
```sh
curl --location --request GET 'http://localhost:8080/api/users'
```

- Response:
```
Code: 200
Content:
[
    {
        "id": 1,
        "email": "admin@admin.com",
        "name": "admin",
        "role": 1,
        "created_at": "2020-11-26T07:35:58.000000Z",
        "updated_at": "2020-11-26T07:35:58.000000Z"
    }
]
```

### 4. Demo Function (auth - token required)
```sh
curl --location --request GET 'http://localhost:8080/api/auth/me' \
--header ': ' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODA4MFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTU5ODQzMDExMSwiZXhwIjoxNTk4NDMzNzExLCJuYmYiOjE1OTg0MzAxMTEsImp0aSI6IjVaUkxaVkJYd2x6UkZvdXUiLCJzdWIiOjIwMDAwMTgsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.iDln2EULa3i1Mz_BPFq9d0dueJ9rW3qScMZzv-1YgKw'
```

- Response:
```
Code: 200
Content:
{
    "id": 1,
    "email": "admin@admin.com",
    "name": "admin",
    "role": 1,
    "created_at": "2020-11-26T07:35:58.000000Z",
    "updated_at": "2020-11-26T07:35:58.000000Z"
}
```

---

## License
```
Laravel and Lumen is a trademark of Taylor Otwell
Sean Tymon officially holds "Laravel JWT" license
```
