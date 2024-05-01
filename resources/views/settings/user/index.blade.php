
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
						<button type="button" class="btn btn-primary mb-3" id="addButton" onclick="createUser()">
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
							<label>Email</label>
							<input type="text" class="form-control" name="email">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-12">
							<label>Password</label>
							<input type="text" class="form-control" name="password">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-12">
							<label>Level</label>
							<select class="form-control" id="id_level" name="id_level">
								<option selected disabled value="">-- PILIH LEVEL --</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-12">
							<label>HP</label>
							<input type="text" class="form-control" name="hp">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-12">
							<label>Status</label>
							<select class="form-control" id="status" name="status">
								<option selected disabled value="">-- PILIH STATUS --</option>
								<option value="aktif">Aktif</option>
								<option value="tidak">Non Aktif</option>
							</select>
						</div>
					</div>
					<div class="col">
		              <div class="row mb-2">
		                <div class="col">
		                  <label class="col-form-label">Upload Photo</label>
		                </div>
		              </div>
		              <div class="dropzone" data-field="photo" id="my-dropzone"></div>

		              <div class="dz-preview dz-file-preview">
		                <div class="dz-details">
		                  <img data-dz-thumbnail />
		                </div>
		              </div>
		              <!-- <div class="dropzone" data-field="phototrado">
		                  <div class="fallback">
		                    <input name="phototrado" type="file" />
		                  </div>
		                </div> -->
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

@push('page_plugins_css')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

@push('page_plugins')
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
@endpush

