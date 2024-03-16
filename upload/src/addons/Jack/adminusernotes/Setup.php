<?php

namespace Jack\adminusernotes;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

    // ################################ INSTALLATION ####################

	public function installStep1()
	{
		$sm = $this->schemaManager();

		foreach ($this->getTables() AS $tableName => $closure)
		{
			$sm->createTable($tableName, $closure);
		}
	}

    public function installStep2()
    {

	}

    public function installStep3()
    {

    }

    public function uninstallStep1()
    {
        $sm = $this->schemaManager();

		foreach (array_keys($this->getTables()) AS $tableName)
		{
			$sm->dropTable($tableName);
		}
    }

    public function uninstallStep2()
	{

    }

    public function uninstallStep3()
	{

    }

    public function postInstall(array &$stateChanges)
	{

	}
	

    // Helpers
    protected function getTables()
	{
		$tables = [];

		$tables['xf_jack_adminusernotes'] = function(Create $table)
		{
			$table->addColumn('note_id', 'int')->autoIncrement();
			$table->addColumn('user_id', 'int')->nullable()->setDefault(0);
			$table->addColumn('created_by', 'int')->nullable()->setDefault(0);
			$table->addColumn('creation_date', 'int')->setDefault(0);
			$table->addColumn('note', 'mediumtext');
			$table->addPrimaryKey('note_id');
			$table->addKey('user_id');
			$table->addKey('created_by');
		};

		return $tables;
	}

}