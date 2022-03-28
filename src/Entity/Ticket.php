<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: \App\Repository\TicketRepository::class)]
#[ORM\Table(name: "tickets")]
#[ORM\HasLifecycleCallbacks()]
class Ticket implements \JsonSerializable
{
    use EntityIdentifierTrait;
    use EntityTimestampsTrait;

    #[ORM\Column(type: 'smallint')]
    private int $place;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

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

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

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
        $sessionMovie = $this->session->getMovie();
        $sessionHall = $this->session->getHall();
        return [
            'id' => $this->id,
            'place' => $this->place,
            'user' => [
                'id' => $this->user->getId(),
                'name' => $this->user->getName(),
                'email' => $this->user->getEmail(),
                'roles' => $this->user->getRoles(),
                'created_at' => $this->user->getCreatedAt()->format('Y-m-d\TH:i:s.u'),
                'updated_at' => $this->user->getUpdatedAt()->format('Y-m-d\TH:i:s.u'),
            ],
            'session' => [
                'id' => $this->session->getId(),
                'begin_at' => $this->session->getBeginAt()->format('Y-m-d\TH:i:s.u'),
                'end_at' => $this->session->getEndAt()->format('Y-m-d\TH:i:s.u'),
                'movie' => [
                    'id' => $sessionMovie->getId(),
                    'title' => $sessionMovie->getTitle(),
                    'description' => $sessionMovie->getDescription(),
                    'poster' => $sessionMovie->getPoster(),
                    'price' => $sessionMovie->getPrice(),
                    'year' => $sessionMovie->getYear(),
                    'duration' => $sessionMovie->getDuration(),
                    'created_at' => $sessionMovie->getCreatedAt()->format('Y-m-d\TH:i:s.u'),
                    'updated_at' => $sessionMovie->getUpdatedAt()->format('Y-m-d\TH:i:s.u'),
                ],
                'hall' => [
                    'id' => $sessionHall->getId(),
                    'name' => $sessionHall->getName(),
                    'capacity' => $sessionHall->getCapacity(),
                    'type' => $sessionHall->getType(),
                    'created_at' => $sessionHall->getCreatedAt()->format('Y-m-d\TH:i:s.u'),
                    'updated_at' => $sessionHall->getUpdatedAt()->format('Y-m-d\TH:i:s.u'),
                ],
            ],
            'created_at' => $this->created_at->format('Y-m-d\TH:i:s.u'),
            'updated_at' => $this->updated_at->format('Y-m-d\TH:i:s.u'),
        ];
    }
}
