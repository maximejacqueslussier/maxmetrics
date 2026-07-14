<?php

declare(strict_types=1);

namespace App\Domain\Authentication;

use App\Domain\User\User;
use DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RefreshTokenRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(
    fields: ['tokenHash'],
    message: 'app.domain.authentication.refreshToken.tokenHash.uniqueEntityMessage',
)]
final class RefreshToken
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64, unique: true)]
    #[Assert\NotBlank(message: 'app.domain.authentication.refreshToken.tokenHash.notBlankMessage')]
    #[Assert\Length(max: 64, maxMessage: 'app.domain.authentication.refreshToken.tokenHash.maxMessage')]
    private ?string $tokenHash;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTime $expiresAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $revokedAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[ORM\OneToOne(targetEntity: RefreshToken::class)]
    private ?RefreshToken $replacedBy = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private User $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTokenHash(): ?string
    {
        return $this->tokenHash;
    }

    public function setTokenHash(string $tokenHash): self
    {
        $this->tokenHash = $tokenHash;

        return $this;
    }

    public function getExpiresAt(): ?DateTime
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(DateTime $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function getRevokedAt(): ?DateTimeImmutable
    {
        return $this->revokedAt;
    }

    public function setRevokedAt(DateTimeImmutable $revokedAt): self
    {
        $this->revokedAt = $revokedAt;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getReplacedBy(): ?RefreshToken
    {
        return $this->replacedBy;
    }

    public function setReplacedBy(RefreshToken $replacedBy): self
    {
        $this->replacedBy = $replacedBy;

        return $this;
    }

    public function replaceWith(RefreshToken $replacement): void
    {
        $this->revokedAt = new DateTimeImmutable();
        $this->replacedBy = $replacement;
    }

    public function revoke(): void
    {
        $this->revokedAt = new DateTimeImmutable();
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    #[ORM\PrePersist]
    public function setTimestamps(): void
    {
        $this->createdAt = new DateTimeImmutable();
    }
}
