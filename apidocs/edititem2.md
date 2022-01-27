# Изменить элемент *client*

Изменение записи в таблице *client*, т.е. изменение данных клиента.

**URL** : `/my_api/edititem2.php`

**Метод** : `POST`

**Обязательный параметр** : `client_id`

**Необязательные параметры** : `first_name` `last_name` `capital` `city_id`

## Успешный ответ

**Код ответа** : `200 OK`




## Пример

### Запрос

#### cURL
Допускается изменение как всех полей, так и выборочно.


*multipart/form-data*

```shell
curl --request POST \
  --url http://localhost:8001/my_api/edititem2.php \
  --header 'Content-Type: multipart/form-data; boundary=---011000010111000001101001' \
  --form client_id=414 \
  --form last_name=Okanava \
  --form first_name=Genji \
  --form capital=10202 \
  --form city_id=13
```

*JSON body*

```shell
curl --request POST \
  --url http://localhost:8001/my_api/edititem2.php \
  --header 'Content-Type: application/json' \
  --data '{
	"client_id": 414,
	"capital": 1002
}'
```

### Ответ

```json
{
  "status": "success",
  "id": 414
}
```