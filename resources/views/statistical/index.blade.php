@extends('master')
@section('content')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <section class="content">
        <div class="clearfix">
            <div class="pull-right">
                <label>Xem nhanh</label>
                <label class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><span class="name-dropdown">Hôm nay</span>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li class="active"><a class="dropdown-item" href="javascript:void(0)" data-id="1">Hôm nay</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" data-id="2">Hôm qua</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" data-id="3">Tuần này</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" data-id="4">Tuần trước</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" data-id="5">Tháng này</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" data-id="6">Tháng trước</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" data-id="7">Năm nay</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" data-id="8">Năm trước</a></li>
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
    </section>
    
    <script type="text/javascript">
        $(document).ready(function(){    
            $('.content .dropdown-menu li').on('click', function() {
                $('.dropdown-menu li').removeClass('active');
                $(this).addClass('active');
                var type = $(this).find('a').data('id');
    
                arr_filter_tmp = [];
                $('.name-dropdown').text($(this).text());
                var flag = false;
                var txt_report = $(this).text();
    
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                $.ajax({
                    type: "GET",
                    url: "{{ route('client.highchart') }}",
                    data: { type: type },
                    beforeSend: function(r, a){
                        
                    },
                    success: function (response) {
                        if(response.status == 200){
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
                                    text: 'Biểu đồ thống kê lượt khách visited'
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
                                        return '<b>' + this.point.y + '</b>' + ' người dùng mới';
                                    }
                                },
                                series: [{
                                    name: 'Báo cáo ' + txt_report.toLowerCase() + ' (<span class="total">'+ total +'</span> người dùng mới)',
                                    data: arr,
                                    events: {
                                        legendItemClick: function() {
                                            return false;
                                        }
                                    }
                                }],
                            });
    
                            // if (flag) {
                            //     $('.highcharts-axis-labels text:nth-child('+ flag +')').css({'fill' : 'red', 'font-weight' : '600'});
                            //     $('.highcharts-series rect:nth-child('+ flag +')').css('fill','#6c757d');
                            // }
                    
                        }
                    },
                    error: function (data) {
                        alert('error')
                    }
                });
               
            });
    
            $('.dropdown-menu li.active').trigger('click');
        });
    </script>
@endsection