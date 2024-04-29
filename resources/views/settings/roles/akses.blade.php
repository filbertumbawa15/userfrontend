@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <div class="card card-primary card-outline card-tabs">
        <div class="card-header p-0 pt-1 border-bottom-0">
            <ul class="nav nav-tabs" id="threeTab" role="tablist">
                <!-- <li class="nav-item">
                    <a href="a.png" class="nav-link {{ url()->current() == route('roles.akses', ['id' => '5fc874ed-03a4-11ef-ba3c-94de801a1234']) ? 'active' : '' }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">Settings</a>
                </li> -->
            </ul>
        </div>

        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table id="dataTable" class="table table-bordered table-hover">
                </table>
            </div>
            <!-- /.card-body -->
        </div>

    </div>
</div>
@endsection

@push('page_plugins')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
@endpush

@push('page_custom_script')
<script>
    const accessToken = getCookie('access-token')
    $(document).ready(function() {
        var jsonData = `{{ $config_modul }}`;
        var result = JSON.parse(jsonData.replace(/&quot;/g, '"'));
        $.each(result.data, function(index, detail) {
            var urlData = "{{ url('admin/settings/roles') }}/akses/$id?param=" + detail.uuid + "";
            var resultData = "<li class='nav-item'>" +
                "<a href={{ url('admin/settings/roles') }}/akses/{{ $id }}?param=" + detail.uuid + " class='nav-link'>" + detail.nama + "</a>" +
                "</li>";
            $('#threeTab').append(resultData);
        });
        letDataTable(JSON.parse(`{{ $resultMenu }}`.replace(/&quot;/g, '"')));
    });

    function letDataTable(data) {
        let table = $('#dataTable').DataTable({
            processing: true,
            serverSide: false,
            paging: false,
            pageLength: 10,
            lengthMenu: [10, 25, 50, 75, 100],
            data: data,
            columns: [{
                    title: '#',
                    data: 'uuid',
                    width: '5%',
                },
                {
                    title: 'NAMA MENU',
                    data: 'nama_menu'
                },
                {
                    title: 'BACA',
                    data: 'baca'
                },
                {
                    title: 'TULIS',
                    data: 'tulis'
                },
                {
                    title: 'UBAH',
                    data: 'ubah'
                },
                {
                    title: 'HAPUS',
                    data: 'hapus'
                },
            ],
            columnDefs: [{
                searchable: false,
                orderable: false,
                targets: [0],
            }, ],
            order: [1, 'asc'],
        });
        table
            .on('order.dt search.dt', function() {
                let i = 1;

                table
                    .cells(null, 0, {
                        search: 'applied',
                        order: 'applied'
                    })
                    .every(function(cell) {
                        this.data(i++);
                    });
            })
            .draw();
    }
    // /* Set row numbers */
    // table.on('order.dt search.dt draw', function() {
    //     let info = table.page.info()
    //     table.column(0, {
    //         search: "applied",
    //         order: "applied"
    //     }).nodes().each(function(cell, i) {
    //         cell.innerHTML = i + 1 + (info.page * info.length);
    //     });
    // })
</script>
@endpush