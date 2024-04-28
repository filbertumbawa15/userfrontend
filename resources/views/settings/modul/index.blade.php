@extends('layouts.app')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Modul</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Modul</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
	              <div class="card-header">
                    <button type="button" class="btn btn-primary mb-3" id="addButton" onclick="createLevel()">
		              Add
		            </button>
	              </div>
	              <!-- /.card-header -->
	              <div class="card-body">
	                <table id="dataTable" class="table table-bordered table-hover">
	                </table>
	              </div>
	              <!-- /.card-body -->
	            </div>
	            <!-- /.card -->
			</div>
		</div>
	</div>
</section>

<!-- Modal -->
<div class="modal fade" id="crudModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="crudModalTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="crudForm" data-action="add">
        <div class="modal-body">
          <input type="hidden" name="uuid">
          <div class="form-group row">
            <div class="col-12">
              <label>Nama</label>
              <input type="text" class="form-control" name="nama">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Folder</label>
              <input type="text" class="form-control" name="folder">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Icon</label>
              <input type="text" class="form-control" name="icon">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Urutan</label>
              <input type="text" class="form-control" name="urutan">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Level</label>
               <select id="level" multiple placeholder="Choose Level" name="levelIds[]" data-allow-clear="1">
				      </select>
<!--               <select class="form-select" id="level" data-allow-clear="1" placeholder="Choose anything" multiple>
						</select> -->
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('page_plugins_css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<style>
  .bigIcon {
    font-size: 5em;
  }
</style>
@endpush

@push('page_plugins')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
@endpush

@push('page_custom_script')
<script>
	const accessToken = getCookie('access-token')
	$('select').select2({
		theme: 'bootstrap4',
		width: 'style',
		placeholder: $(this).attr('placeholder'),
    allowClear: Boolean($(this).data('allow-clear')),
	});
	$(window).ready(function() {
		let table = $('#dataTable').DataTable({
	      processing: true,
	      serverSide: true,
	      paging: true,
	      pageLength: 10,
	      lengthMenu: [10, 25, 50, 75, 100],
	      ajax: {
	        url: `{{ config('app.api_url') }}modul`,
	        beforeSend: request => {
	          request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
	        },
	        data: data => {
	          let columns = data.columns
	          let searchableColumns = []
	          let filters = {}

	          columns.map(column => {
	            if (column.searchable) {
	              searchableColumns.push(column.data)
	            }
	          })

	          searchableColumns.forEach(searchableColumn => {
	            if (
	              searchableColumn == 'created_at' ||
	              searchableColumn == 'updated_at'
	            ) {
	              filters[searchableColumn] = Date.parse(data.search.value) / 1000
	            } else {
	              filters[searchableColumn] = data.search.value
	            }
	          });

	          let customData = {
	            page: data.start / data.length + 1,
	            limit: data.length,
	            filters: filters,
	            sorts: {
	              column: columns[data.order[data.order.length - 1].column].data,
	              direction: data.order[data.order.length - 1].dir
	            }
	          }

	          return customData
	        },
	        dataFilter: data => {
	          let json = JSON.parse(data)
	          json.recordsTotal = json.totalRecords
	          json.recordsFiltered = json.totalRecords

	          return JSON.stringify(json)
	        }
	      },
	      columns: [
	        {
	          title: '#',
	          data: 'uuid',
	        },
	        {
	          title: 'NAMA MODUL',
	          data: 'nama'
	        },
	        {
	          title: 'FOLDER',
	          data: 'folder'
	        },
	        {
	          title: 'ICON',
	          data: 'icon',
           	render: function(data) {
            	return `<i class="bigIcon ${data}"></i>`
          	},
	        },
	        {
	          title: 'URUTAN',
	          data: 'urutan'
	        },
	        {
	          title: 'CREATED AT',
	          data: 'created_at'
	        },
	        {
	          title: 'UPDATED AT',
	          data: 'updated_at'
	        },
	        {
	          title: 'CREATE USER',
	          data: 'create_user'
	        },
	       	{
	          title: 'MODIFIED USER',
	          data: 'modified_user'
	        },
	        {
	          title: 'DETAIL',
	          defaultContent: ''
	        }
	      ],
	      columnDefs: [{
	          searchable: false,
	          orderable: false,
	          targets: [0],
	        },
	        {
	          searchable: false,
	          orderable: false,
	          targets: 9,
	          render: (data, type, row) => {
	            let editButton = document.createElement('button')
	            editButton.dataset.id = row.uuid
	            editButton.className = 'btn btn-sm btn-success mr-1 d-inline editButton'
	            editButton.innerText = 'edit'

	            let deleteButton = document.createElement('button')
	            deleteButton.dataset.id = row.uuid
	            deleteButton.className = 'btn btn-sm btn-danger d-inline deleteButton'
	            deleteButton.innerText = 'delete'

	            return editButton.outerHTML + deleteButton.outerHTML
	          }
	        },
	      ],
	      order: [4, 'asc'],
	    });
	    /* Set row numbers */
	    table.on('order.dt search.dt draw', function() {
	      let info = table.page.info()

	      table.column(0, {
	        search: "applied",
	        order: "applied"
	      }).nodes().each(function(cell, i) {
	        cell.innerHTML = i + 1 + (info.page * info.length);
	      });
	    })

	    $.ajax({
		    url: `{{ config('app.api_url') }}configmodullevelakses/haspermission`,
		    method: 'GET',
		    dataType: 'JSON',
		    data:{
		    	accessMenu : `{{ $folder }}`
		    },
		    beforeSend: request => {
		      request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
		    },
		    success: response => {
		    	if (response.tulis !== "Ya") {
                	$('#addButton').attr('disabled', 'disabled')
            	}
            	if (response.ubah !== "Ya") {
                	$('.editButton').attr('disabled', 'disabled')
            	}
            	if (response.hapus !== "Ya") {
                	$('.deleteButton').attr('disabled', 'disabled')
            	}
		    }
	   })
	});

	$('#crudModal').on('hidden.bs.modal', () => {
    	$('#crudForm').trigger('reset')
  	})

	function createLevel() {
	    let form = $('#crudForm')

	    $('.modal-loader').removeClass('d-none')

	    form.trigger('reset')
	    form.find('#btnSubmit').html(`
	      <i class="fa fa-save"></i>
	      Save
	    `)
	    form.data('action', 'add')
	    form.find(`.sometimes`).show()
	    $('#crudModalTitle').text('Create Modul')
	    $('.is-invalid').removeClass('is-invalid')
	    $('.invalid-feedback').remove()

	    Promise.all([
	    	getLevelData(),
	    ]).then(() => {
	    	 $('#crudModal').modal('show')
	    })
  	}

  	$(document).on('click', '.editButton', function(){
  		let id = $(this).data('id');
  		let form = $('#crudForm')

	    $('.modal-loader').removeClass('d-none')

	    form.trigger('reset')
	    form.find('#btnSubmit').html(`
	      <i class="fa fa-save"></i>
	      Save
	    `)
	    form.data('action', 'add')
	    form.find(`.sometimes`).show()
	    $('#crudModalTitle').text('Edit Modul')
	    $('.is-invalid').removeClass('is-invalid')
	    $('.invalid-feedback').remove()

	    Promise.all([
	    	getLevelData(),
	    	showModul(form, id),
	    ]).then(() => {
	    	 $('#crudModal').modal('show')
	    })
  	});
  	

  	function getLevelData()
  	{
  		$.ajax({
				url: `{{ config('app.api_url') }}level`,
        dataType: 'JSON',
        type: 'GET',
        beforeSend: request => {
          request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
        },
        success:function(response){
        	$.each(response.data, function(index, value) { 
	    			  var optionElement = $("<option>").text(value.nama_level).val(value.uuid);
							$('#level').append(optionElement);
        	});
        }
  		})
  	}


  	function showModul(form, id){
  		$.ajax({
  			url: `{{ config('app.api_url') }}modul/${id}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
        	'Access-Control-Allow-Origin': 'http://192.168.1.226:8000',
          Authorization: `Bearer ${accessToken}`,
          Accept: "application/json",
        },
        crossDomain: true,
        success:response => {
        	let levelIds = [];

        	$.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)

            if (element.is('select')) {
              element.val(value).trigger('change')
            } else {
              element.val(value)
            }
          })
          response.levelData.forEach((role) => {
            levelIds.push(role.id_level)
          });
          form.find(`[name="levelIds[]"]`).val(levelIds).change()
        }
  		});
  	}


</script>
@endpush