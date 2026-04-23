<?php

namespace console\controllers;

use yii\base\Controller;

class SeedController extends Controller
{
    public function actionSeedUser($debug = 0, $batchsize = 250) // you can add more params here
    {
        echo 'Hello';

        

        // use insert into query to insert array of users
        // in batches do a foreach to insert batches of users into the table
        // for each user record, create both an address and a useraddress record
        // do the address in the same foreach but do the linkups in their own batches
        // find a use the yii progress bar functionality - or echo progress stages eg 'Adding users...'
        // pass a number into this function to see a number
        // you can switch between debug mode or deploy mode (one will show the echoes and one won't)
        // php yii seed/seed-user 0 (1 is debug mode)
    }

    // you can create another function here to handle 'undo actions' like 'actionClearUserTable'
}
