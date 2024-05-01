@extends('layouts.app')

@section('content')
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Menu</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Menu</li>
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
						<button type="button" class="btn btn-primary mb-3" id="addButton" onclick="createMenu()">
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
							<label>Config Modul</label>
							<select class="form-control" id="id_config_modul" name="id_config_modul">
								<option selected disabled value="">-- PILIH MODUL --</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-12">
							<label>Nama</label>
							<input type="text" class="form-control" name="nama_menu">
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
							<label>Link</label>
							<input type="text" class="form-control" name="link">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-12">
							<label>Parent</label>
							<select class="form-control" id="id_parent" name="id_parent">
							</select>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-12">
							<label>Nomor Urut</label>
							<input type="text" class="form-control" name="nomor_urutan">
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
		getModulData()
		getParentData()
		$('#crudForm').submit(function(e) {
			e.preventDefault();

			let method
			let url
			let menuId = $('#crudForm').find('[name=uuid]').val()
			let action = $('#crudForm').data('action')
			let data = $('#crudForm').serializeArray()

			data.push({
				name: 'namamenu',
				value: `{{ $folder }}`,
			})

			switch (action) {
				case 'add':
					method = 'POST'
					url = `{{ config('app.api_url') }}menu`
					break;
				case 'edit':
					method = 'PATCH'
					url = `{{ config('app.api_url') }}menu/${menuId}`
					break;
				case 'delete':
					method = 'DELETE'
					url = `{{ config('app.api_url') }}menu/${menuId}`
					break;
				default:
					method = 'POST'
					url = `{{ config('app.api_url') }}menu`
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
				data: data,
				beforeSend: request => {
					request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
				},
				success: response => {
					fireToast('success', '', response.message)

					$('#crudModal').modal('hide')
					$('#crudForm').trigger('reset')
					table.ajax.reload(checkPermission, false)
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
				url: `{{ config('app.api_url') }}menu`,
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
					title: 'NAMA MENU',
					data: 'nama_menu'
				},
				{
					title: 'LINK',
					data: 'link'
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
					data: 'nomor_urutan'
				},
				{
					title: 'PARENT',
					data: 'nama_menu_parent'
				},
				{
					title: 'MODUL',
					data: 'nama_modul'
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
					targets: 11,
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
			initComplete: function(settings, json){
				checkPermission()
			}
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
	});

	$('#crudModal').on('hidden.bs.modal', () => {
		$('#crudForm').trigger('reset')
	})

	function checkPermission(){	
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
				}
				if (response.hapus !== "Ya") {
					$('.deleteButton').attr('disabled', 'disabled')
				}
			}
		})
	}

	function createMenu() {
		let form = $('#crudForm')

		$('.modal-loader').removeClass('d-none')

		form.trigger('reset')
		form.find('#btnSubmit').html(`
	      <i class="fa fa-save"></i>
	      Save
	    `)
		form.data('action', 'add')
		form.find(`.sometimes`).show()
		$('#crudModalTitle').text('Create Menu')
		$('.is-invalid').removeClass('is-invalid')
		$('.invalid-feedback').remove()

		Promise.all([
			getModulData(),
			getParentData(),
		]).then(() => {
			$('#crudModal').modal('show')
		})
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
		$('#crudModalTitle').text('Edit Menu')
		$('.is-invalid').removeClass('is-invalid')
		$('.invalid-feedback').remove()

		Promise.all([
			showMenu(form, id),
		]).then(() => {
			$('#crudModal').modal('show')
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
					url: `{{ config('app.api_url') }}menu/${id}`,
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


	function getModulData() {
		$.ajax({
			url: `{{ config('app.api_url') }}modul`,
			dataType: 'JSON',
			type: 'GET',
			beforeSend: request => {
				request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
			},
			success: function(response) {
				$('#crudForm').find('[name=id_config_modul]').empty()
				$('#crudForm').find('[name=id_config_modul]').append(
					new Option('-- PILIH MODUL --', '', false, true)
				).trigger('change')
				$.each(response.data, function(index, value) {
					var optionElement = $("<option>").text(value.nama).val(value.uuid);
					$('#id_config_modul').append(optionElement);
				});
			}
		})
	}

	// $("select#id_config_modul").change(function() {
	// 	var selectedCountry = $(this).children("option:selected").val();
	// 	alert("You have selected the country - " + selectedCountry);
	// });

	function getParentData() {
		$.ajax({
			url: `{{ config('app.api_url') }}menu/get`,
			dataType: 'JSON',
			type: 'GET',
			data: {
				id_parent: '0',
			},
			beforeSend: request => {
				request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
			},
			success: function(response) {
				$('#crudForm').find('[name=id_parent]').empty()
				$('#crudForm').find('[name=id_parent]').append(
					new Option('-- PILIH PARENT --', '', false, true)
				).trigger('change')
				$.each(response.data, function(index, value) {
					var optionElement = $("<option>").text(value.nama_menu).val(value.uuid);
					$('#id_parent').append(optionElement);
				});
			}
		})
	}


	function showMenu(form, id) {
		return new Promise((resolve, reject) => {
			$.ajax({
				url: `{{ config('app.api_url') }}menu/${id}`,
				method: 'GET',
				dataType: 'JSON',
				headers: {
					Authorization: `Bearer ${accessToken}`,
					Accept: "application/json",
				},
				crossDomain: true,
				success: response => {
					$.each(response.data, (index, value) => {
						let element = form.find(`[name="${index}"]`)

						if (element.is('select')) {
							element.val(value).trigger('change')
						} else {
							element.val(value)
						}
						// form.find(`[name="id_parent"]`).val()
					})
					resolve()
				},
				error: error => {
					reject(error)
				}
			});
		})
	}
</script>
@endpush