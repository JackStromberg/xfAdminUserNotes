<?php

namespace Jack\adminusernotes\Repository;

use \XF\Mvc\Entity\Repository;

class Note extends Repository
{

	public function getNotesByUser($userId)
	{
		$resourceFinder = $this->finder('Jack\adminusernotes:Note');

		$resourceFinder->where('user_id', $userId)
			->setDefaultOrder('note_id', 'desc');

		return $resourceFinder;
	}

}