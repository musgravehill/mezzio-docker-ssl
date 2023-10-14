
GET /news - выведет список новостей
POST /news - создаст новую новость
DELETE /news/{id} - удалит новость  
 
"функционал редактирования и публикации новости."
 
## Предложения. 
0. Validate user inputs!
    laminas-validator laminas-inputfilter - валидация не прерывается, идет до конца, чтобы получить все ошибки и отобразить клиенту. В этом недостаток.
    В случае valueObject можно fast-fail на первичных проверках и не тратить ресурсы далее. Чем дальше, тем сложнее проверки, больше памяти. Лучше сразу отбросить строку из 10050000000000 символов.

    0. Происхождение. Были ли данные переданы доверенным отправителем?
    1. Размер. Не слишком ли они большие?
    2. Лексическое содержимое. Содержат ли они подходящие символы в правильной кодировке?
    3. Синтаксис. Соблюден ли формат?
    4. Семантика. Являются ли данные осмысленными? 

0.0. Error handlers

0.0.0 Добавить valueObjects. 

1. Добавить DTO для передачи в\из handler. 

2. UUID in Doctrine. Interface or explicit version? UuidV7?

3. composer require mezzio/mezzio-problem-details    for prod&dev 

   Use HTTP status codes to help convey error status.
   Provide sufficient error detail to clients.

   RFC 7807 provides a standard format for returning problem details from HTTP APIs. In particular, it specifies the following:

Error responses MUST use standard HTTP status codes in the 400 or 500 range to detail the general category of error.
Error responses will be of the Content-Type application/problem, appending a serialization format of either json or xml: application/problem+json, application/problem+xml.
Error responses will have each of the following keys:
detail, a human-readable description of the specific error.
type, a unique URI for the general error type, generally pointing to human-readable documentation of that given type.
title, a short, human-readable title for the general error type; the title should not change for given types.
status, conveying the HTTP status code; this is so that all information is in one place, but also to correct for changes in the status code due to usage of proxy servers.
Optionally, an instance key may be present, with a unique URI for the specific error; this will often point to an error log for that specific response.



## additional
2.  === Domain purity ===
    Отделить Infrastructure Doctrine Entity от Domain Entity. 
    Сделать Domain\RepositoryInterface, а Infrastructure\Doctrine будет implements эти интерфейсы.  
    В Domain Entity сделать явные методы:  
        public static function new()
        public static function hydrateExisting()
        public function changeSomeBySomeAction()        

3. News\NewsService-> private function getRepository(): NewsRepository 
        {
            return $this->em->getRepository(News::class);
        }
        Can be moved to parent class with Late static binding. static::class() 

## Commands. 
1. set DEV mode to control all warn\err:
    docker container attach shell. 
    cd /var/www && composer development-enable  
    cd /var/www && composer development-disable  
    cd /var/www && composer development-status 

2. News\Handler\CreateHandler    
    API client send POST: https://x.not-real.ru/news
    x-www-form-urlencoded
    title
    text

3. News\NewsService
    findAll: 'status' => [Status::Publicated, Status::Draft,],   to see created news (draft)

4. cd /var/www && composer require --dev laminas/laminas-component-installer
   cd /var/www && composer require laminas/laminas-validator
   cd /var/www && composer require laminas/laminas-i18n-resources
   cd /var/www && composer require laminas/laminas-inputfilter 
   #inject dependencies to Mezzio config/config.php 

   cd /var/www && composer clear-config-cache   #clean mezzio cinfig cache in non-dev mode (in dev-mode the cache is disabled)   


6. composer require mezzio/mezzio-problem-details    for prod&dev 

7. composer require --dev php-middleware/php-debug-bar for dev

8. Xdebug 
    In someFile.php add xdebug_info();  and see at resulr
    .vscode/launch.json
    src/dockerfiles/php-local.ini
    .env APP_ENV=local
    src/dockerfiles/Dockerfile   
            COPY ./dockerfiles/php-${APP_ENV}.ini
            $WITH_XDEBUG => see docker-compose.yml
    VScode => Run and Debug, with PHPdebug ext installed. Without devContainer. NO need devContainer.

11. Middleware session? To store request "get Authorization Code" until user login. 

10. OAuth 2.0     
    get-post Authorization Code, get AccessToken with RefreshToken, do Refresh action. 
    AccessToken in JWT

    composer require league/oauth2-server

    @todo ClientRepository: pull client from .env or config for: prod, dev, test, local envs

## ORM Doctrine

    src/src/Oauth2/src/Entity/AuthCodeEntity.php
    #[ORM\Entity(repositoryClass: AuthCodeRepository::class)]
    Then:
    em->getRepository(AuthCodeEntity::class); Return src/src/Oauth2/src/Repository/AuthCodeRepository.php
    Thanks for php8 Attributes :) 

    src/config/autoload/doctrine.global.php    
    add laminas-cli commands migration:diff    

        composer mezzio migration:diff  
        composer mezzio migration:generate 
        composer mezzio migration:up 
        composer mezzio migration:execute 
        composer mezzio migration:down 
        composer mezzio migration:status
 

## COMPOSER
cd /var/www/ddd && composer clear-cache                #clean composer 

cd /var/www/ddd && composer update --no-scripts        #Skips execution of scripts defined in composer.json

cd /var/www/ddd && composer dump-autoload --optimize   #update autoloader, without install\update packages
    when add composer.json    
        "autoload": {
            "psr-4": {
                "App\\": "src/src/",
                "Page\\": "src/Page/src/"  //ADD something   


cd /var/www/ddd && composer update --lock   #update .lock by edited .json, without install\update packages
--dry-run                                   #Simulate the command without actually doing anything


## TEST
    src/phpunit.xml.dist
    src/composer.json "autoload-dev":  "Oauth2\\tests\\": "src/Oauth2/tests" 

## PSALM 
    composer require --dev vimeo/psalm
    cd /var/www && /var/www/vendor/bin/psalm --init

    # If you have a bunch of errors and you don't want to fix them all at once, 
    # Psalm can hide errors in existing code; will generate a file containing the current HIDING errors.
    vendor/bin/psalm --set-baseline=psalm-baseline.xml

    # This will remove fixed issues, but will not add new issues. "Baseline for issue *** has 1 extra entry"
    vendor/bin/psalm --update-baseline 

    vendor/bin/psalm --no-cache


