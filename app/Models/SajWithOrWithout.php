<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SajWithOrWithout
 * 
 * @property int $id
 * @property string $name_en
 * @property string $name
 * @property int $delete_flag
 *
 * @package App\Models
 */
class SajWithOrWithout extends Model
{
	protected $table = 'saj_with_or_withouts';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'delete_flag' => 'int'
	];

	protected $fillable = [
		'id',
		'name_en',
		'name',
		'delete_flag'
	];
}
