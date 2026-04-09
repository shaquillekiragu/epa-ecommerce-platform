<?php

$root = dirname(dirname(dirname(__DIR__)));

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', $root . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)));
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
