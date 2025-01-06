<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SajInjuryReport
 * 
 * @property int $id
 * @property string $email
 * @property string|null $score
 * @property int $reporter_type
 * @property string $reporter_name
 * @property int $discipline
 * @property string $site
 * @property string $country
 * @property int $category
 * @property string|null $competition
 * @property string|null $codex
 * @property Carbon $injured_date
 * @property string $name
 * @property int $gender
 * @property Carbon $birth_date
 * @property string $team
 * @property int $body_part_injured
 * @property int $injury_type
 * @property string|null $injury_type_other
 * @property int $side
 * @property int $expected_absence
 * @property string|null $multiple_injuries
 * @property int $consultation
 * @property string|null $specific_diagnosis
 * @property string|null $medical_certificate_path
 * @property string|null $diagnosing_doctor
 * @property string|null $doctor_affiliation
 * @property string|null $doctor_email_of_telno
 * @property string|null $multiple_injuries_tmp
 * @property int $circumstances
 * @property string|null $circumstance_other
 * @property int $binding_release
 * @property int $type_of_snow
 * @property string|null $type_of_snow_other
 * @property string $course_conditions
 * @property string|null $course_condition_other
 * @property string $weather_conditions
 * @property int $wind_conditions
 * @property int $video
 * @property string|null $video_path
 * @property string|null $explain
 * @property string|null $way_to_get_video
 * @property string|null $additional_information
 * @property string|null $reserve1
 * @property string|null $reserve2
 * @property string|null $reserve3
 * @property string|null $reserve4
 * @property string|null $reserve5
 * @property string|null $reserve6
 * @property string|null $reserve7
 * @property Carbon $create_time
 * @property Carbon $update_time
 * @property int $delete_flag
 *
 * @package App\Models
 */
class SajInjuryReport extends Model
{
	protected $table = 'saj_injury_reports';
	public $timestamps = false;

	protected $casts = [
		'reporter_type' => 'int',
		'discipline' => 'int',
		'category' => 'int',
		'injured_date' => 'datetime',
		'gender' => 'int',
		'birth_date' => 'datetime',
		'body_part_injured' => 'int',
		'injury_type' => 'int',
		'side' => 'int',
		'expected_absence' => 'int',
		'consultation' => 'int',
		'circumstances' => 'int',
		'binding_release' => 'int',
		'type_of_snow' => 'int',
		'wind_conditions' => 'int',
		'video' => 'int',
		'create_time' => 'datetime',
		'update_time' => 'datetime',
		'delete_flag' => 'int'
	];

	protected $fillable = [
		'email',
		'score',
		'reporter_type',
		'reporter_name',
		'discipline',
		'site',
		'country',
		'category',
		'competition',
		'codex',
		'injured_date',
		'name',
		'gender',
		'birth_date',
		'team',
		'body_part_injured',
		'injury_type',
		'injury_type_other',
		'side',
		'expected_absence',
		'multiple_injuries',
		'consultation',
		'specific_diagnosis',
		'medical_certificate_path',
		'diagnosing_doctor',
		'doctor_affiliation',
		'doctor_email_of_telno',
		'multiple_injuries_tmp',
		'circumstances',
		'circumstance_other',
		'binding_release',
		'type_of_snow',
		'type_of_snow_other',
		'course_conditions',
		'course_condition_other',
		'weather_conditions',
		'wind_conditions',
		'video',
		'video_path',
		'explain',
		'way_to_get_video',
		'additional_information',
		'reserve1',
		'reserve2',
		'reserve3',
		'reserve4',
		'reserve5',
		'reserve6',
		'reserve7',
		'create_time',
		'update_time',
		'delete_flag'
	];

    public function getTableColumns() { // 👈 テーブルのカラムを取得

        $table = $this->getTable();
        $columns = $this->getConnection()
            ->getSchemaBuilder()
            ->getColumnListing($table);
        $hidden_columns = $this->getHidden();
        return array_diff($columns, $hidden_columns); // hiddenとされているものを除外

    }

}