@push('page_custom_script')
<script>
	Dropzone.autoDiscover = false;
	const accessToken = getCookie('access-token')
	let dropzones = [];
	$(window).ready(function() {

		$('#crudForm').submit(function(e) {
			e.preventDefault();

			let method
			let url
			let userId = $('#crudForm').find('[name=uuid]').val()
			let action = $('#crudForm').data('action')
			let data = $('#crudForm').serializeArray()
			let formData = new FormData()

			dropzones.forEach(dropzone => {
		        const {
		          paramName
		        } = dropzone.options

		        dropzone.files.forEach((file, index) => {
		          formData.append(`${paramName}[${index}]`, file)
		        })
		    })

		    $.each(data, function(key, input) {
		        formData.append(input.name, input.value);
		    });

		   	formData.append('namamenu', `{{ $folder }}`)

			switch (action) {
				case 'add':
					method = 'POST'
					url = `{{ config('app.api_url') }}user`
					break;
				case 'edit':
					method = 'PATCH'
					url = `{{ config('app.api_url') }}user/update/${userId}`
					break;
				case 'delete':
					method = 'DELETE'
					url = `{{ config('app.api_url') }}user/${userId}`
					break;
				default:
					method = 'POST'
					url = `{{ config('app.api_url') }}user`
					break;
			}

			$('#crudForm .is-invalid').removeClass('is-invalid')
			$('#crudForm .invalid-feedback').remove()
			$('#crudForm').find('button:submit')
				.attr('disabled', 'disabled')
				.text('Saving...')

			$.ajax({
				url: url,
				method: 'POST',
				dataType: 'JSON',
				processData: false,
        		contentType: false,
				data: formData,
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
					data: 'nama_level'
				},
				{
					title: 'HP',
					data: 'hp'
				},
				{
					title: 'PHOTO',
					data: 'photo',
					render: function(data){
                        console.log(data)
                        let images = []
                        if (data) {
                            let files = JSON.parse(data)

                            files.forEach(file => {
                                if (file == '') {
                                    file = 'no-image'
                                }
                                let image = new Image()
                                image.width = 75
                                image.height = 100	
                                image.src =
                                    `{{ config('app.api_url') }}photo/image/photo/${encodeURI(file)}/medium/show`

                                images.push(image.outerHTML)
                            });

                            return images.join(' ')
                        } else {
                            let image = new Image()
                            image.width = 75
                            image.height = 100	
                            image.src = `{{ config('app.api_url') }}photo/image/photo/no-image/medium/show`
                            return image.outerHTML
                        }
					}
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
			order: [1, 'desc'],
			initComplete: function (settings, json) {  
		    	checkPermission();      
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
	}

	function createUser() {
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

		Promise.all([
			initDropzone(form.data('action')),
			getLevelData(),
		]).then(() => {
			$('#crudModal').modal('show')
		})

		$('#crudModal').modal('show')
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
		$('#crudModalTitle').text('Edit User')
		$('.is-invalid').removeClass('is-invalid')
		$('.invalid-feedback').remove()
		$(`[name="password"]`).parents('.form-group').remove();
		getLevelData()
		
		Promise.all([
			showUser(form, id),
		]).then((user) => {
			initDropzone(form.data('action'), user)
		}).then(() => {
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
					url: `{{ config('app.api_url') }}user/${id}`,
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

	function getLevelData() {
		$.ajax({
			url: `{{ config('app.api_url') }}level`,
			dataType: 'JSON',
			type: 'GET',
			beforeSend: request => {
				request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
			},
			success: function(response) {
				$('#crudForm').find('[name=id_level]').empty()
				$('#crudForm').find('[name=id_level]').append(
					new Option('-- PILIH LEVEL --', '', false, true)
				).trigger('change')
				$.each(response.data, function(index, value) {
					var optionElement = $("<option>").text(value.nama_level).val(value.uuid);
					$('#id_level').append(optionElement);
				});
			}
		})
	}

	function showUser(form, id) {
		return new Promise((resolve, reject) => {
			$.ajax({
				url: `{{ config('app.api_url') }}user/${id}`,
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
					resolve(response.data);
				}, error : error => {
					reject(error);
				}
			});
		});
	}


	function initDropzone(action, data = null) {
    let buttonRemoveDropzone = `<i class="fas fa-times-circle"></i>`
	    $('.dropzone').each((index, element) => {
	      if (!element.dropzone) {
	        let newDropzone = new Dropzone(element, {
	          url: 'test',
	          thumbnailWidth: null,
	          thumbnailHeight: null,
	          autoProcessQueue: false,
	          addRemoveLinks: true,
	          minFilesize: 100,
	          paramName: $(element).data('field'),
          	  acceptedFiles: 'image/*',
	          init: function() {
	            dropzones.push(this)
	            this.on("addedfile", function(file) {
	              if (this.files.length > 1) {
	                this.removeFile(file);
	              }
	            });
	          }
	        })
	      }

	      element.dropzone.removeAllFiles()

	      if (action == 'edit' || action == 'delete' || action == 'view') {
	        assignAttachment(element.dropzone, data)
	      }
	    })
  	}

  function assignAttachment(dropzone, data) {
    const paramName = dropzone.options.paramName
    const type = paramName.substring(2)

    if (data[0][paramName] == '') {
      $('.dropzone').each((index, element) => {
        if (!element.dropzone) {
	    let newDropzone = new Dropzone(element, {
	          url: 'test',
	          thumbnailWidth: null,
	          thumbnailHeight: null,
	          autoProcessQueue: false,
	          addRemoveLinks: true,
	          minFilesize: 100,
	          paramName: $(element).data('field'),
          	  acceptedFiles: 'image/*',
	          init: function() {
	            dropzones.push(this)
	            this.on("addedfile", function(file) {
	              if (this.files.length > 1) {
	                this.removeFile(file);
	              }
	            });
	          }
	        })
        }

        element.dropzone.removeAllFiles()
      })
    } else {
      let files = JSON.parse(data[0][paramName])
      files.forEach((file) => {
        // ${apiUrl}lampiran/image/kegiatan/${file}/ori/edit
        getImgURL(`{{ config('app.api_url') }}photo/image/${type}/${file}/ori/edit`, (fileBlob) => {
          let imageFile = new File([fileBlob], file, {
            type: 'image/jpeg',
            lastModified: new Date().getTime()
          }, 'utf-8')
          if (fileBlob.type != 'text/html') {
            dropzone.options.addedfile.call(dropzone, imageFile);
            dropzone.options.thumbnail.call(dropzone, imageFile, `{{ config('app.api_url') }}photo/image/${type}/${file}/ori/edit`);
            dropzone.files.push(imageFile)
          }
        })
      })

    }
  }

  function getImgURL(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.onload = function() {
      // console.log(xhr.response);
      callback(xhr.response);
    };
    xhr.open('GET', url);
    xhr.responseType = 'blob';
    xhr.send();
  }
</script>
@endpush