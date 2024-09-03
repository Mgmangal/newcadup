@extends('theme-one.layouts.app', ['title' => 'Manage Library', 'sub_title' => 'Payment history'])
@section('css')
<link href="{{ asset('assets/theme_one/lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/theme_one/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}"
    rel="stylesheet">
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Payment history</h3>
        {{-- <a href="{{route('app.sfa.generate')}}" class="btn btn-primary btn-md">Generate Report</a> --}}
    </div>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="card-body">
        <div class="row mb-3">

            <div class="col-sm-2">
                <div class="form-group">
                    <lable for="pilots">Crew</lable>
                    <select class="form-control app_datetime filter" id="pilots" name="pilots" form="sfa-form" required>
                        <option value="">Select</option>
                        @foreach($pilots as $pilot)
                        <option value="{{$pilot->id}}">{{$pilot->salutation.' '.$pilot->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- <div class="col-sm-2">
                <div class="form-group">
                    <lable for="from_date">From Date</lable>
                    <input type="text" readonly form="sfa-form" name="from_date" class="form-control datepicker filter"
                        id="from_date" required>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <lable for="to_date">To Date</lable>
                    <input type="text" readonly form="sfa-form" name="to_date" class="form-control datepicker filter"
                        id="to_date" required>
                </div>
            </div> --}}
        </div>


        <div class="table-responsive">
            <table id="datatableDefault" class="table text-nowrap w-100">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Crew</th>
                        <th>TXN ID</th>
                        <th>Method</th>
                        <th>Amount (₹)</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>TXN12345</td>
                        <td>Credit Card</td>
                        <td>₹5000</td>
                        <td>2024-09-01</td>
                        <td>Completed</td>
                        <td><button class="btn btn-primary">View</button></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jane Smith</td>
                        <td>TXN12346</td>
                        <td>Bank Transfer</td>
                        <td>₹7000</td>
                        <td>2024-09-02</td>
                        <td>Pending</td>
                        <td><button class="btn btn-primary">View</button></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Bob Johnson</td>
                        <td>TXN12347</td>
                        <td>UPI</td>
                        <td>₹2500</td>
                        <td>2024-09-03</td>
                        <td>Failed</td>
                        <td><button class="btn btn-primary">View</button></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Alice Brown</td>
                        <td>TXN12348</td>
                        <td>Credit Card</td>
                        <td>₹10000</td>
                        <td>2024-09-04</td>
                        <td>Completed</td>
                        <td><button class="btn btn-primary">View</button></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Charlie Green</td>
                        <td>TXN12349</td>
                        <td>Bank Transfer</td>
                        <td>₹4500</td>
                        <td>2024-09-05</td>
                        <td>Processing</td>
                        <td><button class="btn btn-primary">View</button></td>
                    </tr>
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('assets/theme_one/lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/theme_one/lib/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/theme_one/lib/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/theme_one/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js') }}"></script>
<script>
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        calendarWeeks: false,
        zIndexOffset: 9999,
        orientation: "bottom"
    });

    // function dataList() {
    //     $('#datatableDefault').DataTable().destroy();
    //     var pilot = $('#pilots').val();
    //     var from_date = $('#from_date').val();
    //     var to_date = $('#to_date').val();
    //     $('#datatableDefault').DataTable({
    //         processing: true,
    //         serverSide: true,
    //         searching: false,
    //         paging: false,
    //         info: false,
    //         order: [
    //             [2, 'desc']
    //         ],
    //         orderable: false,
    //         lengthMenu: [20, 50, 100, 200, 500, 1000, 2000, 5000, 10000],
    //         responsive: true,
    //         fixedColumns: true,
    //         "columnDefs": [{
    //                 "orderable": false,
    //                 "targets": [0, 5]
    //             } // Disable order on first columns
    //         ],
    //         ajax: {
    //             url: "{{route('user.payment.history_list')}}",
    //             type: 'POST',
    //             data: {
    //                 "_token": "{{ csrf_token() }}",
    //                 pilot,
    //                 from_date,
    //                 to_date
    //             },
    //         },
    //         fnRowCallback: function(nRow, aData, iDisplayIndex) {
    //             var oSettings = this.fnSettings();
    //             $("td:eq(0)", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
    //         },
    //         "initComplete": function() {
    //         },
    //         drawCallback: function(settings) {
    //         },
    //     });
    // }
    // $('.filter').on('change', function() {
    //     dataList();
    // });
    // dataList();
</script>
@endsection
