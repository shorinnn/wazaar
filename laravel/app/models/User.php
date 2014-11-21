<?php

use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;

class User extends Ardent implements ConfideUserInterface
{
    use ConfideUser;
}