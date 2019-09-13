# docker-php-mysql-caddy

## Dev
```bash
docker-compose up -d --build 
```

```bash
docker-compose stop <service> 
docker-compose rm <service> 
```

## Api Doc

### /api/getAttendees.php
> 取得所有參加者

#### Response
##### 200 Success
```js
{
    "status": 200,
    "data": [
        {
            "pkid": 1,
            "event": "下午茶大會",
            "session": "胡椒餅",
            "name": "俊翔",
            "phone": "0988123456",
            "email": "jx@domain.tw",
            "status": 1,
            "deleted_at": null,
            "updated_at": "2019-09-13 03:45:26"
        },
        ...
    ]
}
```

### /api/postAttendee.php
> 新增參加者
#### Request
##### FormData
```js
{
    "event": "下午茶大會"
    "session": "牛肚包場次"
    "name": "Freddy"
    "phone": "0900000000"
    "email": "pan@domain.tw"
}
```
#### Response
##### 200 Success
```js
{
    "status": 200,
    "data": "Success"
}
```
##### 400 資料不完整
```js
{
    "status": 400,
    "data": "Incomplete Request"
}
```
##### 500 伺服器錯誤
```js
{
    "status": 500,
    "data": <PDOException>
}
```
