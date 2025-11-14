@extends('admin.template')
<style>
    .modal-custom-position {
        position: absolute;
        /* transform: translateX(-10%); */
        transform: translateY(-30%);
    }

    .swal-popup-ontop {
        z-index: 2000 !important;
    }

    .swal2-container {
        z-index: 2000 !important;
    }
</style>
@section('main_body')
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row g-12 mb-12">
                <!-- Float label (Outline) -->
                <div class="col-md">
                    <div class="card">
                        <h5 class="card-header">{{ $page_title ?? 'Course' }}</h5>
                        <div class="card-body">

                            @if (session('course_message'))
                                <div class="alert {{ session('course_status') == 'success' ? 'alert-success' : 'alert-danger' }} alert-dismissible fade show"
                                    role="alert">
                                    {{ session('course_message') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                <script>
                                    setTimeout(function() {
                                        $('.alert').alert('close');
                                    }, 3000);
                                </script>
                            @endif

                            <form action="{{ url('/customer-list') }}" method="get" autocomplete="off"
                                class="form-control-validation">
                                <div class="row">

                                    <div class="col mb-12 mt-2">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" id="search" name="search" class="form-control"
                                                value="{{ request('search') }}" placeholder="Enter Search Keyword">
                                            <label for="search">Search</label>
                                            <small class="form-hint text-danger">
                                                @error('search')
                                                    {{ $message }}
                                                @enderror
                                            </small>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-end">
                                            <button type="submit" id="submitBtn"
                                                class="btn btn-primary waves-effect waves-light">Search</button>
                                        </div>

                                    </div>
                                </div>

                            </form>
                        </div>

                        <hr />

                        <h5 class="card-header">{{ $page_title ?? 'State' }} List</h5>
                        <div class="table-responsive text-nowrap">
                        

                            <table class="table table-hover table-auto table-striped"
                                style="width: 100%; overflow: auto;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                      
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        @if (Helper::checkPermission('is_active'))
                                            <th>Status</th>
                                        @endif
                                       
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($users as $cnt => $row)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>

                                      
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->mobile }}</td>
                                            <td>{{ $row->email }}</td>

                                            @if (Helper::checkPermission('is_active'))
                                                <td>
                                                    @if ($row->stat == 0)
                                                        <a href="#"
                                                            onclick="changeStatus('{{ $row->id }}',1)"><span
                                                                class="badge rounded-pill bg-label-success me-1">Active</span></a>
                                                    @else
                                                        <a href="#"
                                                            onclick="changeStatus('{{ $row->id }}',0)"><span
                                                                class="badge rounded-pill bg-label-danger me-1">Inactive</span></a>
                                                    @endif
                                                </td>
                                            @endif
                                       
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-2">
                                {{ $users->links('pagination::bootstrap-5') }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
        <!-- / Content -->
    </div>
@endsection



@section('script_div')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var table = $('.datatable').DataTable({
                dom: 'rtip',
                pageLength: 10,
                lengthChange: false,
                searching: false,
                buttons: [{
                        extend: 'excel',
                        name: 'excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        name: 'pdf',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        name: 'print',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ],
                columnDefs: [{
                    targets: -1,
                    orderable: false,
                    searchable: false
                }]
            });

            $('#exportSelect').on('change', function() {
                var action = $(this).val();
                if (action) {
                    table.button(action + ':name').trigger();
                    $(this).val('');
                }
            });
        });
    </script>

    <script>
        function changeStatus(id, stat) {
            if (confirm('Are you sure you want to Change Status?') == false) {
                return;
            }

            if (id === '' || stat === '') {
                alert('Something went wrong!!!');
                return;
            }

            $.ajax({
                url: "{{ url('/course/status') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    stat: stat,
                },
                success: function(response) {
                    alert(response.message);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        }

        function editState(id) {
            if (id === '') {
                alert('Something went wrong!!!');
                return;
            }

            $.ajax({
                url: "{{ url('/course/edit') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                success: function(response) {
                    $('#id').val(response.data.id);
                    $('#content_id').val(response.data.content_id);
                    $('#content_id').focus();
                    $('#name').val(response.data.name);
                    $('#duration').val(response.data.duration);

                    $('#StateModal').modal('show');
                },
                error: function(xhr, status, error) {
                    alert('Something went wrong!!!');
                }
            });
        }

        async function submitStateForm(e) {
            e.preventDefault();
            let form = document.getElementById('StateForm');
            let content_id = form.elements['content_id'].value.trim();
            let name = form.elements['name'].value.trim();
            let duration = form.elements['duration'].value.trim();

            let id = form.elements['id'].value;
            // Error

            if (!content_id) {
                document.getElementById('content_id_error').textContent = 'Content ID is required.';
                return;
            }
            if (!name) {
                document.getElementById('name_error').textContent = 'Course Name is required.';
                return;
            }

            if (!duration) {
                document.getElementById('duration_error').textContent = 'Duration is required.';
                return;
            }
            let formData = new FormData();
            formData.append('id', id);
            formData.append('content_id', content_id);
            formData.append('name', name);
            formData.append('duration', duration);


            formData.append('_token', '{{ csrf_token() }}');
            let url = '{{ url('/course/update') }}';

            try {
                let response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                });
                let result;
                try {
                    result = await response.json();
                } catch {
                    result = {};
                }

                if (response.redirected || result.error === false) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: result.message || 'State saved!',
                        showConfirmButton: false,
                        timer: 2500,
                        customClass: {
                            popup: 'swal-popup-ontop'
                        }
                    });
                    $('#StateModal').modal('hide');
                    location.reload();
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: result.message || 'Error occurred!',
                        showConfirmButton: false,
                        timer: 2500,
                        customClass: {
                            popup: 'swal-popup-ontop'
                        }
                    });
                }
            } catch (err) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Server error!',
                    showConfirmButton: false,
                    timer: 2500,
                    customClass: {
                        popup: 'swal-popup-ontop'
                    }
                });
            }
        }
    </script>
@endsection
