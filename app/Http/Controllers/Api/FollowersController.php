<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use FlexyProject\GitHub\Client;
use FlexyProject\GitHub\Pagination;

class FollowersController extends Controller
{

    // Make a request to Github for a page of followers
    public function fetchFollowers(Request $request) {
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
    }
}
