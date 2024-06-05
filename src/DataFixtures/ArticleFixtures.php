<?php
/**
 * Article fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Enum\ArticleStatus;
use App\Entity\Tag;
use App\Entity\Article;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class ArticleFixtures.
 */
class ArticleFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullPropertyFetch
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        if (null === $this->manager || null === $this->faker) {
            return;
        }

        $this->createMany(100, 'articles', function (int $i) {
            $article = new Article();
            $article->setTitle($this->faker->sentence);
            $article->setContent($this->faker->sentence);
            $article->setCreatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );
            $article->setUpdatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );
            /** @var Category $category */
            $category = $this->getRandomReference('categories');
            $article->setCategory($category);

          $tags = $this->getRandomReferences('tags', $this->faker->numberBetween(1, 5));
           foreach ($tags as $tag) {
                $article->addTag($tag);
           }

            return $article;
        });

        $this->manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return string[] of dependencies
     *
     * @psalm-return array{0: CategoryFixtures::class}
     */
    public function getDependencies(): array
    {
        return [CategoryFixtures::class, TagFixtures::class];
    }
}
