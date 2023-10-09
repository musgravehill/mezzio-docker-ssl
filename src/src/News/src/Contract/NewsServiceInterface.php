<?php

declare(strict_types=1);

namespace News\Contract;

use News\Entity\News;
use News\ValueObject\CountOnPage;
use News\ValueObject\PageNumber;
use Ramsey\Uuid\UuidInterface;


interface NewsServiceInterface
{

    public function findById(UuidInterface $id): News;

    public function findAll(PageNumber $page, CountOnPage $limit): iterable;

    public function create(string $title, string $text): News;

    public function delete(UuidInterface $id): void;

}