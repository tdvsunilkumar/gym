<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

Class GymProfileTable extends Table{
	public function initialize(array $config)
	{
		$this->BelongsTo("GymMember");
	}
	// public function validatePasswords($validator)
	// {
		// $validator->add('confirm_password', 'no-misspelling', [
			// 'rule' => ['compareWith', 'password'],
			// 'message' => 'Passwords are not equal',
		// ]);
		
		// return $validator;
	// }
}