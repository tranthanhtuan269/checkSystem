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
  </head>
  <body>
    <div class="container">
    	<div class="row">
    		<div class="col-md-12 text-center my-5">
    			<h1>Hệ thống quản lý website của TOH soft</h1>
    		</div>
    	</div>
      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-3"></div>
        <div class="col-md-6 float-right text-right my-2">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#emailModel">
            <i class="fa fa-plus-square" aria-hidden="true"></i> Thay đổi email
          </button>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-plus-square" aria-hidden="true"></i> Thêm mới website
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
    <div class="modal fade" id="emailModel" tabindex="-1" role="dialog" aria-labelledby="emailModelLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header text-center">
            <h5 class="modal-title" id="emailModelLabel">Thay đổi email nhận thông báo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                  <input type="text" name="email" class="form-control" id="emailtxt" value="{{ $email->email }}">
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="update-btn">Save</button>
          </div>
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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

                
        $('#update-btn').click(function(){
          var object_email = $('#emailtxt').val();

          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          var request = $.ajax({
            url: "{{ url('/') }}/update-email",
            method: "POST",
            data: { 
              email : object_email,
            },
            dataType: "json"
          });
          
          request.done(function( msg ) {
            $('#emailModel').modal('toggle')
            swal("Tuyệt!", "Email đã được cập nhật!", "success");
          });
          
          request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
          });
        })

        
        $('#save-btn').click(function(){
          var object_name = $('#nametxt').val();
          var object_link = $('#linktxt').val();

          if(object_name.length == 0){
            swal("Ồ!", "Tên website không được để trống!", "error");
            return false;
          }

          if(object_link.length == 0){
            swal("Ồ!", "Link website không được để trống!", "error");
            return false;
          }

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