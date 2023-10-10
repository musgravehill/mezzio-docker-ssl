<?php

declare(strict_types=1);

namespace News\Dto;

/**
 * @psalm-immutable
 */
readonly class NewsItemDto
{
    public function __construct(
        private string $id,
        private string $title,
        private string $text,
        private string $created_at,
        private string $status,
    ) {
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getStatus()
    {
        return $this->status;
    }
}
