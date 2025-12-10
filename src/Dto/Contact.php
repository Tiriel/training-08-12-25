<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    #[Assert\Length(min: 2)]
    #[Assert\NotBlank()]
    private string $name = '';

    #[Assert\Email]
    #[Assert\NotBlank()]
    private string $email = '';

    #[Assert\Length(min: 10)]
    #[Assert\NotBlank()]
    private string $subject = '';

    #[Assert\Length(min: 20)]
    #[Assert\NotBlank()]
    private string $message = '';
    private ?\DateTimeInterface $sentAt = null;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Contact
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): Contact
    {
        $this->email = $email;

        return $this;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): Contact
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): Contact
    {
        $this->message = $message;

        return $this;
    }

    public function getSentAt(): ?\DateTimeInterface
    {
        return $this->sentAt;
    }

    public function setSentAt(?\DateTimeInterface $sentAt): Contact
    {
        $this->sentAt = $sentAt;

        return $this;
    }
}
