
# Тестовое задание



GET /news - выведет список новостей

POST /news - создаст новую новость

DELETE /news/{id} - удалит новость  


Есть очень расплывчатое ТЗ:
"Для фронтенда требуется реализовать функционал редактирования и публикации новости."

Прояви самостоятельность и реализуй данное ТЗ в максимально правильном на твой взгляд виде. Желательно оставить пояснения по принятым решениям. 
PS:
Аутентификация и авторизация остаётся за рамками этого проекта.

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

2.  === Domain purity ===

    Отделить Infrastructure Doctrine Entity от Domain Entity. 
    Сделать Domain\RepositoryInterface, а Infrastructure\Doctrine будет implements эти интерфейсы.  
    В Domain Entity сделать явные методы:  
        public static function new()
        public static function hydrateExisting()
        public function changeSomeBySomeAction()
        5.  

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


