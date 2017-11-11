<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use FlexyProject\GitHub\Client;

class UserSearchController extends Controller
{

    // Run a search for a user, return the response from Github API request
    public function runSearch(Request $request) {
      // Create a client to make a request to GitHub
      $client = new Client();

      // Set the authentication values
      $client->setClientId(env('GITHUB_CLIENT_ID'));
      $client->setClientSecret(env('GITHUB_CLIENT_SECRET'));

      $users = $client->getReceiver(Client::USERS);

      return $users->getSingleUser($request->username);
    }
}
