@extends('master')
@section('content')
    <div class="clearfix mb-3">
      <div class="float-right">
        <button type="button" class="btn-sm btn btn-primary" data-toggle="modal" data-target="#createModal">
          <i class="fa fa-plus-square" aria-hidden="true"></i> Thêm mới website
        </button>
      </div>
    </div>
    <div class="list-group list-website table-responsive clearfix">
      <table class="table table-borderless">
        <thead>
          <tr>
            <th class="text-center">Tên web</th>
            <th class="text-center">Ngày deploy gần nhất</th>
            <th class="text-center">Thao tác</th>
          </tr>
        </thead>
        <tbody>
          @foreach($websites as $website)
            <tr class="{{ $website->status == 1 ? 'table-success' : 'table-danger' }}">
              <td> <a id="website-{{ $website->id }}" href="{{ $website->link }}" data-link_admin="{{ $website->link_admin }}" data-day_deploy="{{ \Carbon\Carbon::parse($website->day_deploy)->format('d/m/Y') }}">{{ $website->name }}</a></td>
              <td class="text-center" id="day_deploy-{{ $website->id }}">{{ empty($website->day_deploy) ? '' : \Carbon\Carbon::parse($website->day_deploy)->format('d/m/Y H:i:s') }}</td>
              <td class="text-center">
                <div class="list-group-item-cs item-{{ $website->id }}">
                  <a style="color: #fff" class="btn-sm btn btn-info btn-link-admin @if (empty($website->link_admin)) d-none @endif" href="{{ $website->link_admin }}" target="_blank">
                    <i class="fa fa-adn" aria-hidden="true"></i> Go Admin
                  </a>
                  <a style="color: #fff" class="btn-sm btn btn-secondary btn-statistical" href="{{ route('client.show-statistical') }}?web={{ $website->name }}&domain={{ $website->link }}" target="_blank">
                    <i class="fa fa-area-chart" aria-hidden="true"></i> Thống kê
                  </a>
                  <button type="button" class="btn-sm btn btn-primary edit-btn" data-id="{{ $website->id }}">
                    <i class="fa fa-pencil" aria-hidden="true"></i> Sửa
                  </button>
                  <button type="button" class="btn-sm btn btn-danger remove-btn" data-id="{{ $website->id }}">
                    <i class="fa fa-times" aria-hidden="true"></i> Xóa
                  </button>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="b-page">
        {{ $websites->appends(Request::all())->links() }}
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="emailModelLabel" aria-hidden="true">
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
                <label for="staticEmail" class="col-sm-3 col-form-label">Tên web</label>
                <div class="col-sm-9">
                  <input type="text" name="name" class="form-control" id="nametxt" value="" placeholder="vd: gospeedcheck.com">
                  <div class="alert-name"></div>
                </div>
              </div>
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-3 col-form-label">Link</label>
                <div class="col-sm-9">
                  <input type="text" name="link" class="form-control" id="linktxt" value="" placeholder="vd: http://gospeedcheck.com">
                  <div class="alert-link"></div>
                </div>
              </div>
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-3 col-form-label">Link admin</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="link_admin" value="" placeholder="vd: http://gospeedcheck.com/toh-admin">
                  <div class="alert-link_admin"></div>
                </div>
              </div>
              {{-- <div class="form-group row">
                <label for="staticEmail" class="col-sm-3 col-form-label">Ngày deploy</label>
                <div class="col-sm-9">
                  <input autocomplete="off" type="text" class="day_deploy w-100 form-control" maxlength="10" placeholder="vd: 20/10/2020">
                  <div class="alert-day_deploy"></div>
                </div>
              </div> --}}
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn-sm btn btn-primary" id="save-btn"> Lưu </button>
            <button type="button" class="btn-sm btn btn-secondary" data-dismiss="modal">Đóng</button>
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
                <label for="staticEmail" class="col-sm-3 col-form-label">Tên web</label>
                <div class="col-sm-9">
                  <input type="text" name="name" class="form-control" id="edtnametxt" value="">
                  <div class="alert-name"></div>
                </div>
              </div>
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-3 col-form-label">Link</label>
                <div class="col-sm-9">
                  <input type="text" name="link" class="form-control" id="edtlinktxt" value="">
                  <div class="alert-link"></div>
                </div>
              </div>
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-3 col-form-label">Link admin</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="edtlinkadmintxt" value="" placeholder="vd: http://gospeedcheck.com/toh-admin">
                  <div class="alert-link_admin"></div>
                </div>
              </div>
              {{-- <div class="form-group row">
                <label for="staticEmail" class="col-sm-3 col-form-label">Ngày deploy</label>
                <div class="col-sm-9">
                  <input autocomplete="off" id="edtdaydeploytxt" type="text" class="day_deploy w-100 form-control" maxlength="10" placeholder="vd: 20/10/2020">
                  <div class="alert-day_deploy"></div>
                </div>
              </div> --}}
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn-sm btn btn-primary" id="update-btn"> Lưu </button>
            <button type="button" class="btn-sm btn btn-secondary" data-dismiss="modal">Đóng</button>
          </div>
        </div>
      </div>
    </div>

    <script>
      $(document).ready(function(){

        // var dateRegex = /^(?=\d)(?:(?:31(?!.(?:0?[2469]|11))|(?:30|29)(?!.0?2)|29(?=.0?2.(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00)))(?:\x20|$))|(?:2[0-8]|1\d|0?[1-9]))([-.\/])(?:1[012]|0?[1-9])\1(?:1[6-9]|[2-9]\d)?\d\d(?:(?=\x20\d)\x20|$))?(((0?[1-9]|1[012])(:[0-5]\d){0,2}(\x20[AP]M))|([01]\d|2[0-3])(:[0-5]\d){1,2})?$/;            Date.prototype.isValidDate = function () {
        //     return this.getTime() === this.getTime();
        // };  
        // Date.prototype.isValidDate = function () {
        //     return this.getTime() === this.getTime();
        // };  

        // $( ".day_deploy" ).datepicker({
        //     changeMonth: true,
        //     changeYear: true,
        //     yearRange: "1970:{{ date('Y') }}",
        //     dateFormat: 'dd/mm/yy',
        //     maxDate : new Date(),
        // } );

        $("#createModal, #editModal").on("hidden.bs.modal", function () {
          clearForm()
        });

        action();
        function action(){
          $('.edit-btn').off('click');
          $('.edit-btn').click(function(){
            $('#edtnametxt').val($('#website-' + $(this).attr('data-id')).text());
            $('#edtlinktxt').val($('#website-' + $(this).attr('data-id')).attr('href'));
            $('#edtlinkadmintxt').val($('#website-' + $(this).attr('data-id')).attr('data-link_admin'));
            $('#edtdaydeploytxt').val($('#website-' + $(this).attr('data-id')).attr('data-day_deploy'));
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
                $(".ajax_waiting").addClass("loading");
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
                  $(".ajax_waiting").addClass("loading");
                  window.location.replace(window.location.origin);
                  // self.parent().parent().parent().remove();
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
          var object_name = $('#edtnametxt').val().trim();
          var link = $('#edtlinktxt').val().trim();
          var link_admin = $('#edtlinkadmintxt').val().trim();
          // var day_deploy = $('#edtdaydeploytxt').val();
          $('.alert-error').html('')

          if (link != '' && link.slice(-1) == '/') {
            link = link.slice(0, -1)
          }

          if (link != '' && link.indexOf('http') === -1) {
            link = 'http://' + link;
          }
          // alert(link)
          if (link_admin.slice(-1) == '/') {
            link_admin = link_admin.slice(0, -1)
          }

          // if (day_deploy == '') {
          //     $('.alert-day_deploy').html('Ngày deploy không được để trống!').addClass('alert-error');
          //     return;
          // }

          // if (day_deploy == '') {
          //     $('.alert-day_deploy').html('Ngày deploy không được để trống!').addClass('alert-error');
          //     return;
          // }

          // if (day_deploy != '') {
          //     if (dateRegex.test(day_deploy) != true) {
          //       $('.alert-day_deploy').html('Xin vui lòng nhập ngày deploy hợp lệ!').addClass('alert-error');
          //       return;
          //     } else {
          //         day_deploy_format = day_deploy;
          //         day_deploy = day_deploy.split('/');
          //         day_deploy = day_deploy[2] + '-' + day_deploy[1] + '-' + day_deploy[0]

          //         if (new Date(day_deploy).isValidDate() == false) {
          //           $('.alert-day_deploy').html('Xin vui lòng nhập ngày deploy hợp lệ!').addClass('alert-error');
          //           return;
          //         }
          //     }
          // }

          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          $.ajax({
              url: "{{ url('/') }}/update-website",
              method: "POST",
              data: { 
                id : object_id,
                name : object_name.trim(),
                link : link.trim(),
                link_admin : link_admin.trim(),
                // day_deploy : day_deploy.trim(),
              },
              beforeSend: function(r, a){
                  $(".ajax_waiting").addClass("loading");
              },
              complete: function() {
                  $(".ajax_waiting").removeClass("loading");
              },
              success: function (obj) {
                  if(obj.status == 200){
                    swal({
                      // title: "Good job!",
                      text: "Website đã được cập nhật!",
                      icon: "success",
                      button: "Đóng",
                    }).then((value) => {
                      $(".ajax_waiting").addClass("loading");
                      location.reload();
                    });
                    
                    // $('#editModal').modal('toggle')
                    // $('#day_deploy-' + object_id).html(obj.day_deploy)
                    // $('#website-' + object_id).text(object_name);
                    // $('#website-' + object_id).attr('href', link);
                    // $('#website-' + object_id).attr('data-link_admin', link_admin);

                    // if (obj.status_website == 0) {
                    //   $('#day_deploy-' + object_id).closest('tr').addClass('table-danger').removeClass('table-success')
                    // } else {
                    //   $('#day_deploy-' + object_id).closest('tr').addClass('table-success').removeClass('table-danger')
                    // }

                    // if (link_admin != '') {
                    //   if (link_admin.indexOf('http') === -1) {
                    //     link_admin = 'http://' + link_admin;
                    //   }
                    //   $('.item-'+ object_id +' .btn-link-admin').attr('href', link_admin).removeClass('d-none')
                    // } else {
                    //   $('.item-'+ object_id +' .btn-link-admin').addClass('d-none')
                    // }

                    // $('.item-'+ object_id +' .btn-statistical').attr('href', '/statistical?web='+ object_name +'&domain='+ link +'').removeClass('d-none')
                    // $('#website-' + object_id).attr('data-day_deploy', day_deploy_format);
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

        function clearForm() {
          $('.alert-error').html('')
          $('#createModal input').val('');
        }

        $('#save-btn').click(function(){
          $('.alert-error').html('')
          var object_name = $('#nametxt').val();
          var link = $('#linktxt').val();
          var link_admin = $('#link_admin').val();
          // var day_deploy = $('#createModal .day_deploy').val();

          // if (object_name == '') {
          //     $('.alert-name').html('Tên web không được để trống!').addClass('alert-error');
          //     return;
          // }

          // if (link == '') {
          //     $('.alert-link').html('Link không được để trống!').addClass('alert-error');
          //     return;
          // }

          if (link != '' && link.slice(-1) == '/') {
            link = link.slice(0, -1)
          }

          if (link != '' && link.indexOf('http') === -1) {
            link = 'http://' + link;
          }

          if (link_admin.slice(-1) == '/') {
            link_admin = link_admin.slice(0, -1)
          }
          
          // if (day_deploy == '') {
          //     $('.alert-day_deploy').html('Ngày deploy không được để trống!').addClass('alert-error');
          //     return;
          // }

          // if (day_deploy != '') {
          //     if (dateRegex.test(day_deploy) != true) {
          //       $('.alert-day_deploy').html('Xin vui lòng nhập ngày deploy hợp lệ!').addClass('alert-error');
          //       return;
          //     } else {
          //         day_deploy_format = day_deploy
          //         day_deploy = day_deploy.split('/');
          //         day_deploy = day_deploy[2] + '-' + day_deploy[1] + '-' + day_deploy[0]

          //         if (new Date(day_deploy).isValidDate() == false) {
          //           $('.alert-day_deploy').html('Xin vui lòng nhập ngày deploy hợp lệ!').addClass('alert-error');
          //           return;
          //         }
          //     }
          // }

          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              type: "POST",
              url: "{{ url('/') }}/add-website",
              data: { 
                name : object_name.trim(),
                link : link.trim(),
                link_admin : link_admin.trim(),
                // day_deploy : day_deploy.trim(),
              },
              dataType:'json',
              beforeSend: function(r, a){
                  $(".ajax_waiting").addClass("loading");
              },
              complete: function() {
                  $(".ajax_waiting").removeClass("loading");
              },
              success: function (obj) {
                  if(obj.status == 200){
                    swal({
                      // title: "Good job!",
                      text: "Website đã được thêm mới thành công!",
                      icon: "success",
                      button: "Đóng",
                    }).then((value) => {
                      $(".ajax_waiting").addClass("loading");
                      window.location.replace(window.location.origin);
                    });
                    //   $html = '';
                    //   if(obj.status_website == 1){
                    //     $html = '<tr class="table-success">';
                    //   }else{
                    //     $html = '<tr class="table-danger">';
                    //   }

                    //   if(obj.link_admin == null){
                    //     link_admin= '';
                    //   }else{
                    //     link_admin = obj.link_admin;
                    //   }

                    //     $html += '<td><a id="website-'+obj.id_website+'" href="'+obj.link_website+'" data-link_admin="'+link_admin+'">'+obj.name_website+'</a></td>';
                    //     $html += '<td class="text-center">'+obj.day_deploy+'</td>';
                    //     $html += '<td class="text-center">'
                    //       $html += '<div class="list-group-item-cs item-'+obj.id_website+'">'
                    //         $class_d_none = link_admin != ''? '' : 'd-none'
                    //         $html += '<a style="color: #fff" class="btn-sm btn btn-info btn-link-admin '+ $class_d_none +'" href="'+link_admin+'" target="_blank"><i class="fa fa-adn" aria-hidden="true"></i> Go Admin</a>';
                    //         $html += ' <a style="color: #fff" class="btn-sm btn btn-secondary btn-statistical" href="/statistical?web='+ obj.name_website +'&domain='+ obj.link_website +'" target="_blank"><i class="fa fa-area-chart" aria-hidden="true"></i> Thống kê</a>';
                    //         $html += ' <button type="button" class="btn-sm btn btn-primary edit-btn" data-id="'+obj.id_website+'"><i class="fa fa-pencil" aria-hidden="true"></i> Sửa</button>'
                    //         $html += ' <button type="button" class="btn-sm btn btn-danger remove-btn" data-id="'+obj.id_website+'"><i class="fa fa-times" aria-hidden="true"></i> Xóa</button>';
                    //       $html += '</div>';
                    //     $html += '</td>';
                    //   $html += '</tr>';
                    // $('.list-website tbody').append($html);
                    // clearForm();
                    // $('#createModal').modal('toggle');
                    // action();
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