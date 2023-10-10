<?php

declare(strict_types=1);

namespace News;

use Doctrine\ORM\EntityManagerInterface;
use News\Contract\NewsServiceInterface;
use News\Dto\NewsItemDto;
use News\Dto\NewsListItemDto;
use News\Entity\News;
use News\Entity\Status;
use News\Repository\NewsRepository;
use News\ValueObject\CountOnPage;
use News\ValueObject\IdUUIDv7;
use News\ValueObject\NewsText;
use News\ValueObject\NewsTitle;
use News\ValueObject\PageNumber;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class NewsService implements NewsServiceInterface
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    public function getItem(IdUUIDv7 $id): ?NewsItemDto
    {
        $uuid = Uuid::fromString($id->getId());
        $news = $this->getRepository()->findById($uuid);
        if (is_null($news)) {
            return null;
        }
        return new NewsItemDto(
            id: strval($news->getId()),
            title: strval($news->getTitle()),
            text: strval($news->getText()),
            created_at: strval($news->getCreated()->format('Y-m-d')),
            status: strval($news->getStatus()->name),
        );
    }

    /**
     * @return NewsListItemDto[]
     */
    public function findAll(PageNumber $page, CountOnPage $limit): iterable
    {
        $offset =  ($page->getPageNumber() - 1) * $limit->getCop();
        $raw = $this->getRepository()->findBy([
            'status' => [Status::Publicated, Status::Draft, Status::Deleted],
        ], [
            'created' => 'DESC'
        ], $limit->getCop(), $offset);

        $res = [];
        foreach ($raw as $item) {
            $res[] = new NewsListItemDto(
                id: strval($item->getId()),
                title: strval($item->getTitle()),
                text: strval($item->getText()),
                created_at: strval($item->getCreated()->format('Y-m-d')),
            );
        }

        return $res;
    }

    /**
     * @return NewsItemDto
     */
    public function create(NewsTitle $title, NewsText $text): NewsItemDto
    {
        $news = new News($title->getTitle(), $text->getText());
        $this->em->persist($news);
        $this->em->flush();
        return new NewsItemDto(
            id: strval($news->getId()),
            title: strval($news->getTitle()),
            text: strval($news->getText()),
            created_at: strval($news->getCreated()->format('Y-m-d')),
            status: strval($news->getStatus()->name),
        );
    }

    public function delete(IdUUIDv7 $id): void
    {
        $news = $this->findById($id);
        if (is_null($news)) {
            return;
        }
        $this->em->remove($news);
        $this->em->flush();
    }

    private function getRepository(): NewsRepository
    {
        return $this->em->getRepository(News::class);
    }

    private function findById(IdUUIDv7 $id): ?News
    {
        $uuid = Uuid::fromString($id->getId());
        return $this->getRepository()->findById($uuid);
    }
}
