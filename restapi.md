**1. Возвращает все посты**<br>
**Url:** /api/posts
<br>**Request-type:** GET
<br>**Response-type:** json
<br>**Response:**
```json  
{
    "id": "id поста (integer)",
    "name": "Название поста (string)",
    "text": "Текст поста (text)",
    "image": "Изображение (string)",
    "published_at": {
        "date": "Дата публикации комментарий (DateTime)",
        "timezone_type": 3,
        "timezone": "UTC"
    },
    "author_id": "id автора поста (integer)",
    "author_username": "Имя автора поста (string)",
    "author_email": "Email автора поста (string)"
}
```
**2. Возвращает конкретный пост по id**<br>
**id :** id поста
<br>**Url:** /api/post/{id}
<br>**Request-type:** GET
<br>**Response-type:** json
<br>**Response:**
```json  
{
    "id": "id поста (integer)",
    "name": "Название поста (string)",
    "text": "Текст поста (text)",
    "image": "Изображение (string)",
    "published_at": {
        "date": "Дата публикации комментарий (DateTime)",
        "timezone_type": 3,
        "timezone": "UTC"
    },
    "author_id": "id автора поста (integer)",
    "author_username": "Имя автора поста (string)",
    "author_email": "Email автора поста (string)"
}
```
**3. Добавление поста**<br>
**Url:** /api/post/add
<br>**Request-type:** POST
<br>**Body:**
```json  
{
    "title" : "Название (string)",
    "text" : "Текст (text)",
    "user_id" : "id пользователя (integer)",
}
```
<br>**Response-type:** json
<br>**Response:**
```json 
{
    "status": 200,
    "success": "Post added successfully"
}
```

**4. Редактирование поста**<br>
**id :** id поста<br>
**Url:** /api/post/update/{id}
<br>**Request-type:** POST
<br>**Body:**
```json  
{
    "title" : "Название (string)",
    "text" : "Текст (text)",
    "user_id" : "id пользователя (integer)",
}
```
<br>**Response-type:** json
<br>**Response:**
```json 
{
    "status": 200,
    "errors": "Post updated successfully"
}
```

**5. Удаление поста**<br>
**id :** id поста<br>
**Url:** /api/post/delete/{id}
<br>**Request-type:** DELETE
<br>**Response-type:** json
<br>**Response:**
```json 
{
    "status": 200,
    "errors": "Post deleted successfully"
}
```

**6. Возвращает все комментарии конкретного поста по id**<br>
**id :** id поста
<br>**Url:** /api/post/{id}/comments
<br>**Request-type:** GET
<br>**Response-type:** json
<br>**Response:**
```json  
{
    "id": "id Коммнтарий (integer)",
    "content": "Текст комментарий (text)",
    "published_at": {
        "date": "Дата публикации комментарий (DateTime)",
        "timezone_type": 3,
        "timezone": "UTC"
    },
    "author_id": "id автора комментарий (integer)",
    "author_username": "Имя автора комментарий (string)",
    "author_email": "Email автора комментарий (string)"
}
```

**7. Возвращает все комментарии**
<br>**Url:** /api/comments
<br>**Request-type:** GET
<br>**Response-type:** json
<br>**Response:**
```json  
{
    "id": "id Коммнтарий (integer)",
    "content": "Текст комментарий (text)",
    "published_at": {
        "date": "Дата публикации комментарий (DateTime)",
        "timezone_type": 3,
        "timezone": "UTC"
    },
    "author_id": "id автора комментарий (integer)",
    "author_username": "Имя автора комментарий (string)",
    "author_email": "Email автора комментарий (string)"
}
```

**8. Добавление комментарий конкретного поста**<br>
**id :** id поста<br>
**Url:** /api/post/{id}/add/comment
<br>**Request-type:** POST
<br>**Body:**
```json  
{
    "content" : "Текст (text)",
    "user_id" : "id пользователя (integer)",
}
```
<br>**Response-type:** json
<br>**Response:**
```json 
{
    "status": 200,
    "success": "Comment added successfully"
}
```



