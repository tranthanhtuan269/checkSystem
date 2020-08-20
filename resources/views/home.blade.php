<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Hello, world!</title>
    <style>
      /* The Overlay (background) */
      .overlay {
        /* Height & width depends on how you want to reveal the overlay (see JS below) */   
        height: 100%;
        width: 0;
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        background-color: rgb(0,0,0); /* Black fallback color */
        background-color: rgba(0,0,0, 0.9); /* Black w/opacity */
        overflow-x: hidden; /* Disable horizontal scroll */
        transition: 0.5s; /* 0.5 second transition effect to slide in or slide down the overlay (height or width, depending on reveal) */
      }

      /* Position the content inside the overlay */
      .overlay-content {
        position: relative;
        top: 25%; /* 25% from the top */
        width: 100%; /* 100% width */
        text-align: center; /* Centered text/links */
        margin-top: 30px; /* 30px top margin to avoid conflict with the close button on smaller screens */
      }

      /* The navigation links inside the overlay */
      .overlay a {
        padding: 8px;
        text-decoration: none;
        font-size: 36px;
        color: #818181;
        display: block; /* Display block instead of inline */
        transition: 0.3s; /* Transition effects on hover (color) */
      }

      /* When you mouse over the navigation links, change their color */
      .overlay a:hover, .overlay a:focus {
        color: #f1f1f1;
      }

      /* Position the close button (top right corner) */
      .overlay .closebtn {
        position: absolute;
        top: 20px;
        right: 45px;
        font-size: 60px;
      }

      /* When the height of the screen is less than 450 pixels, change the font-size of the links and position the close button again, so they don't overlap */
      @media screen and (max-height: 450px) {
        .overlay a {font-size: 20px}
        .overlay .closebtn {
          font-size: 40px;
          top: 15px;
          right: 35px;
        }
      }
    </style>
  </head>
  <body>
    <!-- The overlay -->
    <div id="myNav" class="overlay">
      <!-- Overlay content -->
      <div class="overlay-content">
        <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
    </div>
    <div class="container">
    	<div class="row">
    		<div class="col-md-12 text-center my-5">
    			<h1>Hệ thống quản lý website của TOH soft</h1>
    		</div>
    	</div>
      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-3"></div>
        <div class="col-md-3"></div>
        <div class="col-md-3 float-right text-right my-2">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-plus-square" aria-hidden="true"></i> Thêm mới
          </button>
        </div>
      </div>
    	<div class="row">
    		<div class="col-md-12">
				<ul class="list-group">
          @foreach($websites as $website)
            @if($website->status == 1)
            <li class="list-group-item list-group-item-success">
              <a href="{{ $website->link }}">{{ $website->name }}</a>
              <button type="button" class="btn btn-danger float-right remove-btn" data-id="{{ $website->id }}">
                <i class="fa fa-times" aria-hidden="true"></i> Xóa
              </button>
            </li>
            @else
            <li class="list-group-item list-group-item-danger">
              <a href="{{ $website->link }}">{{ $website->name }}</a>
              <button type="button" class="btn btn-danger float-right remove-btn" data-id="{{ $website->id }}">
                <i class="fa fa-times" aria-hidden="true"></i> Xóa
              </button>
            </li>
            @endif
          @endforeach
				</ul>
    		</div>
    	</div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header text-center">
            <h5 class="modal-title" id="exampleModalLabel">Thêm mới website</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                  <input type="text" name="name" class="form-control" id="nametxt" value="">
                </div>
              </div>
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Link</label>
                <div class="col-sm-10">
                  <input type="text" name="link" class="form-control" id="linktxt" value="">
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="save-btn">Save</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ url('/') }}/js/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
      $(document).ready(function(){
        $('.remove-btn').click(function(){
          var self = $(this);
          var object_id = $(this).attr('data-id');
          
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          var request = $.ajax({
            url: "{{ url('/') }}/remove-website",
            method: "POST",
            data: { id : object_id },
            dataType: "json"
          });
          
          request.done(function( msg ) {
            self.parent().remove();
          });
          
          request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
          });
        })

        
        $('#save-btn').click(function(){
          document.getElementById("myNav").style.display = "block";

          var object_name = $('#nametxt').val();
          var object_link = $('#linktxt').val();

          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          var request = $.ajax({
            url: "{{ url('/') }}/add-website",
            method: "POST",
            data: { 
              name : object_name,
              link : object_link,
            },
            dataType: "json"
          });
          
          request.done(function( msg ) {
            document.getElementById("myNav").style.display = "none";
            var obj = msg;
            if(obj.message == "OK"){
              $html = '';
              if(obj.status_website == 1){
                $html = '<li class="list-group-item list-group-item-success">';
              }else{
                $html = '<li class="list-group-item list-group-item-danger">';
              }
              $html += '<a href="'+object_link+'">'+object_name+'</a>';
              $html += '<button type="button" class="btn btn-danger float-right remove-btn" data-id="'+obj.id_website+'">';
              $html += '<i class="fa fa-times" aria-hidden="true"></i> Xóa';
              $html += '</button>';
              $html += '</li>';
            }
            $('.list-group').append($html);
            $('#nametxt').val('')
            $('#linktxt').val('')
            $('#exampleModal').modal('toggle')
          });
          
          request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
          });
        })
      })
    </script>
  </body>
</html>