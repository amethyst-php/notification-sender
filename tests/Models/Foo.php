<?php

namespace Amethyst\Tests\Models;

use Amethyst\Models\Foo as Model;
use Illuminate\Notifications\Notifiable;

class Foo extends Model
{
    use Notifiable;
}
