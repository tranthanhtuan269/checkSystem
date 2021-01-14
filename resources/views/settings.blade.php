@extends('master')
@section('content')
        <ul class="list-group list-settings">
          <li class="list-group-item list-group-item-success">
            <form>
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Thời gian kiểm tra</label>
                <div class="col-sm-8">
                  <select class="custom-select mr-sm-2" id="timeInterval">
                    <option value="0" @if($config->value == 0) selected @endif>Chọn 1 khoảng thời gian...</option>
                    <option value="1" @if($config->value == 1) selected @endif>Mỗi giờ</option>
                    <option value="2" @if($config->value == 2) selected @endif>Mỗi 3 giờ</option>
                    <option value="3" @if($config->value == 3) selected @endif>Mỗi 6 giờ</option>
                    <option value="4" @if($config->value == 4) selected @endif>Mỗi 12 giờ</option>
                    <option value="5" @if($config->value == 5) selected @endif>Mỗi ngày</option>
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
@endsection