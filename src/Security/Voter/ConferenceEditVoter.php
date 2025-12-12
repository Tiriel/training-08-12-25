<?php

namespace App\Security\Voter;

use App\Entity\Conference;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

class ConferenceEditVoter implements VoterInterface
{
    public function __construct(
        private readonly RoleHierarchyInterface $hierarchy,
    ) {}

    public function vote(TokenInterface $token, mixed $subject, array $attributes): int
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            return self::ACCESS_DENIED;
        }

        $roles = $this->hierarchy->getReachableRoleNames($user->getRoles());
        foreach ($attributes as $attribute) {
            if (Attributes::EDIT_CONF !== $attribute || !$subject instanceof Conference) {
                continue;
            }

            if (\in_array('ROLE_WEBSITE', $roles) || $subject->getCreatedBy() === $user) {
                return self::ACCESS_GRANTED;
            }

            return self::ACCESS_DENIED;
        }

        return self::ACCESS_ABSTAIN;
    }
}
