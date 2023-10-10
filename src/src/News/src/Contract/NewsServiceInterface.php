<?php

declare(strict_types=1);

namespace News\Contract;

use News\Dto\NewsItemDto;
use News\Dto\NewsListItemDto;
use News\Entity\News;
use News\ValueObject\CountOnPage;
use News\ValueObject\NewsText;
use News\ValueObject\NewsTitle;
use News\ValueObject\PageNumber;
use Ramsey\Uuid\UuidInterface;


interface NewsServiceInterface
{

    public function findById(UuidInterface $id): News;

    /**
     * @return NewsListItemDto[]
     */
    public function findAll(PageNumber $page, CountOnPage $limit): iterable;

    /**
     * @return NewsItemDto
     */
    public function create(NewsTitle $title, NewsText $text): NewsItemDto;

    public function delete(UuidInterface $id): void;
}
