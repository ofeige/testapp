<?php

class Role extends \Model
{
    const admin = 1;

    public function user()
    {
        return $this->has_many_through('User');
    }
}