<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: \App\Repository\TicketRepository::class)]
#[ORM\Table(name: "tickets")]
#[ORM\HasLifecycleCallbacks()]
class Ticket
{
    use EntityIdentifierTrait;
    use EntityTimestampsTrait;

    #[ORM\Column(type: 'smallint')]
    private int $place;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $client;

    #[ORM\ManyToOne(targetEntity: Session::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Session $session;

    public function getPlace(): int
    {
        return $this->place;
    }

    public function setPlace(int $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getClient(): User
    {
        return $this->client;
    }

    public function setClient(User $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getSession(): Session
    {
        return $this->session;
    }

    public function setSession(Session $session): self
    {
        $this->session = $session;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'place' => $this->place,
            'client' => [
                'id' => $this->client->getId(),
                'name' => $this->client->name,
                'email' => $this->client->email,
                'role' => $this->client->role,
            ],
            'session' => [
                'id' => $this->session->getId(),
                'name' => $this->session->name,
                'movie' => [
                    'id' => $this->session->movie->getId(),
                    'title' => $this->session->movie->title,
                    'description' => $this->session->movie->description,
                    'poster' => $this->session->movie->poster,
                    'price' => $this->session->movie->price,
                    'year' => $this->session->movie->year,
                    'duration' => $this->session->movie->duration,
                ],
                'hall' => [
                    'id' => $this->session->hall->getId(),
                    'name' => $this->session->hall->name,
                    'capacity' => $this->session->hall->capacity,
                    'type' => $this->session->hall->type
                ],
            ],
            'created_at' => $this->created_at->format('Y-m-d\TH:i:s.u'),
            'updated_at' => $this->updated_at->format('Y-m-d\TH:i:s.u'),
        ];
    }
}
