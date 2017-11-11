@extends("layouts.app")

@section("content")

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Code Challenge - Github User Search</div>

                <div class="panel-body">

                  <div class="row">

                    <form action="/" method="post" id="searchForm">

                      <div class="form-group">
                        <label class="col-md-2 form-group">Search GitHub for User:</label>
                        <div class="col-md-6">
                          <input type="text" id="search" class="form-control">
                        </div>
                        <div class="col-md-4">
                          <button class="btn btn-primary">SEARCH</button>
                        </div>
                      </div>

                    </form>

                  </div>

                  <div id="results" class="well"></div>

                  <div class="alert alert-info" id="message"></div>

            </div>
        </div>
    </div>
</div>

<script>


  let pageNumberOfFollowers;
  let followersPerPage = 30;
  let selectedUser;

  // Handle form submission.
  $(document).ready(function() {
    $("#searchForm").submit( function(event) {
      event.preventDefault();

      // The form field value for username
      let searchUser = $(this).find("input[id=search]").val();

      // Clear the search field
      $(this).find("input[id=search]").val("");

      // If the username search value is an empty string, do nothing.
      if(searchUser.length > 0) {
        fetchUser(searchUser);
      }
      return false;
    });
  });

  function fetchUser(username) {
    $("#message").html("Searching for User...");
    $.get("/api/user?username="+username, handleSearchResponse);
  }

  // Handle the search response. Display the user if found. Display error if not.
  function handleSearchResponse(response) {

    $("#message").html("");

    // Remove all existing results
    $("#results").empty();

    if(response.login != undefined) {

      selectedUser = response;
      displayUser();
    }
    else if(response.message == "Not Found") {
      $("#results").append("<div>There are no results matching your search</div>");
    }
    else {
      $("#results").append("<div>An error occurred</div>");
    }


  }

  // Display the selected user information
  function displayUser() {

      // Reset the page number to 1 (first page of followers)
      pageNumberOfFollowers = 1;

      //console.log(pageNumberOfFollowers);

      // Remove search results
      $("#results").empty();

      // Add the user name and # of followers
      $("#results").append("<div class='row'><label class='col-md-3'>Username:</label><span class='col-md-9'>"+selectedUser.login+"</span></div>");
      $("#results").append("<div class='row'><label class='col-md-3'># of Followers:</label><span class='col-md-9'>"+selectedUser.followers+"</span></div>");

      // Add a div to display the followers
      $("#results").append("<div id='followersContainer'></div>");

      fetchFollowers(pageNumberOfFollowers);

    }

    function fetchFollowers(pageNumber) {
      $("#message").html("Fetching followers...");

      $("#followersContainer").empty();
      $("#followersContainer").append("<div id='followersNav' class='row'></div><div id='followers' class='row'></div>");

      url = "/api/followers?user="+selectedUser.login+"&page="+pageNumber;

      $.get(url, handlefetchFollowersResponse);

    }

    function handlefetchFollowersResponse(followers) {

      $("#message").html("");

      // Append a new div for each follower
      for(let i = 0; i < followers.length; i++) {
        let follower = followers[i];
        $('#followers').append("<div class='row'><a href='javascript:void(0);' class='col-md-2' onclick='fetchUser(\""+follower.login+"\")'>"+follower.login+"</a><div class='col-md-10'><img src='"+follower.avatar_url+"' width='50' height='50'></div>");
      }
      followerStartIndex = (pageNumberOfFollowers - 1) * followersPerPage + 1;
      followerEndIndex = followerStartIndex + followers.length - 1;
      $("#followersNav").append("<div class='col-md-3'><span>showing "+followerStartIndex+" - "+followerEndIndex+" of "+selectedUser.followers+" total followers</span></div>");

      // If there are previous followers, add a previous button
      if(pageNumberOfFollowers > 1) {
        $("#followersNav").append("<div class='col-md-3'><a href='javascript:void(0);' onclick='fetchPreviousPageOfFollowers();' class='btn btn-primary'>show previous followers</a></div>");
      }
      // If there are still more followers, add a next button
      if(selectedUser.followers > followersPerPage * pageNumberOfFollowers) {
        $("#followersNav").append("<div class='col-md-3'><a href='javascript:void(0);' onclick='fetchNextPageOfFollowers();' class='btn btn-primary'>show more followers</a></div>");
      }
    }

    function fetchPreviousPageOfFollowers() {
      pageNumberOfFollowers--;
      fetchFollowers(pageNumberOfFollowers);
    }

    function fetchNextPageOfFollowers() {
      pageNumberOfFollowers++;
      fetchFollowers(pageNumberOfFollowers);
    }
</script>

@stop
