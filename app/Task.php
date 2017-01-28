<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
	protected $attributes = [
		'completed' => false
	];
   	protected $casts = [
   		'completed' => 'boolean'
   	];
}
