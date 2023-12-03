```
docker run --init -it --rm -v "$(pwd)/src:/project" -w /project lyni/phpqa:8.1 phpstan analyse app modules --level 0 
docker run --init -it --rm -v "$(pwd)/src:/project" -w /project lyni/phpqa:8.1 local-php-security-checker
docker run --init -it --rm -v "$(pwd)/src:/project" -w /project lyni/phpqa:8.1 phpcpd app modules 
docker run --init -it --rm -v "$(pwd)/src:/project" -w /project lyni/phpqa:8.1 phpmnd app modules --ignore-numbers=2,-1 --ignore-funcs=round,sleep --exclude=tests --progress --extensions=default_parameter,-return,argument 
docker run --init -it --rm -v "$(pwd)/src:/project" -w /project lyni/phpqa:8.1 phpcs --standard=PSR12 app modules
docker run --init -it --rm -v "$(pwd)/src:/project" -w /project lyni/phpqa:8.1 php-cs-fixer fix --rules=@PSR12 app modules
docker run --init -it --rm -v "$(pwd)/src:/project" -w /project lyni/phpqa:8.1 phpcbf --standard=PSR12 app modules   
``` 

```
php artisan queue:work --queue=high,default
```