# Запуск

```
docker-compose up -d 
docker exec -it app-test bash 
-- ./yii migrate
```

## Запуск парсера

```
./yii google-doc-parser 'https://docs.google.com/spreadsheets/d/10En6qNTpYNeY_YFTWJ_3txXzvmOA7UxSCrKfKCFfaRw/export?format=csv&id=10En6qNTpYNeY_YFTWJ_3txXzvmOA7UxSCrKfKCFfaRw&gid=1428297429' 
```
