<?php

declare(strict_types=1);

namespace News;

use Doctrine\ORM\EntityManagerInterface;
use News\Contract\NewsServiceInterface;
use News\Entity\News;
use News\Entity\Status;
use News\Repository\NewsRepository;
use News\ValueObject\CountOnPage;
use News\ValueObject\PageNumber;
use Ramsey\Uuid\UuidInterface;

class NewsService implements NewsServiceInterface
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    public function findById(UuidInterface $id): News
    {
        return $this->getRepository()->findById($id);
    }

    public function findAll(PageNumber $page, CountOnPage $limit): iterable
    {
        $offset =  ($page->getPageNumber() - 1) * $limit->getCop();
        return $this->getRepository()->findBy([
            'status' => [Status::Publicated, Status::Draft, Status::Deleted],
        ], [
            'created' => 'DESC'
        ], $limit->getCop(), $offset);
    }

    public function create(string $title, string $text): News
    {
        $news = new News($title, $text);
        $this->em->persist($news);
        $this->em->flush();
        return $news;
    }

    public function delete(UuidInterface $id): void
    {
        $news = $this->findById($id);
        $this->em->remove($news);
        $this->em->flush();
    }

    private function getRepository(): NewsRepository
    {
        return $this->em->getRepository(News::class);
    }
}
