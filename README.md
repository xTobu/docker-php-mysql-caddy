# docker-php-mysql-caddy

## Dev
```bash
docker-compose up -d --build 
```

```bash
docker-compose stop <service> 
docker-compose rm <service> 
```

---

## Api Doc
#### [ Base URL: localhost:9000 ]

－

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
            "event": "Event",
            "session": "台中場",
            "job": "職稱",
            "dept": "所屬單位",
            "rocid": "A123456789",
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

－

### /api/postAttendee.php
> 新增參加者
#### Request
##### FormData
```js
{
    "event": "Event",
    "session": "台中場",
    "job": "職稱",
    "dept": "所屬單位",
    "rocid": "A123456789" || null,
    "name": "Freddy",
    "phone": "0900000000",
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
    "data": "Bad Request: Incomplete Request"
}
```

##### 400 場次錯誤（關閉或下線）
```js
{
    "status": 400,
    "data": "Bad Request: Error Session"
}
```

##### 409 重複資料
```js
{
    "status": 409,
    "data": "Conflict: Duplicate Data"
}
```
##### 500 伺服器錯誤
```js
{
    "status": 500,
    "data": <PDOException>
}
```

－

### /api/getSessions.php
> 取得場次狀態
#### Response
##### 200 Success
```js
{
    "status": 200,
    "data": [
        {
            "pkid": 1,
            "session": "總論壇",
            "limit": null,
            "status": 1, // 0: Off , 1: On
            "deleted_at": null,
            "updated_at": "2019-11-30 08:50:05",
            "created_at": "2019-11-30 08:48:50"
        }
    ]
}
```