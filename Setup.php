<?php

namespace ThemeHouse\StaffTracker;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Alter;

/**
 * Class Setup
 * @package ThemeHouse\StaffTracker
 */
class Setup extends AbstractSetup
{
    use StepRunnerInstallTrait;
    use StepRunnerUpgradeTrait;
    use StepRunnerUninstallTrait;

    /**
     *
     */
    public function installStep1()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_thread', function (Alter $table) {
            $table->addColumn('thstafftracker_staff_post_count', 'int')
                ->setDefault(0);
        });
    }

    /**
     * @param array $stateChanges
     */
    public function postInstall(array &$stateChanges)
    {
        $this->app->jobManager()->enqueue('XF:Thread');
    }

    /**
     *
     */
    public function uninstallStep1()
    {
        $schemaManager = $this->schemaManager();

        $schemaManager->alterTable('xf_thread', function (Alter $table) {
            $table->dropColumns([
                'thstafftracker_staff_post_count',
            ]);
        });
    }
}
