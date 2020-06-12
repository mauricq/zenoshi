# Zenoshi Api
REST application for Zenoshi.

## Installation

Use the console and run next commands.

* Download libraries
```bash
composer install
```

* Run migration files
```bash
php bin/console doctrine:migrations:migrate
```

* Run specific migration file
```bash
php bin/console doctrine:migrations:migrate 20200504231536
```

* Run AppFixtures
```bash
php bin/console doctrine:fixtures:load
```

* Run server
```bash
symfony server:start
```


## JWT - Json Web Token
End point

```bash
{{url}}/auth/token
http://127.0.0.1:8000/auth/token
```

Make requests using next json body input

```bash
{
	"username": "admin",
	"password": "S>hh1:[3YQ)1Tq#"
}
```
