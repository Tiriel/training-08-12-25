<?php

namespace App\Factory;

use App\Entity\Conference;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<Conference>
 */
final class ConferenceFactory extends PersistentObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    #[\Override]
    public static function class(): string
    {
        return Conference::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    #[\Override]
    protected function defaults(): array|callable
    {
        return [
            'accessible' => self::faker()->boolean(),
            'description' => self::faker()->realTextBetween(150, 400),
            'name' => self::faker()->realText(100),
            'startAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('01-01-2015', 'now')),
            'organizations' => OrganizationFactory::randomRangeOrCreate(0, 3),
            'createdBy' => UserFactory::randomOrCreate(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this
            ->afterInstantiate(function(Conference $conference): void {
                $conference->setEndAt(
                    \DateTimeImmutable::createFromMutable(
                        self::faker()->dateTimeInInterval($conference->getStartAt()->format('Y-m-d'), '+4days')
                    )
                );
            })
        ;
    }
}
