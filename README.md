# Тестовое задание на позицию разработчика в компанию Ельмикеев Аналитика
## Credentials
Следует вставить следующее содержимое в файл `.env`
```dotenv
DB_CONNECTION=mysql
DB_HOST=sql.freedb.tech
DB_PORT=3306
DB_DATABASE=freedb_ea_analytics
DB_USERNAME=freedb_ea_user
DB_PASSWORD="&P%tWDhczGg7#83"

# Project-specific
EXTERNAL_WB_API_KEY= #Сюда необходимо подставить значение API-ключа
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
## Известные проблемы и возможные улучшения:
1. В силу отсутствия дополнительных знаний о структуре получаемых данных и суррогатной природы колонки `id` во всех таблицах на данный момент я не могу реализовать **дедупликацию** или **upsert**. Поэтому запускать скрипты приходится на пустой БД (чтобы не происходило дублирования данных).
2. Можно было бы сделать красивенький консольный лог с progress-баром при получении данных
3. При необходимости можно сделать что-то вроде cron-job для постоянного fetch'а данных (например, за день или за неделю). При этом логику fetch'а стоило бы вынести из trait'а в сервис. Но пока так :-)
