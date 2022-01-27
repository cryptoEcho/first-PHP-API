# Добавление элемента *client*

Добавление новой записи в таблицу *client*, т.е. добавление нового клиента.

**URL** : `/my_api/additem2.php`

**Метод** : `POST`

**Обязательные параметры** : `first_name` `last_name` `capital` `city_id`

`client_id` подставляется самой БД

## Успешный ответ

**Код ответа** : `200 OK`




## Пример

### Запрос

#### cURL

*multipart/form-data*

``` shell
curl --request POST \
  --url http://localhost:8001/my_api/additem2.php \
  --header 'Content-Type: multipart/form-data; boundary=---011000010111000001101001' \
  --cookie PHPSESSID=8ub2rqjus2beqjq49d60kla2ii \
  --form first_name=Garry \
  --form last_name=Ohj \
  --form capital=23323 \
  --form city_id=5
```

*JSON body*

``` shell
curl --request POST \
  --url http://localhost:8001/my_api/additem2.php \
  --header 'Content-Type: application/json' \
  --data '{
	"first_name": "Andrew",
	"last_name": "Lavrensky",
	"capital": "15552",
	"city_id": "12"
}'
```

### Ответ

```json
{
  "status": "success",
  "id": 56007
}
```