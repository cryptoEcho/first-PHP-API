# Добавление элемента *bank*

Добавление новой записи в таблицу *bank*, т.е. добавление нового банка.

**URL** : `/my_api/additem.php`

**Метод** : `POST`

**Обязательные параметры** : `title` `owner_id` `type_id` `city_id`


`bank_id` подставляется самой БД

## Успешный ответ

**Код ответа** : `200 OK`




## Пример

### Запрос

#### cURL

*multipart/form-data*

``` shell
curl --request POST \
  --url http://localhost:8001/my_api/additem.php \
  --header 'Content-Type: multipart/form-data; boundary=---011000010111000001101001' \
  --form title=VTB \
  --form owner_id=1 \
  --form type_id=4 \
  --form city_id=5
```

*JSON body*

``` shell
curl --request POST \
  --url http://localhost:8001/my_api/additem.php \
  --header 'Content-Type: application/json' \
  --data '{
	"title": "MikoBank",
	"type_id": "3",
	"owner_id": "3",
	"city_id": "12"
}'
```

### Ответ

```json
{
  "status": "success",
  "id": "994"
}
```