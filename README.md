Загрузка
---------

Сливаем проект в любую папку `{project_name}`

~~~
git clone https://github.com/NrwMo/converter.git {project_name}
~~~

Запуск
------
Запускаем команду на билд контейнеров из корня проекта
~~~
docker-compose up -d --build
~~~

Заходим в контейнер `php8.1`

~~~
docker exec -it {project_name}-php8.1-1 /bin/sh
~~~

Все последующие команды должны выполняться из консоли контейнера `php8.1`

~~~
cd converter
composer install
~~~

Также для работы приложения необходимо выполнить миграции 

~~~
php yii migrate/up
~~~

После этого проект будет доступен по следующему пути:

~~~
http://localhost:8080
~~~

Для обновления курсов валют перейдите на вкладку `Обновить курсы` 

`localhost:8080/converter/update-exchanges`

Непосредственно конвертер находится на вкладке `Конвертер валют`

`localhost:8080/converter/index`