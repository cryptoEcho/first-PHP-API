# Добавление связи

Добавление новой записи в таблицу *bank_client*, 
т.е. добавление новой связи между клиентом и банком.

**URL** : `/my_api/addlink.php`

**Метод** : `POST`

**Обязательные параметры** : `bank_id` `client_id`

`bank_client_id` подставляется самой БД

## Успешный ответ

**Код ответа** : `200 OK`




## Пример

### Запрос

#### cURL

*multipart/form-data*

``` shell
curl --request POST \
  --url http://localhost:8001/my_api/addlink.php \
  --header 'Content-Type: multipart/form-data; boundary=---011000010111000001101001'
  --form bank_id=100 \
  --form client_id=2763
```

*JSON body*

``` shell
curl --request POST \
  --url http://localhost:8001/my_api/addlink.php \
  --header 'Content-Type: application/json'
  --data '{
	"bank_id": 382,
	"client_id": 1859
}'
```

### Ответ

```json
{
  "status": "success",
  "id": "136788"
}
```