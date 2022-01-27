# Список элементов *client*

Получение полного списка клиентов (около 56000).

**URL** : `/my_api/listitems2.php`

**Метод** : `GET`

## Успешный ответ

**Код ответа** : `200 OK`




## Пример

### Запрос

#### cURL

```shell
curl --request GET \
  --url http://localhost:8001/my_api/listitems2.php
```

### Ответ

Ошибки в повторении клиентов нет. Это происходит из-за наличия клиента сразу в нескольких банках.

Показана только часть ответа. 
```json
[
  {
    "client_id": 1,
    "name": "Sheila",
    "last name": "Park",
    "city": " Geneva",
    "bank": "Caixa Geral de Depósitos"
  },
  {
    "client_id": 2,
    "name": "Nancy",
    "last name": "Sanchez",
    "city": "Zurich",
    "bank": "Afrasia Bank Zimbabwe Limited"
  },
  {
    "client_id": 2,
    "name": "Nancy",
    "last name": "Sanchez",
    "city": "Zurich",
    "bank": "Vista Bank"
  },
  {
    "client_id": 2,
    "name": "Nancy",
    "last name": "Sanchez",
    "city": "Zurich",
    "bank": "Commercial Bank of Dubai"
  },
  {
    "client_id": 3,
    "name": "Rachel",
    "last name": "Johnson",
    "city": " Asmara",
    "bank": "Citibank Europe"
  },
  {
    "client_id": 3,
    "name": "Rachel",
    "last name": "Johnson",
    "city": " Asmara",
    "bank": "Banco Santander (México) S.A."
  },
  {
    "client_id": 4,
    "name": "Jeffrey",
    "last name": "Jimenez",
    "city": " Nürnberg",
    "bank": "Commercial Bank Centrafrique"
  },
  {
    "client_id": 4,
    "name": "Jeffrey",
    "last name": "Jimenez",
    "city": " Nürnberg",
    "bank": "Banque du Caire"
  },
  {
    "client_id": 5,
    "name": "Whitney",
    "last name": "Navarro",
    "city": " Belgrade",
    "bank": "Afriland First Bank"
  },
  {
    "client_id": 5,
    "name": "Whitney",
    "last name": "Navarro",
    "city": " Belgrade",
    "bank": "China Banking Corporation"
  },
  {
    "client_id": 5,
    "name": "Whitney",
    "last name": "Navarro",
    "city": " Belgrade",
    "bank": "Allgemeine Sparkasse Oberosterreich"
  }
]
```