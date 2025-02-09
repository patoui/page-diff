<?php


$image1 = new Imagick(__DIR__ . '/baseline/Tests_Browser_WelcomeTest::testWelcome.png');
$image2 = new Imagick(__DIR__ . '/screenshots/Tests_Browser_WelcomeTest::testWelcome.png');

[$image, $difference] = $image1->compareImages($image2, Imagick::METRIC_MEANABSOLUTEERROR);
$image->setImageFormat("png");
$image->writeImage("diff.png");

echo sprintf("Percentage difference: %s%%\n", round($difference * 100, 2));
