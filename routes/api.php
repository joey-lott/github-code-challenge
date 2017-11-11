<?php

use Illuminate\Http\Request;
use GrahamCampbell\GitHub\Facades\GitHub;
use FlexyProject\GitHub\Client;
use FlexyProject\GitHub\Pagination;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
  // Create a client to make a request to GitHub
  $client = new Client();

  // Set the authentication values
  $client->setClientId(env('GITHUB_CLIENT_ID'));
  $client->setClientSecret(env('GITHUB_CLIENT_SECRET'));

  $users = $client->getReceiver(Client::USERS);

  return $users->getSingleUser($request->username);
});

Route::get('/followers', function (Request $request) {
  // Set a default for page
  $page = isset($request->page) ? $request->page : 1;

  // Create a client to make a request to GitHub
  $client = new Client();

  // Set the authentication values
  $client->setClientId(env('GITHUB_CLIENT_ID'));
  $client->setClientSecret(env('GITHUB_CLIENT_SECRET'));

  // Set the page number
  $pagination = new Pagination();
  $pagination->setPage($page);

  $client->setPagination($pagination);

  $users = $client->getReceiver(Client::USERS);
  $followers = $users->getReceiver(\FlexyProject\GitHub\Receiver\Users::FOLLOWERS);
  $pageOfFollowers = $followers->listFollowers($request->user);

  return $pageOfFollowers;
});
