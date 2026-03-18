# Тестовое задание на позицию разработчика в компанию Ельмикеев Аналитика
## Database credentials
Следует вставить следующее содержимое в файл `.env`
```dotenv
DB_CONNECTION=mysql
DB_HOST=sql.freedb.tech
DB_PORT=3306
DB_DATABASE=freedb_ea_analytics
DB_USERNAME=freedb_ea_user
DB_PASSWORD="&P%tWDhczGg7#83"
```
## Описание проекта
В данном репозитории находится код, стягивающий все имеющиеся данные с [сервера](http://109.73.206.144:6969).
Реализовано получение данных при помощи Laravel-команд:
* Для endpoint'а `/api/orders`:
```shell
    php artisan app:fetch:orders
```
* Для endpoint'а `/api/sales`:
```shell
    php artisan app:fetch:sales
```
* Для endpoint'а `/api/incomes`:
```shell
    php artisan app:fetch:incomes
```
* Для endpoint'а `/api/stocks`:
```shell
    php artisan app:fetch:stocks
```
## Известные проблемы:
В силу отсутствия дополнительных знаний о структуре получаемых данных и суррогатной природы колонки `id` во всех таблицах на данный момент я не могу реализовать **дедупликацию** или **upsert**. Поэтому запускать скрипты приходится на пустой БД (чтобы не происходило дублирования данных).
