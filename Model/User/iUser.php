<?php

interface iUser
{
    public function save(User $user);
    
    public function delete(User $user);
}