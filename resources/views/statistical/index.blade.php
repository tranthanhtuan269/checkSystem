@extends('master')
@section('content')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <section class="content">
        @if ($data !== false)
            <div class="clearfix">
                <div class="pull-right">
                    <label>Xem nhanh</label>
                    <label class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><span class="name-dropdown"></span>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item @if(!Request::get('type')) active @endif" href="/statistical?web={{ Request::get('web') }}&domain={{ Request::get('domain') }}">Hôm nay</a></li>
                            <li><a class="dropdown-item @if(Request::get('type') == 2) active @endif" href="/statistical?web={{ Request::get('web') }}&domain={{ Request::get('domain') }}&type=2">Hôm qua</a></li>
                            <li><a class="dropdown-item @if(Request::get('type') == 3) active @endif" href="/statistical?web={{ Request::get('web') }}&domain={{ Request::get('domain') }}&type=3">Tuần này</a></li>
                            <li><a class="dropdown-item @if(Request::get('type') == 4) active @endif" href="/statistical?web={{ Request::get('web') }}&domain={{ Request::get('domain') }}&type=4">Tuần trước</a></li>
                            <li><a class="dropdown-item @if(Request::get('type') == 5) active @endif" href="/statistical?web={{ Request::get('web') }}&domain={{ Request::get('domain') }}&type=5">Tháng này</a></li>
                            <li><a class="dropdown-item @if(Request::get('type') == 6) active @endif" href="/statistical?web={{ Request::get('web') }}&domain={{ Request::get('domain') }}&type=6">Tháng trước</a></li>
                            <li><a class="dropdown-item @if(Request::get('type') == 7) active @endif" href="/statistical?web={{ Request::get('web') }}&domain={{ Request::get('domain') }}&type=7">Năm nay</a></li>
                            <li><a class="dropdown-item @if(Request::get('type') == 8) active @endif" href="/statistical?web={{ Request::get('web') }}&domain={{ Request::get('domain') }}&type=8">Năm trước</a></li>
                            {{-- <li><a class="dropdown-item" href="javascript:void(0)" data-id="9">Tùy chỉnh</a></li> --}}
                        </ul>
                    </label>
                </div>
            </div>
            <div class="clearfix">
                <div id="chart-customer" style="padding-bottom: 15px"></div>
            </div>
            <div id="edit_customer_modal" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-600">Chỉnh sửa thông tin khách hàng</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label  class="col-sm-4 col-form-label">Họ và tên <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="hidden" id="userID_upd" value="">
                                <input type="text" class="form-control" id="userName_upd" disabled>
                                <div id="nameErrorUpd" class="alert-errors d-none" role="alert">
                                
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-sm-4 col-form-label">Email <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="userEmail_upd" disabled>
                                <div id="emailErrorUpd" class="alert-errors d-none" role="alert">
                                
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-sm-4 col-form-label">Số tiền thêm <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input class="form-control" data-type="currency" id="userPrice_upd" value="">
                                <div id="priceErrorUpd" class="alert-errors d-none" role="alert">
                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="saveCustomer">Cập nhật</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy bỏ</button>
                    </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              Hệ thống không hỗ trợ thống kê cho web này!
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        @endif
    </section>
    
    <script type="text/javascript">
        $(document).ready(function(){    
            var response = $.parseJSON(<?php echo json_encode($data); ?>);
            var type = '{{ Request::get("type") }}';
            type = type > 0 ? type : 1;
            var txt_report = $('a.dropdown-item.active').text();
            $('.name-dropdown').text(txt_report);
            var categories = [];
            var data = response.data;
            var total = 0;
            var arr = []

            if(type == 1 || type == 2) {
                for (let index = 0; index <= 23; index++) {
                    categories.push(index + 'h');

                    if (data[index]) {
                        arr[index] = data[index];
                        total += data[index];
                    } else {
                        arr[index] = 0;
                    }
                }
            } else if (type == 3 || type == 4) {
                jQuery.each(data, function(index, item) {
                    arr.push(item.value)
                    total += item.value;
                });
                
                categories = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật']
            } else if(type == 5 || type == 6) {

                for (let index = 1; index <= daysInMonth(response.month, response.year); index++) {
                    categories.push(index);

                    if (data[index]) {
                        arr[index-1] = data[index];
                        total += data[index];
                    } else {
                        arr[index-1] = 0;
                    }

                }
                console.log(categories);
            } else if (type == 7 || type == 8) {
                for (let index = 1; index <= 12; index++) {
                    categories.push('Tháng ' + index);

                    if (data[index]) {
                        arr[index-1] = data[index];
                        total += data[index];
                    } else {
                        arr[index-1] = 0;
                    }

                }
            } else {

            }

            // console.log(categories)
            Highcharts.chart('chart-customer', {
                chart: {
                    style: {
                        fontSize: '15px',
                        fontFamily: '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji"'
                    }
                },
                title: {
                    text: 'Biểu đồ thống kê lượt khách visited web <b>{{ Request::get("web") }}</b>'
                },
                xAxis: {
                    categories: categories,
                },
                yAxis: {
                    softMax: 10,
                    softMin: 0,
                    title: {
                        text: ''
                    },
                    labels: {
                        style: {
                            fontSize:'15px'
                        }
                    }
            },
                tooltip: {
                    formatter: function () {
                        return '<b>' + this.point.y + '</b>' + ' lượt visited';
                    }
                },
                series: [{
                    name: 'Báo cáo ' + txt_report.toLowerCase() + ' (<span class="total">'+ total +'</span> lượt visited)',
                    data: arr,
                    events: {
                        legendItemClick: function() {
                            return false;
                        }
                    }
                }],
            });
             
        });
    </script>
@endsection