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

        <button type="button" onclick="saveLevelMenu()" class="btn btn-primary mb-3" id="addButton">
              Submit
        </button>

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
    var checkedRows = [];

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
                    data: 'baca',
                    render: function(data){
                        return `<input type="checkbox" class="checkbox" data-row="row1" ${data == "Ya" ? "checked" : ""}/>`
                    }
                },
                {
                    title: 'TULIS',
                    data: 'tulis',
                    render: function(data){
                        return `<input type="checkbox" class="checkbox" data-row="row2" ${data == "Ya" ? "checked" : ""}/>`
                    }
                },
                {
                    title: 'UBAH',
                    data: 'ubah',
                    render: function(data){
                        return `<input type="checkbox" class="checkbox" data-row="row3" ${data == "Ya" ? "checked" : ""}/>`
                    }
                },
                {
                    title: 'HAPUS',
                    data: 'hapus',
                    render: function(data){
                        return `<input type="checkbox" class="checkbox" data-row="row4" ${data == "Ya" ? "checked" : ""}/>`
                    }
                },
            ],
            columnDefs: [{
                searchable: false,
                orderable: false,
                targets: [0],
            }, ],
            order: [1, 'asc'],
        });
        // table
        //     .on('order.dt search.dt', function() {
        //         let i = 1;

        //         table
        //             .cells(null, 0, {
        //                 search: 'applied',
        //                 order: 'applied'
        //             })
        //             .every(function(cell) {
        //                 this.data(i++);
        //             });
        //     })
        //     .draw();

    $('.checkbox').change(function() {
        var containsValue = false; // Get the data-row attribute of the checkbox
        var rowValues = []; // Array to store the values of the row

        // // // Get the values of the current row
        $(this).closest('tr').find('td').each(function() {
            var values = $(this).text();
            if(values == ""){
                if($(this).find('input[type="checkbox"]').is(':checked')){
                    rowValues.push("Ya");
                }else{
                    rowValues.push("Tidak");
                }
            }else{
                rowValues.push(values);
            }
        });
        // function removeAndAddArraysByValue(arr, value, newAsrray) {
        for (var i = 0; i < checkedRows.length; i++) {
                if (checkedRows[i].indexOf(rowValues[1]) !== -1) {
                    containsValue = true;
                    // Remove the array containing the value
                    checkedRows.splice(i, 1);
                    // Add the new array at the same index
                    checkedRows.splice(i, 0, rowValues);
                }
        }
        if(!containsValue){
            checkedRows.push(rowValues);
        }
    });
    }

    function saveLevelMenu(){
        if(checkedRows.length == 0){
            window.location.href  = `{{ route("roles.index") }}`
        }else{
            $.ajax({
                url: `{{ config('app.api_url') }}levelakses`,
                datatype: 'JSON',
                type: 'POST',
                data: {
                    id_level : `{{ $dataArray['id_level'] }}`,
                    dataMenu : checkedRows,
                },
                beforeSend: request => {
                    request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
                },
                success: response => {
                    window.location.href  = `{{ route("roles.index") }}`
                }
            })
        }
    }


</script>
@endpush