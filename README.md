
# Simple Google Authentication

This is a Laravel project used to allow the users to login with their google account

# Requirements

- PHP `>= 8.1.0`
- MySQL `>=5.7`
- Composer installed
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension



## Installation

Install the project

```bash
  git clone https://github.com/mr-deveoper/auth-app.git
```

Go to the project directory

```bash
  cd auth-app
```

Install dependencies

```bash
  composer install
```

Activate Environment File

```bash
  cp .env.example .env
  php artisan key:generate
```

Add your DB variables in env

```bash
  change DB_CONNECTION , DB_DATABASE , DB_USERNAME , DB_PASSWORD 
```

Add your google project credintials in env

```bash
  add GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET with google project data
  change APP_URL to website url or local url 
```

Import tables

```bash
  php artisan migrate 
```

## Deployment

To deploy this project run

```bash
  php artisan serv
```

Broswe the frontend views on

```bash
  http://127.0.0.1:8000
```

## Screenshots for Frontend view

![App Screenshot](https://i.ibb.co/wcDTj8w/image.png)

![App Screenshot](https://i.ibb.co/Cs94kJn/image.png)
