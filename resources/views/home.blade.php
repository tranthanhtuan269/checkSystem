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
        <div class="col-md-12 float-right text-right my-2">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModel">
            <i class="fa fa-plus-square" aria-hidden="true"></i> Thêm mới website
          </button>
        </div>
        <div class="col-md-3">
        <ul class="list-group">
          <li class="list-group-item active">Quản lý website</li>
          <li class="list-group-item"><a href="{{ url('/emails') }}">Quản lý Email</a></li>
          <li class="list-group-item"><a href="{{ url('/settings') }}">Quản lý Cấu hình</a></li>
        </ul>
        </div>
        <div class="col-md-9">
          <div class="row">
            <div class="col-md-12">
              <ul class="list-group list-website">
                @foreach($websites as $website)
                  @if($website->status == 1)
                  <li class="list-group-item list-group-item-success item-{{ $website->id }}">
                    <a id="website-{{ $website->id }}" href="{{ $website->link }}">{{ $website->name }}</a>
                    <button type="button" class="btn btn-danger float-right remove-btn" data-id="{{ $website->id }}">
                      <i class="fa fa-times" aria-hidden="true"></i> Xóa
                    </button>
                    <button type="button" class="btn btn-primary float-right edit-btn mx-2" data-id="{{ $website->id }}">
                      <i class="fa fa-pencil" aria-hidden="true"></i> Sửa
                    </button>
                  </li>
                  @else
                  <li class="list-group-item list-group-item-danger item-{{ $website->id }}">
                    <a id="website-{{ $website->id }}" href="{{ $website->link }}">{{ $website->name }}</a>
                    <button type="button" class="btn btn-danger float-right remove-btn" data-id="{{ $website->id }}">
                      <i class="fa fa-times" aria-hidden="true"></i> Xóa
                    </button>
                    <button type="button" class="btn btn-primary float-right edit-btn mx-2" data-id="{{ $website->id }}">
                      <i class="fa fa-pencil" aria-hidden="true"></i> Sửa
                    </button>
                  </li>
                  @endif
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="createModel" tabindex="-1" role="dialog" aria-labelledby="emailModelLabel" aria-hidden="true">
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

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header text-center">
            <h5 class="modal-title" id="exampleModalLabel">Sửa website</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                  <input type="text" name="name" class="form-control" id="edtnametxt" value="">
                </div>
              </div>
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Link</label>
                <div class="col-sm-10">
                  <input type="text" name="link" class="form-control" id="edtlinktxt" value="">
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

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ url('/') }}/js/jquery-3.2.1.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
      $(document).ready(function(){
        action();
        function action(){
          $('.edit-btn').off('click');
          $('.edit-btn').click(function(){
            $('#edtnametxt').val($('#website-' + $(this).attr('data-id')).text());
            $('#edtlinktxt').val($('#website-' + $(this).attr('data-id')).attr('href'));
            $('#update-btn').attr('data-id', $(this).attr('data-id'));
            $('#editModal').modal('toggle')
          })

          $('.remove-btn').off('click');
          $('.remove-btn').click(function(){
            var self = $(this);

            swal({
              title: "Bạn có chắc chắn muốn xóa Website này?",
              text: "Nếu bạn xóa, bạn sẽ không thể phục hồi nó!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
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
              }
            });
          })
        }
                
        $('#update-btn').click(function(){
          var object_id = $('#update-btn').attr('data-id');
          var object_name = $('#edtnametxt').val();
          var object_link = $('#edtlinktxt').val();

          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          var request = $.ajax({
            url: "{{ url('/') }}/update-website",
            method: "POST",
            data: { 
              id : object_id,
              name : object_name,
              link : object_link,
            },
            dataType: "json"
          });
          
          request.done(function( msg ) {
            $('#emailModel').modal('toggle')
            swal("Tuyệt!", "Website đã được cập nhật!", "success");
            $('#editModal').modal('toggle')
            $('#website-' + object_id).text(object_name);
            $('#website-' + object_id).attr('href', object_link);
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
                $html = '<li class="list-group-item list-group-item-success item-'+obj.id_website+'">';
              }else{
                $html = '<li class="list-group-item list-group-item-danger item-'+obj.id_website+'">';
              }
              $html += '<a id="website-'+obj.id_website+'" href="'+obj.link_website+'">'+obj.name_website+'</a>';
              $html += '<button type="button" class="btn btn-danger float-right remove-btn" data-id="'+obj.id_website+'">';
              $html += '<i class="fa fa-times" aria-hidden="true"></i> Xóa';
              $html += '</button>';
              $html += '<button type="button" class="btn btn-primary float-right edit-btn mx-2" data-id="'+obj.id_website+'">';
              $html += '<i class="fa fa-pencil" aria-hidden="true"></i> Sửa';
              $html += '</button>';
              $html += '</li>';
            }
            $('.list-website').append($html);
            $('#nametxt').val('');
            $('#linktxt').val('');
            $('#createModel').modal('toggle');
            action();
          });
          
          request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
          });
        })
      })
    </script>
  </body>
</html>