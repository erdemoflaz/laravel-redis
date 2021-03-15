### Redis Database with Laravel 

Redis is an open source, advanced key-value store. It is often referred to as a data structure server since keys can contain strings, hashes, lists, sets, and sorted sets.

Before using Redis with Laravel, we encourage you to install and use the phpredis PHP extension via PECL. The extension is more complex to install compared to "user-land" PHP packages but may yield better performance for applications that make heavy use of Redis

### Usage

If you are unable to install the phpredis extension, you may install the predis/predis package via Composer. Predis is a Redis client written entirely in PHP and does not require any additional extensions:

```
composer require predis/predis
```

### In This Case

Basicly, we will do examples like SingIn, SingUp, Create and Listing.

### SignUp Endpoint

POST - http://localhost:8000/api/v1/user/signup

Request body;
```
{
    "username": "e2d3m",
    "password": "123"
}
```

### SignIn Endpoint

POST - http://localhost:8000/api/v1/user/signin

Request body;

```
{
    "username": "e2d3m",
    "password": "123"
}
```

### Match Endpoint

POST - http://localhost:8000/api/v1/endgame

Request body;

```
[
    {
        "user_id": 10,
        "score": 5
    },
    {
        "user_id": 20,
        "score": 7
    }
]
```


### LeaderBoard Endpoint

GET - http://localhost:8000/api/v1/leaderboard
