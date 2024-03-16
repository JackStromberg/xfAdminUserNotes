<?php

namespace Jack\adminusernotes\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Note extends Entity
{

	protected function verifyNote(&$value){
		if(!strlen($value)){
			$this->error(\XF::phrase('notes_error_enter_a_note'), 'note');
			return false;
		}

		return true;
	}

	public static function getStructure(Structure $structure)
	{
		$structure->table = 'xf_jack_adminusernotes';
		$structure->shortName = 'Jack:adminusernotes\adminusernotes';
		$structure->contentType = 'adminusernotes';
		$structure->primaryKey = 'note_id';
		$structure->columns = [
			'note_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
			'user_id' => ['type' => self::UINT, 'default' => false, 'nullable' => false],
			'created_by' => ['type' => self::UINT, 'default' => \XF::visitor()->user_id, 'nullable' => false],
			'creation_date' => ['type' => self::UINT, 'default' => \XF::$time],
			'note' => ['type' => self::STR, 'default' => '', 'required' => true],
		];
		$structure->getters = [
			'prefixes' => true,
			'draft_resource' => true
		];
		$structure->relations = [
			'User' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => [['user_id', '=', '$created_by']],
				'primary' => true,
			]
		];
		$structure->defaultWith = [
			'User'
		];

		return $structure;
	}
}