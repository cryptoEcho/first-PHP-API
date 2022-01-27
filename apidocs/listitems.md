# Список элементов *bank*

Получение полного списка банков (около 1000).

**URL** : `/my_api/listitems.php`

**Метод** : `GET`

## Успешный ответ

**Код ответа** : `200 OK`




## Пример

### Запрос

#### cURL

```shell
curl --request GET \
  --url http://localhost:8001/my_api/listitems.php
```

### Ответ

Показана только часть ответа.

```json
[
  {
    "id": 1,
    "title": "MDRBank",
    "owner": "Dwayne Johnson",
    "bank type": "investment banking",
    "city": " Andorra La Vella"
  },
  {
    "id": 2,
    "title": "SberBank",
    "owner": "Dwayne Johnson",
    "bank type": "investment banking",
    "city": "Dublin"
  },
  {
    "id": 3,
    "title": "Wells Fargo",
    "owner": "Joe Biden",
    "bank type": "private banking",
    "city": " Andorra La Vella"
  },
  {
    "id": 4,
    "title": "BinBank",
    "owner": "Jeff Bezos",
    "bank type": "corporate banking",
    "city": "Moscow"
  },
  {
    "id": 5,
    "title": "UniCredit",
    "owner": "Dwayne Johnson",
    "bank type": "investment banking",
    "city": "London"
  }
]
```