
## Features
    REST API
        inputFilter
        valueObject DDD
        DTO
        ORM Doctrine
        API problem details RFC7807 responses
        Error handlers
    oauth2-server (Authorization code w\wo PKCE, Refresh token, Client credentials)
    Psalm
    Unit tests
    Xdebug
    Docker 
    Coding standard PSR-12 cs-check, cs-fix

## PSR
    1	Basic Coding Standard	
    -3	Logger Interface	
    4	Autoloading Standard	
    -6	Caching Interface	
    7	HTTP Message Interface	
    11	Container Interface	
    12	Extended Coding Style 
    -13	Hypermedia Links	
    -14	Event Dispatcher	
    15	HTTP Handlers	
    -16	Simple Cache	
    17	HTTP Factories	
    -18	HTTP Client	
    20	Clock

## Commands 
    set DEV mode to control all warn\err:
    docker container attach shell. 
    cd /var/www 
    composer development-enable  
    composer development-disable  
    composer development-status  
    composer clear-config-cache   #clean mezzio config cache in non-dev mode (in dev-mode the cache is disabled)       

## Xdebug 
    In someFile.php add xdebug_info();  and see at resulr
    .vscode/launch.json
    src/dockerfiles/php-local.ini
    .env APP_ENV=local
    src/dockerfiles/Dockerfile   
            COPY ./dockerfiles/php-${APP_ENV}.ini
            $WITH_XDEBUG => see docker-compose.yml
    VScode => Run and Debug, with PHPdebug ext installed. Without devContainer. NO need devContainer.

## ORM Doctrine
    src/src/Oauth2/src/Entity/AuthCodeEntity.php
    #[ORM\Entity(repositoryClass: AuthCodeRepository::class)]
    Then:
    em->getRepository(AuthCodeEntity::class); Return not Oauth2/src/Repository/AuthCodeRepository.php...
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
    composer clear-cache                #clean composer 

    composer update --no-scripts        #Skips execution of scripts defined in composer.json

    composer dump-autoload --optimize   #update autoloader, without install\update packages
        when add composer.json    
            "autoload": {
                "psr-4": {
                    "App\\": "src/src/",
                    "Page\\": "src/Page/src/"  //ADD something   


    composer update --lock   #update .lock by edited .json, without install\update packages
    --dry-run                                   #Simulate the command without actually doing anything

## TEST
    src/phpunit.xml.dist
    src/composer.json "autoload-dev":  "Oauth2\\tests\\": "src/Oauth2/tests" 
    composer test

## PSALM 
    composer require --dev vimeo/psalm
    cd /var/www && /var/www/vendor/bin/psalm --init

    If you have a bunch of errors and you don't want to fix them all at once, 
    Psalm can hide errors in existing code; will generate a file containing the current HIDING errors.
    vendor/bin/psalm --set-baseline=psalm-baseline.xml

    This will remove fixed issues, but will not add new issues. "Baseline for issue *** has 1 extra entry"
    vendor/bin/psalm --update-baseline 

    vendor/bin/psalm --no-cache

 ## PHP Code Sniffer, coding standard PSR-1, PSR-12
    composer require squizlabs/php_codesniffer --dev    
    composer cs-check   
    composer cs-fix

## inputFilter
    composer require --dev laminas/laminas-component-installer
    composer require laminas/laminas-validator
    composer require laminas/laminas-i18n-resources
    composer require laminas/laminas-inputfilter 
    #inject dependencies to Mezzio config/config.php

    laminas-validator laminas-inputfilter - валидация не прерывается, идет до конца, чтобы получить все ошибки и отобразить клиенту. В этом недостаток.
    В случае valueObject можно fast-fail на первичных проверках и не тратить ресурсы далее. Чем дальше, тем сложнее проверки, больше памяти. Лучше сразу отбросить строку из 10050000000000 символов.

    0. Происхождение. Были ли данные переданы доверенным отправителем?
    1. Размер. Не слишком ли они большие?
    2. Лексическое содержимое. Содержат ли они подходящие символы в правильной кодировке?
    3. Синтаксис. Соблюден ли формат?
    4. Семантика. Являются ли данные осмысленными? 

## API problem details RFC7807 responses  
    composer require mezzio/mezzio-problem-details          for prod&dev 

## php-debug-bar
    composer require --dev php-middleware/php-debug-bar     for dev

## OAuth 2.0     
        composer require league/oauth2-server   
        composer require defuse/php-encryption

        1. composer mezzio migration:up 

        2. generate private.key, public.key
        cd /var/www/src/Oauth2/key 
        openssl genrsa -out private.key 2048
        openssl rsa -in private.key -pubout -out public.key   

        3. generate encryption.key     
        /var/www/vendor/bin/generate-defuse-key
        and store string to src/src/Oauth2/src/ConfigProvider.php

        4. test clients
        User ebe474a0-45b9-40ef-ad96-dde9bca5e19e
        
        client_id 09aac9b1-f9e1-44b4-9381-9255451a3ad0
        client_secret no, isConfidential: false,

        isConfidential: true (machine-to-machine backends)
        client_id a8fdfb18-9293-4f37-aad2-a52bb383204b
        client_secret 47e2f77d-a04e-4e08-b627-ba67b9c3d987

        https://x.not-real.ru/oauth2/authorize?response_type=code&client_id=a8fdfb18-9293-4f37-aad2-a52bb383204b&redirect_uri=https://x.not-real.ru&scope=full&client_secret=47e2f77d-a04e-4e08-b627-ba67b9c3d987&state=

        get-post Authorization Code, get AccessToken with RefreshToken, do Refresh action. 
        AccessToken in JWT    

        Middleware session? To store request "get Authorization Code" until user login. 

        @todo ClientRepository: pull client from .env or config for: prod, dev, test, local envs

## about
GET /news - выведет список новостей
POST /news - создаст новую новость
DELETE /news/{id} - удалит новость   
"функционал редактирования и публикации новости."

## additional
    === Domain purity ===
        Отделить Infrastructure Doctrine Entity от Domain Entity. 
        Сделать Domain\RepositoryInterface, а Infrastructure\Doctrine будет implements эти интерфейсы.  
        В Domain Entity сделать явные методы:  
            public static function new()
            public static function hydrateExisting()
            public function changeSomeBySomeAction()        

    === News\NewsService-> private function getRepository(): NewsRepository 
            {
                return $this->em->getRepository(News::class);
            }
            Can be moved to parent class with Late static binding. static::class() 

    ===News\Handler\CreateHandler    
        API client send POST: https://x.not-real.ru/news
        x-www-form-urlencoded
        title
        text

    ===News\NewsService
    findAll: 'status' => [Status::Publicated, Status::Draft,],   to see created news (draft)    





