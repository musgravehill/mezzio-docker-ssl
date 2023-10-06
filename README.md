
# Тестовое задание

Привет тебе странник.

Перед тобой простенький проект на Mezzio с одним модулем News.

Перед тем как начать, сделай форк репозитория и работай со своим форком.  

# Задачи  

1. развернуть у себя проект, исправив ошибки

2. исправить ошибки в ендпоинтах

3. реализовать функционал редактирования и публикации новости

## Задача 1. Развернуть окружение  

Успешно развернуть проект твоя первая задача. Покажи, что ты умеешь **базово** работать с docker.

Не всё пойдет гладко.

После успешного старта у тебя должен октрываться адрес https://x.not-real.ru

Где будет отдаваться json вида

> {"ack":1694500801} 

## Задача 2. Исправить ошибки в ендпоинтах  

В проекте реализованы следующие ендпоинты  

GET /news - выведет список новостей

POST /news - создаст новую новость

DELETE /news/{id} - удалит новость  

Обработчики реализованы с ошибками. Твоя задача изучить код, исправить найденные ошибки.
Приветствуются любые улучшения кода.  

## Задача 3.
Есть очень расплывчатое ТЗ:
"Для фронтенда требуется реализовать функционал редактирования и публикации новости."

Прояви самостоятельность и реализуй данное ТЗ в максимально правильном на твой взгляд виде. Желательно оставить пояснения по принятым решениям. 
PS:
Аутентификация и авторизация остаётся за рамками этого проекта.

## Предложения. 
0. Validate user inputs!

1.  === Domain purity ===

    Отделить Infrastructure Doctrine Entity от Domain Entity. 

    Сделать Domain\RepositoryInterface, а Infrastructure\Doctrine будет implements эти интерфейсы. 

    Добавить valueObjects. 

    Добавить DTO для передачи в\из handler. 

    В Domain Entity сделать явные методы:  

        public static function new()

        public static function hydrateExisting()

        public function changeSomeBySomeAction()


2. set DEV mode to control all warn\err:

    docker container attach shell. 

    cd /var/www && composer development-enable  
    cd /var/www && composer development-disable  
    cd /var/www && composer development-status 

3. News\Handler\CreateHandler   
 
    API client send POST: https://x.not-real.ru/news
    x-www-form-urlencoded
    title
    text

4. News\NewsService

    findAll: 'status' => [Status::Publicated, Status::Draft,],   to see created news (draft)

5.  News\NewsService

    TODO: 
        private function getRepository(): NewsRepository
        {
            return $this->em->getRepository(News::class);
        }

        Can be moved to parent class with Late static binding. static::class() 


