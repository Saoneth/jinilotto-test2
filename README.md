# jinilotto-test2
```shell
php bin/console doctrine:migrations:migrate -n --configuration config/doctrine_migrations_source.yaml --em source
php bin/console doctrine:migrations:migrate -n --configuration config/doctrine_migrations_destination.yaml --em destination
```
