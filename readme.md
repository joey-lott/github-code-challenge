<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## NOTES

- Uses the following library to do the heavy lifting for making calls to GitHub API - https://github.com/FlexyProject/GitHubAPI
- Uses authentication (token) to avoid 60 requests/hour rate limit.
- You will need to set the GITHUB_CLIENT_ID and GITHUB_CLIENT_SECRET in .env. If you do not have client ID and client secret, you will need to register a github app. Otherwise, I can supply ID and secret.
- Routes for API calls are in api.php
- Routes for web calls are in web.php
- If no user matches the search, handled gracefully with message to user
- Followers are clickable. Runs new search for selected follower as user.
