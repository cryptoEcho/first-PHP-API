# Изменить элемент *bank*

Изменение записи в таблице *bank*, т.е. изменение данных банка.

**URL** : `/my_api/edititem.php`

**Метод** : `POST`

**Обязательный параметр** : `bank_id`

**Необязательные параметры** : `title` `owner_id` `type_id` `city_id`

## Успешный ответ

**Код ответа** : `200 OK`




## Пример

### Запрос

#### cURL
Допускается изменение как всех полей, так и выборочно.


by multipart/form-data

```shell
curl --request POST \
  --url http://localhost:8001/my_api/edititem.php \
  --header 'Content-Type: multipart/form-data; boundary=---011000010111000001101001' \
  --form bank_id=1 \
  --form title=MDRBank
```

by JSON body

```shell
curl --request POST \
  --url http://localhost:8001/my_api/edititem.php \
  --header 'Content-Type: application/json' \
  --data '{
	"bank_id": 1,
	"title": "QQQBank",
	"owner_id": 207,
	"type_id": 4,
	"city_id": 312
}'
```

### Ответ

```json
{
	"status": "success",
	"id": 1
}
```