<?php
// Copyright (c) 2018 Institut fuer Lern-Innovation, Friedrich-Alexander-Universitaet Erlangen-Nuernberg, GPLv3, see LICENSE

include_once "Services/Cron/classes/class.ilCronJob.php";

class ilCombiSubscriptionCronJob  extends ilCronJob
{
	/** @var  ilCombiSubscriptionCronPlugin */
	protected $plugin;

	public function __construct($plugin)
	{
		$this->plugin = $plugin;
	}

	public function getId(): string
	{
		return "combi_subscription_cron";
	}

	public function getTitle(): string
	{
		return $this->plugin->txt('job_title');
	}

	public function getDescription(): string
	{
		if (!$this->plugin->checkSubscriptionPluginActive()) {
			return $this->plugin->txt('message_subscription_plugin_missing');
		}
		return $this->plugin->txt('job_description');
	}

	public function getDefaultScheduleType(): int
	{
		return self::SCHEDULE_TYPE_IN_HOURS;
	}

	public function getDefaultScheduleValue(): ?int
	{
		return 1;
	}

	public function hasAutoActivation(): bool
	{
		return true;
	}

	public function hasFlexibleSchedule(): bool
	{
		return true;
	}

	/**
	 * Defines whether or not a cron job can be started manually
	 * @return bool
	 */
	public function isManuallyExecutable(): bool
	{
		if (!$this->plugin->checkSubscriptionPluginActive()) {
			return false;
		}
		return parent::isManuallyExecutable();
	}

	/**
	 * Run the cron job
	 * @return ilCronJobResult
	 */
	public function run(): ilCronJobResult
	{
		$result = new ilCronJobResult();

		if (!$this->plugin->checkSubscriptionPluginActive())
		{
			$result->setStatus(ilCronJobResult::STATUS_INVALID_CONFIGURATION);
			$result->setMessage($this->plugin->txt('message_subscription_plugin_missing'));
			return $result;
		}
		else
		{
            /** @var ilCombiSubscriptionPlugin $subscriptionPlugin */
            $subscriptionPlugin = $this->plugin->getSubscriptionPlugin();
            $number = $subscriptionPlugin->handleCronJob();
            if ($number == 0)
            {
                $result->setStatus(ilCronJobResult::STATUS_NO_ACTION);
                $result->setMessage($this->plugin->txt('no_subscription_processed'));
            }
            elseif ($number == 1)
            {
                $result->setStatus(ilCronJobResult::STATUS_OK);
                $result->setMessage($this->plugin->txt('one_subscription_processed'));

            }
            else {
                $result->setStatus(ilCronJobResult::STATUS_OK);
                $result->setMessage(sprintf($this->plugin->txt('x_subscriptions_processed'), $number));
            }
            return $result;
        }
	}
}