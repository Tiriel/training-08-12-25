<?php

namespace App\Story;

use App\Factory\ConferenceFactory;
use App\Factory\OrganizationFactory;
use App\Factory\UserFactory;
use App\Factory\VolunteeringFactory;
use Zenstruck\Foundry\Attribute\AsFixture;
use Zenstruck\Foundry\Story;

#[AsFixture(name: 'main')]
final class AppStory extends Story
{
    public function build(): void
    {
        UserFactory::createOne([
            'email' => 'admin@sensio-events.com',
            'roles' => ['ROLE_ADMIN']
        ]);
        UserFactory::createOne([
            'email' => 'organizer@sensio-events.com',
            'roles' => ['ROLE_ORGANIZER']
        ]);
        UserFactory::createOne([
            'email' => 'website@sensio_events.com',
            'roles' => ['ROLE_WEBSITE']
        ]);
        UserFactory::createOne([
            'email' => 'user@sensio_events.com',
            'roles' => ['ROLE_USER']
        ]);
        OrganizationFactory::createMany(10);
        ConferenceFactory::createMany(50);
        VolunteeringFactory::createMany(50);
    }
}
