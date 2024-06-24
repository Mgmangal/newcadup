@extends('theme-one.layouts.app',['title' => 'VIOLATIONS','sub_title'=>'REPORT'])
@section('css')
<link href="{{asset('assets/theme_one/lib/datatables.net-dt/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/theme_one/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css')}}"
    rel="stylesheet">
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Violation Report List </h3>
    </div>
    <div class="card-body">
        <div class="table-responsive=">
            <table id="datatableDefault" class="table text-nowrap w-100">
                <thead>
                    <tr>
                        <th>S. No</th>
                        <th>FDT Start</th>
                        <th>FDT End</th>
                        <th>Date</th>
                        <th>Pilot</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('assets/theme_one/lib/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/theme_one/lib/datatables.net-dt/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{asset('assets/theme_one/lib/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/theme_one/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js')}}"></script>

<script>
function dataList() {
    $('#datatableDefault').DataTable().destroy();
    $('#datatableDefault').DataTable({
        processing: true,
        serverSide: true,
        dom: "<'row mb-3'<'col-sm-4'l><'col-sm-8 text-end'<'d-flex justify-content-end'fB>>>t<'d-flex align-items-center'<'me-auto'i><'mb-0'p>>",
        lengthMenu: [20, 50, 100, 200, 500, 1000, 2000, 5000, 10000],
        responsive: true,
        columnDefs: [{
            width: 200,
            targets: 3
        }],
        fixedColumns: true,
        buttons: [{
                extend: 'print',
                className: 'btn btn-default btn-sm'
            },
            {
                extend: 'csv',
                className: 'btn btn-default btn-sm'
            }
        ],
        ajax: {
            url: "{{route('app.fdtl.voilations.report.list')}}",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}"
            },
        },
        fnRowCallback: function(nRow, aData, iDisplayIndex) {
            var oSettings = this.fnSettings();
            $("td:eq(0)", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
        },
        "initComplete": function() {

        }
    });
}
dataList();
</script>
@endsection