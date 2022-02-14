# CombiSubscriptionCron

Copyright (c) 2018-2022 Institut fuer Lern-Innovation, Friedrich-Alexander-Universitaet Erlangen-Nuernberg
GPLv3, see LICENSE

Author: Fred Neumann <fred.neumann@ili.fau.de>


This plugin for the LMS ILIAS open source allows the automated assignment of combined subscriptions.

It requires an installation of the CombiSubscription plugin:
https://github.com/ilifau/CombiSubscription


INSTALLATION
------------
1. Put the content of the plugin directory in a subdirectory under your ILIAS main directory:
Customizing/global/plugins/Services/Cron/CronHook/CombiSubscriptionCron

2. Open ILIAS > Administration > Plugins

3. Update/Activate the plugin


CONFIGURATION
-------------

You need to set up a call of the ILIAS cron jobs on your web server, see the ILIAS installation guide:
https://www.ilias.de/docu/goto_docu_pg_8240_367.html

1. Go to Administration > General Settings > Cron Jobs

2. Activate the 'Combined Subscription' job

3. Set a reasonable schedule for the job, e.h. hourly.


USAGE
-----

See the documentation of the CombiSubscription plugin.


VERSIONS
--------

1.3.0 for ILIAS 7 (2022-02-14)
- Update for ILIAS 7
- Removed unneccessay catching of exceptions

1.0.0 for ILIAS 5.1 (2018-02-27)
- initial version
