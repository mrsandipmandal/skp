@extends('admin.template')

@section('main_body')
    <div class="col-xl">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $page_title }}</h5>
                <small class="text-body float-end">Default label</small>
            </div>
            <div class="card-body">

                <!-- Pills -->
                <div class="row g-6">
                    <div class="col-xl-12">
                        <div class="nav-align-top">

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">

                                    <form action="{{ url('/person-entry') }}" method="POST" autocomplete="off"
                                        class="form-control-validation">
                                        @csrf
                                        <input type="hidden" name="id" id="id" value="0">
                                        <div class="row">





                                       

                                            <div class="col mb-12 mt-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" id="name" name="name" class="form-control"
                                                        value="" placeholder="Enter Name">
                                                    <label for="name">Name</label>
                                                    <small class="form-hint text-danger">
                                                        @error('name')
                                                            {{ $message }}
                                                        @enderror
                                                    </small>
                                                </div>
                                            </div>

                                            <div class="col mb-12 mt-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" id="mobile" name="mobile" class="form-control"
                                                        onkeypress="return isNumber(event)" maxlength="10"
                                                        value="" placeholder="Enter Mobile Number">
                                                    <label for="mobile">Mobile Number</label>
                                                    <small class="form-hint text-danger">
                                                        @error('mobile')
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
                                                        class="btn btn-primary waves-effect waves-light">Submit</button>
                                                </div>

                                            </div>
                                        </div>

                                    </form>
                                </div>

                            </div>

                              <hr />

                        <h5 class="card-header">{{ $page_title ?? 'Commission' }} List</h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        @if(Helper::checkPermission('is_active'))
                                        <th>Status</th>
                                        @endif
                                        @if(Helper::checkPermission('is_edit'))
                                        <th>Edit</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($Person as $cnt => $row)
                                        <tr>
                                            <td>
                                                {{ $cnt + 1 }}
                                            </td>
                                            <td>{{ $row->name}}</td>
                                            <td>{{ $row->mobile }}</td>
                                            @if(Helper::checkPermission('is_active'))
                                                <td>
                                                    @if ($row->stat == 0)
                                                        <a href="#" onclick="changeStatus('{{ $row->id }}',1)"><span
                                                                class="badge rounded-pill bg-label-success me-1">Active</span></a>
                                                    @else
                                                        <a href="#" onclick="changeStatus('{{ $row->id }}',0)"><span
                                                                class="badge rounded-pill bg-label-danger me-1">Inactive</span></a>
                                                    @endif
                                                </td>
                                            @endif
                                            @if(Helper::checkPermission('is_edit'))
                                                <td>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="editperson({{ $row->id }})">
                                                        <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
                <!-- Pills -->

            </div>
        </div>
    </div>
@endsection

@section('script_div')
    <script src="{{ asset('assets/js/form-wizard-numbered.js') }}"></script>
    @if (session()->has('person_typ') && session()->has('person_message'))
        <script>
            Swal.fire({
                position: 'center',
                icon: '{{ session('person_typ') }}',
                title: '{{ session('person_message') }}',
                showConfirmButton: false,
                timer: 2500
            })
        </script>
    @endif

    <script>
        function changeStatus(id, stat) {
            if(confirm('Are you sure You want to Change Status?') == false){
                return;
            }

            if (id === '' || stat === '') {
                alert('Something went wrong!!!');
                return;
            }

            $.ajax({
                url: "{{ url('/person/status') }}",
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

        function editperson(id) {
    if (id === '') {
        alert('Something went wrong!!!');
        return;
    }

    // Optional: Show a loading state
    $('#submitBtn').prop('disabled', true).text('Loading...');

    $.ajax({
        url: "{{ url('/person/edit/') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: id,
        },
        success: function(response) {
            if (response.data) {
                $('#name').val(response.data.name);
                $('#mobile').val(response.data.mobile);
                $('#id').val(response.data.id);
                $('#submitBtn').text('Update').prop('disabled', false);
                $('#name').focus();  // Focus after populating
            } else {
                alert('No data received!');
            }
        },
        error: function(xhr, status, error) {
            alert('Something went wrong!!! Error: ' + xhr.responseJSON?.message || error);
            $('#submitBtn').prop('disabled', false).text('Submit');  // Reset button
        }
    });
}

    </script>
@endsection
