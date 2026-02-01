<?php

declare(strict_types=1);

namespace App\Application\User\ListUsers;

use Symfony\Contracts\Translation\TranslatorInterface;

use function ctype_digit;

final class UsersListQuery
{
    private const int DEFAULT_LIMIT = 25;
    private const array SORT_MAP = ['id', 'createdAt', 'updatedAt'];

    /** @var int[] */
    private array $ids = [];
    
    /** @var array<string, string> */
    private array $sorts = [];

    private int $firstIds = self::DEFAULT_LIMIT;
    private int $limit = self::DEFAULT_LIMIT;
    private ?int $afterId = null;

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {
    }

    /**
     * Get \App\Domain\User\User::ID as criteria.
     *
     * @return int[]
     */
    public function getIds(): ?array
    {
        return $this->ids;
    }

    /**
     * Sets all the \App\Domain\User\User::ID to match against the list of users.
     *
     * @param int[] $ids
     *
     * @return \App\Application\User\ListUsers\UsersListQuery
     */
    public function setIds(array $ids): self
    {
        foreach ($ids as $id) {
            if (!ctype_digit($id)) {
                throw new InvalidUserIdException(
                    $this->translator->trans('app.application.listUsers.invalidUserIdException')
                );
            }

            $this->ids[] = (int) $id;
        }

        return $this;
    }

    /**
     * Get the first ids for forward pagination.
     *
     * @return int
     */
    public function getFirstIds(): int
    {
        return $this->firstIds;
    }

    /**
     * Sets the first ids for forward pagination.
     *
     * @param int $firstIds
     *
     * @return \App\Application\User\ListUsers\UsersListQuery
     */
    public function setFirstIds(int $firstIds): self
    {
        if (!ctype_digit($firstIds) && $firstIds <= 0) {
            throw new InvalidForwardPaginationException(
                $this->translator->trans('app.application.listUsers.invalidForwardPaginationException.firstIds'),
            );
        }

        $this->firstIds = $firstIds;

        return $this;
    }

    /**
     * Get the after id for forward pagination.
     *
     * @return int|null
     */
    public function getAfterId(): ?int
    {
        return $this->afterId;
    }

    /**
     * Sets the after id for forward pagination.
     * If none provided it will default to DEFAULT_PAGE_OFFSET.
     *
     * @param int $afterId
     *
     * @return \App\Application\User\ListUsers\UsersListQuery
     */
    public function setAfterId(int $afterId): self
    {
        if (!ctype_digit($afterId) && $afterId < 0) {
            throw new InvalidForwardPaginationException(
                $this->translator->trans('app.application.listUsers.invalidForwardPaginationException.afterId'),
            );
        }

        $this->afterId = $afterId;

        return $this;
    }

    /**
     * Gets the upper limit for forward pagination.
     *
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * Sets the upper limit for forward pagination.
     *
     * @param int $limit
     *
     * @return \App\Application\User\ListUsers\UsersListQuery
     */
    public function setLimit(int $limit): self
    {
        if (!ctype_digit($limit) && $limit < 1) {
            throw new InvalidForwardPaginationException(
                $this->translator->trans('app.application.listUsers.invalidForwardPaginationException.limit'),
            );
        }

        return $this;
    }
    
    /**
     * Get the sorting fields and their directions.
     *
     * @return array<string, string>
     */
    public function getSorts(): array
    {
        return $this->sorts;
    }
    
    /**
     * Sets the sorting fields and directions.
     *
     * @param array<string, string> $sorts
     *
     * @return \App\Application\User\ListUsers\UsersListQuery
     */
    public function setSorts(array $sorts): self
    {        
        foreach ($sorts as $sort)
        {
            if (!(array_key_exists('field', $sort) && array_key_exists('direction', $sort))) {
                throw new InvalidSortingException(
                    $this->translator->trans('app.application.listUsers.invalidSortingException.both', [
                        '{{ field }}' => $sort['field'],
                    ]),
                );
            }

            if ($sort['direction'] !== 'ASC' && $sort['direction'] !== 'DESC') {                
                throw new InvalidSortingException(
                    $this->translator->trans('app.application.listUsers.invalidSortingException.direction', [
                        '{{ field }}' => $sort['field'],
                    ]),
                );
            }
            
            if (!in_array($sort['field'], self::SORT_MAP, true)) {
                throw new InvalidSortingException(
                    $this->translator->trans('app.application.listUsers.invalidSortingException.field', [
                        '{{ field }}' => $sort['field'],
                    ]),
                );
            }
            
            $this->sorts[$sort['field']] = $sort['direction'];
        }
        
        return $this;
    }
}
