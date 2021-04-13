## Проект на symfony
<b>Автор:</b> Рустам Артыкбаев<br>
<b>Версия Symfony :</b> 5.2<br>
<b>Версия PHP :</b> 7.4<br>
<b>Версия MySQL :</b> 5.7

### Make команды:
<b>1.</b>Эта команда создает пользователя с правами admin.Запустите эту команду в Docker контейнере php.<br>
```
docker exec -it app-php bash
```
<b>При запуске кода ниже создаеться админ с доступами:</b><br>
Email: admin@email.com<br>
Password:  admin123
```
make load-fixtures
```

<b>2.</b>Эта команда запускает функциональные тесты.<br>Запустите эту команду <b> в контейнере php (bash)</b>
```
make test-functional
```

<b>3.</b>Эта команда запускает Интеграционные тесты (<b>Cypress</b>)
```
make test-cypress
```
Или

```
yarn run cypress open
```
<br>

### Документация REST API
<a href="https://github.com/Rustambx/books-API/blob/master/restapi.md">Документация REST API</a>
