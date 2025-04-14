@extends('layouts.server')
@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10"><a href="#">Bảng điều khiển</a></li>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Tổng lượt xem trang</h6>
                    <h4 class="mb-3">4,42,236 <span class="badge bg-light-primary border border-primary"><i
                                class="ti ti-trending-up"></i> 59.3%</span></h4>
                    <p class="mb-0 text-muted text-sm">Bạn đã kiếm thêm <span class="text-primary">35,000</span>
                        trong năm nay
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Tổng người dùng</h6>
                    <h4 class="mb-3">78,250 <span class="badge bg-light-success border border-success"><i
                                class="ti ti-trending-up"></i> 70.5%</span></h4>
                    <p class="mb-0 text-muted text-sm">Bạn đã kiếm thêm <span class="text-success">8,900</span>
                        trong năm nay</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Tổng đơn hàng</h6>
                    <h4 class="mb-3">18,800 <span class="badge bg-light-warning border border-warning"><i
                                class="ti ti-trending-down"></i> 27.4%</span></h4>
                    <p class="mb-0 text-muted text-sm">Bạn đã kiếm thêm <span class="text-warning">1,943</span>
                        trong năm nay</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Tổng doanh thu</h6>
                    <h4 class="mb-3">$35,078 <span class="badge bg-light-danger border border-danger"><i
                                class="ti ti-trending-down"></i> 27.4%</span></h4>
                    <p class="mb-0 text-muted text-sm">Bạn đã kiếm thêm <span class="text-danger">$20,395</span>
                        trong năm nay
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-xl-8">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="mb-0">Khách truy cập duy nhất</h5>
                <ul class="nav nav-pills justify-content-end mb-0" id="chart-tab-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="chart-tab-home-tab" data-bs-toggle="pill"
                            data-bs-target="#chart-tab-home" type="button" role="tab" aria-controls="chart-tab-home"
                            aria-selected="true">Tháng</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="chart-tab-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#chart-tab-profile" type="button" role="tab" aria-controls="chart-tab-profile"
                            aria-selected="false">Tuần</button>
                    </li>
                </ul>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="tab-content" id="chart-tab-tabContent">
                        <div class="tab-pane" id="chart-tab-home" role="tabpanel" aria-labelledby="chart-tab-home-tab"
                            tabindex="0">
                            <div id="visitor-chart-1"></div>
                        </div>
                        <div class="tab-pane show active" id="chart-tab-profile" role="tabpanel"
                            aria-labelledby="chart-tab-profile-tab" tabindex="0">
                            <div id="visitor-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-xl-4">
            <h5 class="mb-3">Tổng quan thu nhập</h5>
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Thống kê tuần này</h6>
                    <h3 class="mb-3">$7,650</h3>
                    <div id="income-overview-chart"></div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-xl-8">
            <h5 class="mb-3">Đơn hàng gần đây</h5>
            <div class="card tbl-card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless mb-0">
                            <thead>
                                <tr>
                                    <th>SỐ THEO DÕI</th>
                                    <th>TÊN SẢN PHẨM</th>
                                    <th>TỔNG ĐƠN HÀNG</th>
                                    <th>TRẠNG THÁI</th>
                                    <th class="text-end">TỔNG TIỀN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="#" class="text-muted">84564564</a></td>
                                    <td>Camera Lens</td>
                                    <td>40</td>
                                    <td><span class="d-flex align-items-center gap-2"><i
                                                class="fas fa-circle text-danger f-10 m-r-5"></i>Bị từ chối</span>
                                    </td>
                                    <td class="text-end">$40,570</td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-muted">84564564</a></td>
                                    <td>Laptop</td>
                                    <td>300</td>
                                    <td><span class="d-flex align-items-center gap-2"><i
                                                class="fas fa-circle text-warning f-10 m-r-5"></i>Đang chờ xử lý</span>
                                    </td>
                                    <td class="text-end">$180,139</td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-muted">84564564</a></td>
                                    <td>Mobile</td>
                                    <td>355</td>
                                    <td><span class="d-flex align-items-center gap-2"><i
                                                class="fas fa-circle text-success f-10 m-r-5"></i>Đã duyệt</span>
                                    </td>
                                    <td class="text-end">$180,139</td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-muted">84564564</a></td>
                                    <td>Camera Lens</td>
                                    <td>40</td>
                                    <td><span class="d-flex align-items-center gap-2"><i
                                                class="fas fa-circle text-danger f-10 m-r-5"></i>Bị từ chối</span>
                                    </td>
                                    <td class="text-end">$40,570</td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-muted">84564564</a></td>
                                    <td>Laptop</td>
                                    <td>300</td>
                                    <td><span class="d-flex align-items-center gap-2"><i
                                                class="fas fa-circle text-warning f-10 m-r-5"></i>Đang chờ xử lý</span>
                                    </td>
                                    <td class="text-end">$180,139</td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-muted">84564564</a></td>
                                    <td>Mobile</td>
                                    <td>355</td>
                                    <td><span class="d-flex align-items-center gap-2"><i
                                                class="fas fa-circle text-success f-10 m-r-5"></i>Đã duyệt</span>
                                    </td>
                                    <td class="text-end">$180,139</td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-muted">84564564</a></td>
                                    <td>Camera Lens</td>
                                    <td>40</td>
                                    <td><span class="d-flex align-items-center gap-2"><i
                                                class="fas fa-circle text-danger f-10 m-r-5"></i>Bị từ chối</span>
                                    </td>
                                    <td class="text-end">$40,570</td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-muted">84564564</a></td>
                                    <td>Laptop</td>
                                    <td>300</td>
                                    <td><span class="d-flex align-items-center gap-2"><i
                                                class="fas fa-circle text-warning f-10 m-r-5"></i>Đang chờ xử lý</span>
                                    </td>
                                    <td class="text-end">$180,139</td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-muted">84564564</a></td>
                                    <td>Mobile</td>
                                    <td>355</td>
                                    <td><span class="d-flex align-items-center gap-2"><i
                                                class="fas fa-circle text-success f-10 m-r-5"></i>Đã duyệt</span>
                                    </td>
                                    <td class="text-end">$180,139</td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-muted">84564564</a></td>
                                    <td>Mobile</td>
                                    <td>355</td>
                                    <td><span class="d-flex align-items-center gap-2"><i
                                                class="fas fa-circle text-success f-10 m-r-5"></i>Đã duyệt</span>
                                    </td>
                                    <td class="text-end">$180,139</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-xl-4">
            <h5 class="mb-3">Báo cáo phân tích</h5>
            <div class="card">
                <div class="list-group list-group-flush">
                    <a href="#"
                        class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">Tăng
                        trưởng tài chính công ty<span class="h5 mb-0">+45.14%</span></a>
                    <a href="#"
                        class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">Tỷ
                        lệ chi phí công ty<span class="h5 mb-0">0.58%</span></a>
                    <a href="#"
                        class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">Trường
                        hợp rủi ro kinh doanh<span class="h5 mb-0">Thấp</span></a>
                </div>
                <div class="card-body px-2">
                    <div id="analytics-report-chart"></div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-xl-8">
            <h5 class="mb-3">Báo cáo bán hàng</h5>
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Thống kê tuần này</h6>
                    <h3 class="mb-0">$7,650</h3>
                    <div id="sales-report-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-xl-4">
            <h5 class="mb-3">Lịch sử giao dịch</h5>
            <div class="card">
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s rounded-circle text-success bg-light-success">
                                    <i class="ti ti-gift f-18"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Order #002434</h6>
                                <p class="mb-0 text-muted">Hôm nay, 2:00 AM</P>
                            </div>
                            <div class="flex-shrink-0 text-end">
                                <h6 class="mb-1">+ $1,430</h6>
                                <p class="mb-0 text-muted">78%</P>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s rounded-circle text-primary bg-light-primary">
                                    <i class="ti ti-message-circle f-18"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Order #984947</h6>
                                <p class="mb-0 text-muted">5 August, 1:45 PM</P>
                            </div>
                            <div class="flex-shrink-0 text-end">
                                <h6 class="mb-1">- $302</h6>
                                <p class="mb-0 text-muted">8%</P>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s rounded-circle text-danger bg-light-danger">
                                    <i class="ti ti-settings f-18"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Order #988784</h6>
                                <p class="mb-0 text-muted">7 hours ago</P>
                            </div>
                            <div class="flex-shrink-0 text-end">
                                <h6 class="mb-1">- $682</h6>
                                <p class="mb-0 text-muted">16%</P>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection