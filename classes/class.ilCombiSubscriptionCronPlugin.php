<?php
// Copyright (c) 2018 Institut fuer Lern-Innovation, Friedrich-Alexander-Universitaet Erlangen-Nuernberg, GPLv3, see LICENSE

include_once("./Services/Cron/classes/class.ilCronHookPlugin.php");

class ilCombiSubscriptionCronPlugin extends ilCronHookPlugin
{
	function getPluginName()
	{
		return "CombiSubscriptionCron";
	}

	function getCronJobInstances()
	{
		return array($this->getCronJobInstance('combi_subscription_cron'));
	}

	function getCronJobInstance($a_job_id)
	{
		$this->includeClass('class.ilCombiSubscriptionCronJob.php');
		return new ilCombiSubscriptionCronJob($this);
	}

	/**
	 * Do checks bofore activating the plugin
	 * @return bool
	 * @throws ilPluginException
	 */
	function beforeActivation()
	{
		if (!$this->checkSubscriptionPluginActive()) {
			ilUtil::sendFailure($this->txt("message_subscription_plugin_missing"), true);
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
        /** @var ilPluginAdmin $ilPluginAdmin */
        $ilPluginAdmin = $DIC['ilPluginAdmin'];

		return $ilPluginAdmin->isActive('Services', 'Repository', 'robj', 'CombiSubscription');
	}

	/**
	 * Get the subscription plugin object
	 * @return ilPlugin
	 */
	public function getSubscriptionPlugin()
	{
		return ilPluginAdmin::getPluginObject('Services', 'Repository', 'robj', 'CombiSubscription');
	}
}