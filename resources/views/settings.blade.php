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
        <div class="col-md-3">
          <ul class="list-group">
            <li class="list-group-item"><a href="{{ url('/') }}">Quản lý website</a></li>
            <li class="list-group-item"><a href="{{ url('/emails') }}">Quản lý Email</a></li>
            <li class="list-group-item active">Quản lý Cấu hình</li>
          </ul>
        </div>
        <div class="col-md-9">
          <div class="row">
            <div class="col-md-12">
              <ul class="list-group list-settings">
                <li class="list-group-item list-group-item-success">
                  <form>
                    <div class="form-group row">
                      <label for="staticEmail" class="col-sm-4 col-form-label">Thời gian kiểm tra</label>
                      <div class="col-sm-8">
                        <select class="custom-select mr-sm-2" id="timeInterval">
                          <option value="0" selected>Chọn 1 khoảng thời gian...</option>
                          <option value="1">Mỗi phút</option>
                          <option value="2">Mỗi 5 phút</option>
                          <option value="3">Mỗi 10 phút</option>
                          <option value="4">Mỗi 15 phút</option>
                          <option value="5">Mỗi 30 phút</option>
                          <option value="6">Mỗi giờ</option>
                          <option value="7">Mỗi 3 giờ</option>
                          <option value="8">Mỗi 6 giờ</option>
                          <option value="9">Mỗi 12 giờ</option>
                          <option value="10">Mỗi ngày</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-12 text-center">
                        <div class="btn btn-primary" id="save-btn">Save</div>
                      </div>
                    </div>
                  </form>
                </li>
              </ul>
            </div>
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
    <script type="text/javascript">
      $(document).ready(function(){
        $('#save-btn').click(function(){
          var object_setting = $('#timeInterval').val();

          if(object_setting == 0){
            swal("Ồ!", "Bạn chưa chọn khoảng thời gian kiểm tra!", "error");
            return false;
          }

          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          var request = $.ajax({
            url: "{{ url('/') }}/save-config",
            method: "POST",
            data: { 
              setting : object_setting,
            },
            dataType: "json"
          });
          
          request.done(function( msg ) {
            swal("Tuyệt!", "Cấu hình đã được cập nhật!", "success");
          });
          
          request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
          });
        })
      })
    </script>
  </body>
</html>