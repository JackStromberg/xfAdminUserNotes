<?php

namespace Jack\adminusernotes\XF\Admin\Controller;

use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;

class User extends XFCP_User
{

	public function actionAdminUserNotes(ParameterBag $params)
	{
		$user = $this->assertUserExists($params->user_id);

		if($this->isPost()){
			$input = $this->filter([
				'note' => 'str',
			]);

			$note = $this->em()->create('Jack\adminusernotes:Note');
			$note->note = $input['note'];
			$note->user_id = $params->user_id;
			$note->save();

			return $this->redirect($this->buildLink('users/edit#user-admin-user-notes',['user_id'=>$user->user_id]),'Note added!');
		}

		$page = $this->filterPage();
		$perPage = 20;

		$noteRepo = $this->repository('Jack\adminusernotes:Note');
		$notes = $noteRepo->getNotesByUser($user->user_id)->limitByPage($page, $perPage)->fetch();

		$viewParams = [
			'user' => $user,
			'notes' => $notes,
			'page' => $page,
			'perPage' => $perPage,
			'total' => count($notes)
		];
		return $this->view('XF:User\AdminUserNotes', 'admin_user_notes', $viewParams);
	}

}