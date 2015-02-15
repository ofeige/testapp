<?php

class User extends \Model
{
    public function feeds()
    {
        return $this->has_many('Feeds');
    }

    public function user_has_role()
    {
        return $this->has_many('UserRole');
    }

    public function role()
    {
        return $this->has_many_through('Role', 'UserRole');
    }

    public static function withRoles($orm)
    {
        return $orm->select('*')->select_expr('(select
            role.name
        from
            user_has_role
                left join
            `role` ON (role.id = user_has_role.role_id)
        where
            `user_has_role`.user_id = user.id)',
            'role', 'role');
    }
} 
