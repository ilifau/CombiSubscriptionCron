<?php
// Copyright (c) 2018 Institut fuer Lern-Innovation, Friedrich-Alexander-Universitaet Erlangen-Nuernberg, GPLv3, see LICENSE

include_once("./Services/Cron/classes/class.ilCronHookPlugin.php");

class ilCombiSubscriptionCronPlugin extends ilCronHookPlugin
{
	function getPluginName(): string
	{
		return "CombiSubscriptionCron";
	}

	function getCronJobInstances(): array
	{
		return array($this->getCronJobInstance('combi_subscription_cron'));
	}

	function getCronJobInstance($a_job_id): ilCronJob
	{
		return new ilCombiSubscriptionCronJob($this);
	}

	/**
	 * Do checks bofore activating the plugin
	 * @return bool
	 * @throws ilPluginException
	 */
	function beforeActivation(): bool
	{
		global $DIC;

		if (!$this->checkSubscriptionPluginActive()) {
			$DIC->ui()->mainTemplate()->setOnScreenMessage('failure', $this->txt("message_subscription_plugin_missing"), true);
			// this does not show the message
			// throw new ilPluginException($this->txt("message_creator_plugin_missing"));
			return false;
		}

		return parent::beforeActivation();
	}

	/**
	 * Check if the subscription plugin is active
	 * @return bool
	 */
	public function checkSubscriptionPluginActive()
	{
    	global $DIC;

        /** @var ilComponentFactory $factory */
        $factory = $DIC["component.factory"];

        /** @var ilPlugin $plugin */
        foreach ($factory->getActivePluginsInSlot('robj') as $plugin) {
            if ($plugin->getPluginName() == 'CombiSubscription') {
                return $plugin->isActive();
            }
        }
        return false;

	}

	/**
	 * Get the subscription plugin object
	 * @return ilPlugin
	 */
	public function getSubscriptionPlugin()
	{
		global $DIC;

        /** @var ilComponentFactory $factory */
        $factory = $DIC["component.factory"];

		return $factory->getPlugin('xcos');
	}
}