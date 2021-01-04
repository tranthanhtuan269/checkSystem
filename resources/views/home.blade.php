@extends('master')
@section('content')
    <div class="clearfix mb-3">
      <div class="float-right">
        <button type="button" class="btn-sm btn btn-primary" data-toggle="modal" data-target="#createModel">
          <i class="fa fa-plus-square" aria-hidden="true"></i> Thêm mới website
        </button>
      </div>
    </div>
    <ul class="list-group list-website clearfix">
      @foreach($websites as $website)
        @if($website->status == 1)
        <li class="list-group-item list-group-item-success item-{{ $website->id }}">
          <a id="website-{{ $website->id }}" href="{{ $website->link }}">{{ $website->name }}</a>
          <button type="button" class="btn-sm btn btn-danger float-right remove-btn" data-id="{{ $website->id }}">
            <i class="fa fa-times" aria-hidden="true"></i> Xóa
          </button>
          <button type="button" class="btn-sm btn btn-primary float-right edit-btn mx-2" data-id="{{ $website->id }}">
            <i class="fa fa-pencil" aria-hidden="true"></i> Sửa
          </button>
          <a style="color: #fff" class="btn-sm btn btn-secondary float-right edit-btn mx-2" href="{{ route('client.show-statistical') }}?web={{ $website->name }}" target="_blank">
            <i class="fa fa-area-chart" aria-hidden="true"></i> Thống kê
          </a>
        </li>
        @else
        <li class="list-group-item list-group-item-danger item-{{ $website->id }}">
          <a id="website-{{ $website->id }}" href="{{ $website->link }}">{{ $website->name }}</a>
          <button type="button" class="btn-sm btn btn-danger float-right remove-btn" data-id="{{ $website->id }}">
            <i class="fa fa-times" aria-hidden="true"></i> Xóa
          </button>
          <button type="button" class="btn-sm btn btn-primary float-right edit-btn mx-2" data-id="{{ $website->id }}">
            <i class="fa fa-pencil" aria-hidden="true"></i> Sửa
          </button>
          <a style="color: #fff" class="btn-sm btn btn-secondary float-right edit-btn mx-2" href="{{ route('client.show-statistical') }}?web={{ $website->name }}" target="_blank">
            <i class="fa fa-area-chart" aria-hidden="true"></i> Thống kê
          </a>
        </li>
        @endif
      @endforeach
    </ul>

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
            <button type="button" class="btn-sm btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn-sm btn btn-primary" id="save-btn">Save</button>
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
            <button type="button" class="btn-sm btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn-sm btn btn-primary" id="update-btn">Save</button>
          </div>
        </div>
      </div>
    </div>

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
              $html += '<button type="button" class="btn-sm btn btn-danger float-right remove-btn" data-id="'+obj.id_website+'">';
              $html += '<i class="fa fa-times" aria-hidden="true"></i> Xóa';
              $html += '</button>';
              $html += '<button type="button" class="btn-sm btn btn-primary float-right edit-btn mx-2" data-id="'+obj.id_website+'">';
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
@endsection