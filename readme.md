WEB API USING DOCKERIZED LUMEN + JWT & DINGO
============================================

# 1. Installations

### 1. Setup Server (Ubuntu 18+)
- Install minimum dependencies
```sh
sudo apt-get update && sudo apt-get upgrade -y
sudo apt-get install -y apache2 git tmux
```

### 2. Download project repo
```sh
cd ~/
git clone git@github.com:cdinopol/lumen-5.8-jwt-dingo.git
```

### 3. Install Docker (Linux)
```sh
cd ~/lumen-5.8-jwt-dingo/scripts
./docker_install.sh
```

---

# 2. Start

### 1. You may want to delete .git folder if you get this code via git clone
### 2. Setup your database
### 3. Copy .env.example and rename to .env
```
DB_CONNECTION=mysql
DB_HOST=your.db.host
DB_PORT=3306
DB_DATABASE=database
DB_USERNAME=username
DB_PASSWORD=password
```

### 4. Build
```sh
cd ~/lumen-5.8-jwt-dingo/
docker-compose build
```

### 5. Run
```sh
cd ~/lumen-5.8-jwt-dingo/
docker-compose up
```

- to start (tmux)
```sh
cd ~/lumen-5.8-jwt-dingo/scripts/
tmux_start.sh
```

- to stop (tmux)
```sh
cd ~/lumen-5.8-jwt-dingo/scripts/
tmux_stop.sh
```

---

# 3. Test It!
`Use postman to simplify your life.`


### 1. Register
- Post: 
```
http://localhost:8000/api/auth/register
```

- Body form-data:
```
email: admin@admin.com
password: password
```

- Response:
```
Code: 201
Content:
registration success
```

### 1. Login
- Post: 
```
http://localhost:8000/api/auth/login
```

- Body form-data:
```
email: admin@admin.com
password: password
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
- Get: 
```
http://localhost:8080/api/user/list
```

- Response:
```
Code: 200
Content:
[
    {
        "email": "admin@admin.com",
        "password": "password"
    }
]
```

### 4. Demo Function (auth - token required)
- Get: 
```
http://localhost:8080/api/user/me
```

- Authorization: Bearer {token}
```
use the token generated from logging in.
```

- Response:
```
Code: 200
Content:
{
    "email": "admin@admin.com",
    "password": "password"
}
```

---

## License
```
Laravel and Lumen is a trademark of Taylor Otwell
Sean Tymon officially holds "Laravel JWT" license
```

