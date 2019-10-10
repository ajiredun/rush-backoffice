<?php


namespace App\ApiPlatform;


use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Page;
use App\Enums\Roles;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

class PagePublishedExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{

    private $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }



    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = [])
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        if ($this->security->isGranted(Roles::ROLE_PAGE_MANAGEMENT_EDITOR)) {
            return;
        }

        if ($resourceClass !== Page::class) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->andWhere(sprintf('%s.published = :published', $rootAlias))
            ->setParameter('published', true);
    }

}