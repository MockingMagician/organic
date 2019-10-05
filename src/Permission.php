<?php

namespace MockingMagician\Organic;


class Permission
{
    private $user;
    private $group;
    private $others;

    public function __construct(PermissionScope $user, PermissionScope $group, PermissionScope $others)
    {
        $this->user = $user;
        $this->group = $group;
        $this->others = $others;
    }

    public function getUser(): PermissionScope
    {
        return $this->user;
    }

    public function getGroup(): PermissionScope
    {
        return $this->group;
    }

    public function getOthers(): PermissionScope
    {
        return $this->others;
    }

    public function getMode(): int
    {
        return octdec(sprintf('0%s%s%s', $this->user->getP(), $this->group->getP(), $this->others->getP()));
    }
}
