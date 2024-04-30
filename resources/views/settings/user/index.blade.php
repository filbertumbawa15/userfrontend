@extends('layouts.app')

@section('content')
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>User</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">User</li>
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
							<label>Level</label>
							<input type="text" class="form-control" name="nama_level">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="btnSubmit">Save</button>
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
	const accessToken = getCookie('access-token')
	$(window).ready(function() {

		$('#crudForm').submit(function(e) {
			e.preventDefault();

			let method
			let url
			let levelId = $('#crudForm').find('[name=uuid]').val()
			let action = $('#crudForm').data('action')
			let data = $('#crudForm').serializeArray()

			switch (action) {
				case 'add':
					method = 'POST'
					url = `{{ config('app.api_url') }}level`
					break;
				case 'edit':
					method = 'PATCH'
					url = `{{ config('app.api_url') }}level/${levelId}`
					break;
				case 'delete':
					method = 'DELETE'
					url = `{{ config('app.api_url') }}level/${levelId}`
					break;
				default:
					method = 'POST'
					url = `{{ config('app.api_url') }}level`
					break;
			}

			$('#crudForm .is-invalid').removeClass('is-invalid')
			$('#crudForm .invalid-feedback').remove()
			$('#crudForm').find('button:submit')
				.attr('disabled', 'disabled')
				.text('Saving...')

			$.ajax({
				url: url,
				method: method,
				dataType: 'JSON',
				data: $('#crudForm').serializeArray(),
				beforeSend: request => {
					request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
				},
				success: response => {
					fireToast('success', '', response.message)

					$('#crudModal').modal('hide')
					$('#crudForm').trigger('reset')
					table.ajax.reload(null, false)
				}
			}).always(() => {
				$('#crudForm').find('button:submit')
					.removeAttr('disabled')
					.text('Save')
			})

		});

		let table = $('#dataTable').DataTable({
			processing: true,
			serverSide: true,
			paging: true,
			pageLength: 10,
			lengthMenu: [10, 25, 50, 75, 100],
			ajax: {
				url: `{{ config('app.api_url') }}user`,
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
					title: 'NAMA',
					data: 'nama'
				},
				{
					title: 'EMAIL',
					data: 'email'
				},
				{
					title: 'LEVEL',
					data: 'level'
				},
				{
					title: 'HP',
					data: 'hp'
				},
				{
					title: 'PHOTO',
					data: 'photo'
				},
				{
					title: 'STATUS',
					data: 'status'
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
		$('#crudModalTitle').text('Create User')
		$('.is-invalid').removeClass('is-invalid')
		$('.invalid-feedback').remove()

		$('#crudModal').modal('show')
	}

	function checkModul(id) {
		return new Promise((resolve, reject) => {
			$.ajax({
				url: `{{ config('app.api_url') }}getmodulbylevel`,
				type: 'GET',
				dataType: 'JSON',
				data: {
					level: id,
				},
				beforeSend: request => {
					request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
				},
				success: response => {
					resolve(response);
				},
				error: error => {
					reject(error);
				}
			})
		});
	}

	$(document).on('click', '.editButton', function() {
		let id = $(this).data('id');
		let form = $('#crudForm')

		$('.modal-loader').removeClass('d-none')

		form.trigger('reset')
		form.find('#btnSubmit').html(`
	      <i class="fa fa-save"></i>
	      Save
	    `)
		form.data('action', 'edit')
		form.find(`.sometimes`).show()
		$('#crudModalTitle').text('Edit Modul')
		$('.is-invalid').removeClass('is-invalid')
		$('.invalid-feedback').remove()

		Promise.all([
			showModul(form, id),
		]).then(() => {
			$('#crudModal').modal('show')
		})
	});

	$(document).on('click', '.aksesButton', function() {
		let id = $(this).data('id');
		checkModul(id).then((response) => {
			if (response.data.length == 0) {
				fireToast('warning', 'Warning', 'Modul masih kosong');
			} else {
				window.location.href = `{{ url("admin/settings/level") }}/akses/${id}`;
			}
		})
	});

	$(document).on('click', '.deleteButton', function() {
		/* Handle onclick .deleteButton */
		let id = $(this).data('id')

		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					method: 'DELETE',
					url: `{{ config('app.api_url') }}level/${id}`,
					dataType: 'JSON',
					beforeSend: request => {
						request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
					},
					success: response => {
						// table.ajax.reload(null, false)
						window.location.reload();

						fireToast('success', 'Deleted!', 'data has been deleted')
					}
				})
			}
		})
	})

	function showModul(form, id) {
		$.ajax({
			url: `{{ config('app.api_url') }}level/${id}`,
			method: 'GET',
			dataType: 'JSON',
			headers: {
				Authorization: `Bearer ${accessToken}`,
				Accept: "application/json",
			},
			success: response => {
				$.each(response.data, (index, value) => {
					let element = form.find(`[name="${index}"]`)
					if (element.is('select')) {
						element.val(value).trigger('change')
					} else {
						element.val(value)
					}
				})
			}
		});
	}
</script>
@endpush