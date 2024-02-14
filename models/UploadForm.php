<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
* UploadForm is the model behind the upload form.
*/
class UploadForm extends Model
{
	/**
	 * @var UploadedFile|Null file attribute
	 */
	public $login_logo;
	public $user_logo;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			[['login_logo'], 'file'],
			[['user_logo'], 'file'],
		];
	}
}
?>