<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware("VerifyApiKey")->group(function(){
    Route::get("home/",[ApiController::class,"Home"])->name("api.home");
    Route::post("profile/",[ApiController::class,"Profile"])->name("api.profile");
    Route::post("login/",[ApiController::class,"login"])->name("api.login");
    Route::post("check_code/",[ApiController::class,"check_code"])->name("api.check_code");
    Route::post("comments/",[ApiController::class,"comments"])->name("api.comments");
    Route::post("get/course",[ApiController::class,"GetCourse"])->name("get.course");
    Route::post("upload/avatar",[ApiController::class,"UploadAvatar"])->name("upload.avatar");
    Route::post("single/field",[ApiController::class,"GetField"])->name("get.field");
    Route::post("single/subfield",[ApiController::class,"GetSubfield"])->name("get.subfield");
    Route::get("all/courses",[ApiController::class,"AllCourse"])->name("all.courses");
    Route::get("all/podcasts",[ApiController::class,"AllPodcasts"])->name("all.podcasts");
});
