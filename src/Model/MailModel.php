<?php

namespace App\Model;




class MailModel
{

    protected string $title;
    protected string $subject;
    protected string $content;

    private function __construct(string $title, string $subject, string $content)
    {
        $this
            ->setTitle($title)
            ->setSubject($subject)
            ->setContent($content);
    }

    public static function create(string $title, string $subject, string $content)
    {
        return new self($title, $subject, $content);
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
