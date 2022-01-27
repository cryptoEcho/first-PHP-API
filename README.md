# MY FIRST API
>Рудзянский Артемий БИБ201 \
> Задание 5.1 Приложение с базой данных


## Методы

* [Список элементов *bank*](apidocs/listitems.md) :  `GET /my_api/listitems.php`


* [Список элементов *client*](apidocs/listitems2.md) :   `GET /my_api/listitems2.php`


* [Получение элемента *bank*](apidocs/getitem.md) :    `GET /my_api/getitem.php`


* [Добавление элемента *bank*](apidocs/additem.md) :  `POST /my_api/additem.php`


* [Добавление элемента *client*](apidocs/additem2.md) :  `POST /my_api/additem2.php`


* [Добавление связи](apidocs/addlink.md) : `POST /my_api/addlink.php`


* [Редактирование элемента *bank*](apidocs/edititem.md) : `POST /my_api/edititem.php`


* [Редактирование элемента *client*](apidocs/edititem2.md) : `POST /my_api/edititem2.php`


* [Удаление элемента *bank* или *client*](apidocs/deleteitem.md) : `DELETE /my_api/deleteitem.php`

## [**Ошибки**](apidocs/error.md)
 Обработки ошибок очень схожи, поэтому примеры ошибок обобщены и выведены в один файл.

### Логирование ошибок
Ведётся логирование ошибок. Файл [*error.log*](error.log) хранится выше корневой папки, с целью недоступности файла из вне.

### ~~Вспомогательный~~ Ключевой файл
В реализации присутствует файл [*func.php*](my_api/func.php), в котором содержатся различные функции, повторяющиеся от файла к файлу. Создан с целью уменьшения громоздкости кода.
