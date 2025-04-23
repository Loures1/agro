<?php

namespace core\view;

use core\view\Group;

enum TypeGroup
{
    case Struct;
    case Header;
    case Body;

    public static function getGroup(TypeGroup $type_group): array
    {
        return match($type_group) {
            self::Struct => [Group::Header, Group::Body],
            self::Header => [Group::Title, Group::PathCss]
        };
    }
}