<?php
namespace Amethyst\Tests\Models;

use Illuminate\Notifications\Notifiable;
use Amethyst\Models\Foo as Model;

class Foo extends Model
{
	use Notifiable;
}