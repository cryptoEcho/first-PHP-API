# Удаление элемента

Удалить элемент из одной из таблиц [*bank*, *client*]

**URL** : `/my_api/deleteitem.php`

**Метод** : `DELETE`

**Обязательный параметр** : `bank_id` или `client_id`\
указание обоих параметров одновременно **запрещененно**.

## Успешный ответ

**Код ответа** : `200 OK`




## Пример

### Запрос

#### cURL

Удаление возможно, только если нет записей, связанных с данной по связям М-М.

**Удаление банка**

``` shell
curl --request DELETE \
  --url 'http://localhost:8001/my_api/deleteitem.php?bank_id=994'
```

**Удаление клиента**

``` shell
curl --request DELETE \
  --url 'http://localhost:8001/my_api/deleteitem.php?client_id=56006'
```



### Ответ

```json
{
  "status": "success"
}
```