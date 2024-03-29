<?php

/*
|--------------------------------------------------------------------------
| Register The Artisan Commands
|--------------------------------------------------------------------------
|
| Each available Artisan command must be registered with the console so
| that it is available to be called. We'll register every command so
| the console gets access to each of the command object instances.
|
*/

Artisan::add(new CheckTranscodedVideoStatusCommand);
Artisan::add(new InstructorCashoutCommand);
Artisan::add(new AffiliateCashoutCommand);
//Artisan::add(new InstructorAgencyCashoutCommand);
Artisan::add(new StudentBalanceDebitRefundCommand);
Artisan::add(new DynamoGCCommand);
Artisan::add(new SetupCashoutCommand);
Artisan::add(new ConsolidateCoursesCommand);
Artisan::add(new ImportToDeliveredCommand);
Artisan::add(new TaskerCommand);
Artisan::add(new InstructorDiscussionNotificationCommand);

