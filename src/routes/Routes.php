<?php

$app->get('/', \App\Controllers\HomeController::class . ':home')->setName('home');
$app->get('/news', \App\Controllers\HomeController::class . ':news')->setName('news');
$app->get('/event', \App\Controllers\HomeController::class . ':event')->setName('event');

$app->get('/signin', \App\Controllers\SigninController::class . ':signinPage')->setName('signin');
$app->post('/signin', \App\Controllers\SigninController::class . ':checkSingin');
$app->post('/signout', \App\Controllers\SigninController::class . ':signout')->setName('signout');

$app->get('/profile/{id}', \App\Controllers\ProfileController::class . ':Profile')->setName('profile');
$app->post('/profile/{id}', \App\Controllers\ProfileController::class . ':updateProfile');
$app->post('/uploadpic', \App\Controllers\ProfileController::class . ':uploadPicture')->setName('profile.pic');
$app->post('/commemt', \App\Controllers\ProfileController::class . ':updateComment')->setName('profile.comment'); 

$app->get('/course', \App\Controllers\CourseController::class . ':viewCourse')->setName('course.view'); 
$app->post('/upload_course', \App\Controllers\CourseController::class . ':uploadCourse')->setName('course.upload');

$app->get('/teachers', \App\Controllers\ListController::class . ':teacherList')->setName('teachers'); 
$app->get('/students', \App\Controllers\ListController::class . ':studentList')->setName('students'); 
$app->get('/student/{year}', \App\Controllers\ListController::class . ':student')->setName('student'); 
