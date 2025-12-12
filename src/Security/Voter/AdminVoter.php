<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminVoter implements VoterInterface
{
    public function __construct(
        private readonly AccessDecisionManagerInterface $checker,
    ) {}

    //public function __construct(
    //    private readonly RoleHierarchyInterface $hierarchy,
    //) {}

    public function vote(TokenInterface $token, mixed $subject, array $attributes): int
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return self::ACCESS_ABSTAIN;
        }

        //$roles = $this->hierarchy->getReachableRoleNames($user->getRoles());
        //if (\in_array('ROLE_ADMIN', $roles)) {
        //    return self::ACCESS_GRANTED;
        //}

        if ($this->checker->decide($token, ['ROLE_ADMIN'])) {
            return self::ACCESS_GRANTED;
        }

        return self::ACCESS_ABSTAIN;
    }
}
