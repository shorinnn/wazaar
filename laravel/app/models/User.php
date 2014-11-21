<?php

use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;

class User extends Ardent implements ConfideUserInterface
{
    use ConfideUser;
    use HasRole; // Add this trait to your user model
}