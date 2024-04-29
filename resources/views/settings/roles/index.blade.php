@extends('layouts.app')

@section('content')
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Level</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Level</li>
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
					<input type="hidden" name="id">
					<div class="form-group row">
						<div class="col-12">
							<label>Level</label>
							<input type="text" class="form-control" name="nama_level">
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


@push('page_plugins')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
@endpush

@push('page_custom_script')
<script>
	$(document).ready(function() {
		const accessToken = getCookie('access-token')
		let table = $('#dataTable').DataTable({
			processing: true,
			serverSide: true,
			paging: true,
			pageLength: 10,
			lengthMenu: [10, 25, 50, 75, 100],
			ajax: {
				url: `{{ config('app.api_url') }}level`,
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
			columns: [{
					title: '#',
					data: 'uuid',
				},
				{
					title: 'NAMA LEVEL',
					data: 'nama_level'
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
					targets: 6,
					render: (data, type, row) => {
						let editButton = document.createElement('button')
						editButton.dataset.id = row.uuid
						editButton.className = 'btn btn-sm btn-success mr-1 d-inline editButton'
						editButton.innerText = 'edit'

						let deleteButton = document.createElement('button')
						deleteButton.dataset.id = row.uuid
						deleteButton.className = 'btn btn-sm btn-danger d-inline deleteButton'
						deleteButton.innerText = 'delete'

						let aksesMenuButton = document.createElement('button')
						aksesMenuButton.dataset.id = row.uuid
						aksesMenuButton.className = 'btn btn-sm btn-info mr-1 d-inline aksesButton'
						aksesMenuButton.innerText = 'Akses'

						return editButton.outerHTML + deleteButton.outerHTML + aksesMenuButton.outerHTML
					}
				},
			],
			order: [1, 'desc'],
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
			data: {
				accessMenu: `{{ $folder }}`
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
					// $('.aksesButton').attr('disabled', 'disabled')
				}
				if (response.hapus !== "Ya") {
					$('.deleteButton').attr('disabled', 'disabled')
				}
			},
			error: error => {
				console.log(error);
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
		$('#crudModalTitle').text('Create Cabang')
		$('.is-invalid').removeClass('is-invalid')
		$('.invalid-feedback').remove()

		$('#crudModal').modal('show')
	}

	$(document).on('click', '.aksesButton', function() {
		let id = $(this).data('id');
		// console.log(id);
		// window.location.href = `{{ route('roles.akses', ["id" => "` + id + `"]) }}`
		window.location.href = `{{ url("admin/settings/roles") }}/akses/${id}`;
	});
</script>
@endpush