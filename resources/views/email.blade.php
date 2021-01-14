@extends('master')
@section('content')
    <div class="clearfix mb-3">
      <div class="float-right">
        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createModal">
          <i class="fa fa-plus-square" aria-hidden="true"></i> Thêm mới email
        </button>
      </div>
    </div>
    <ul class="list-group list-email">
      @foreach($emails as $email)
        <li class="list-group-item list-group-item-success item-{{ $email->id }}">
          <span id="email-{{ $email->id }}">{{ $email->email }}</span>
          <button type="button" class="btn btn-sm btn-danger float-right remove-btn" data-id="{{ $email->id }}" data-toggle="modal" data-target="#editModel">
            <i class="fa fa-times" aria-hidden="true"></i> Xóa
          </button>
          <button type="button" class="btn btn-sm btn-primary float-right edit-btn mx-2" data-id="{{ $email->id }}" data-toggle="modal" data-target="#editModel">
            <i class="fa fa-pencil" aria-hidden="true"></i> Sửa
          </button>
        </li>
      @endforeach
    </ul>
    
      <!-- Modal -->
      <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="emailModelLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header text-center">
                <h5 class="modal-title" id="emailModelLabel">Thêm mới email nhận thông báo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form>
                  <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="text" name="email" class="form-control" id="emailtxt" value="">
                      <div class="alert-email"></div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="save-btn">Lưu</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
              </div>
            </div>
          </div>
        </div>
    
        <!-- Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header text-center">
                <h5 class="modal-title" id="exampleModalLabel">Sửa email nhận thông báo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form>
                  <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="text" name="email" class="form-control" id="edtemailtxt" value="">
                      <div class="alert-email"></div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="update-btn"> Lưu </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
              </div>
            </div>
          </div>
        </div>
    <script>
      $(document).ready(function(){
        function clearForm() {
          $('.alert-error').html('')
          $('#createModal input').val('');
        }

        $("#createModal, #editModal").on("hidden.bs.modal", function () {
          clearForm()
        });
        
        action();
        function action(){
          $('.edit-btn').off('click');
          $('.edit-btn').click(function(){
            $('#edtemailtxt').val($('#email-' + $(this).attr('data-id')).text());
            $('#update-btn').attr('data-id', $(this).attr('data-id'));
            $('#editModal').modal('toggle')
          })
    
          $('.remove-btn').off('click');
          $('.remove-btn').click(function(){
            var self = $(this);
            swal({
              title: "Bạn có chắc chắn muốn xóa Email này?",
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
                  url: "{{ url('/') }}/remove-email",
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
          var object_email = $('#edtemailtxt').val();
    
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          $.ajax({
              url: "{{ url('/') }}/update-email",
              method: "POST",
              data: { 
                id : object_id,
                email : object_email.trim(),
              },
              beforeSend: function(r, a){
                  $(".ajax_waiting").addClass("loading");
              },
              complete: function() {
                  $(".ajax_waiting").removeClass("loading");
              },
              success: function (obj) {
                  if(obj.status == 200){
                    swal("Tuyệt!", "Email đã được cập nhật!", "success");
                    $('#editModal').modal('toggle');
                    $('#email-' + object_id).text(object_email);
                  } else {
                      $.each(obj.errors, function( index, value ) {
                          $('.alert-' + index).html(value).addClass('alert-error');
                      });
                  }
              },
              error: function (data) {

              }
          });

        })
    
        
        $('#save-btn').click(function(){
          var object_email = $('#emailtxt').val();
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          $.ajax({
              url: "{{ url('/') }}/add-email",
              method: "POST",
              data: { 
                email : object_email.trim(),
              },
              beforeSend: function(r, a){
                  $(".ajax_waiting").addClass("loading");
              },
              complete: function() {
                  $(".ajax_waiting").removeClass("loading");
              },
              success: function (obj) {
                  if(obj.status == 200){
                    $html = '<li class="list-group-item list-group-item-success">';
                    $html += '<span id="email-'+obj.id+'">'+ obj.email + '</span>';
                    $html += '<button type="button" class="btn btn-sm btn-danger float-right remove-btn" data-id="'+obj.id+'">';
                    $html += '<i class="fa fa-times" aria-hidden="true"></i> Xóa';
                    $html += '</button>';
                    $html += '<button type="button" class="btn btn-sm btn-primary float-right edit-btn mx-2" data-id="'+obj.id+'" data-toggle="modal" data-target="#editModel">';
                    $html += '<i class="fa fa-pencil" aria-hidden="true"></i> Sửa';
                    $html += '</button>';
                    $html += '</li>';
                    $('.list-email').append($html);
                    $('#emailtxt').val('');
                    $('#createModal').modal('toggle');
                    clearForm();
                    action();
                  } else {
                      $.each(obj.errors, function( index, value ) {
                          $('.alert-' + index).html(value).addClass('alert-error');
                      });
                  }
              },
              error: function (data) {

              }
          });

        })
      })
    </script>
@endsection