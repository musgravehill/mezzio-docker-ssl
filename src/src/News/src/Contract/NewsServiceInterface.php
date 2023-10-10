<?php

declare(strict_types=1);

namespace News\Contract;

use News\Dto\NewsItemDto;
use News\Dto\NewsListItemDto;
use News\Entity\News;
use News\ValueObject\CountOnPage;
use News\ValueObject\IdUUIDv7;
use News\ValueObject\NewsText;
use News\ValueObject\NewsTitle;
use News\ValueObject\PageNumber;
use Ramsey\Uuid\UuidInterface;

interface NewsServiceInterface
{
    public function getItem(IdUUIDv7 $id): ?NewsItemDto;

    /**
     * @return NewsListItemDto[]
     */
    public function findAll(PageNumber $page, CountOnPage $limit): iterable;

    /**
     * @return NewsItemDto
     */
    public function create(NewsTitle $title, NewsText $text): ?NewsItemDto;

    public function delete(IdUUIDv7 $id): void;

    //todo explicitMethodName to update item
    //todo publish
}
