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

                                    <form action="{{ url('/terms-entry') }}" method="POST" autocomplete="off"
                                        class="form-control-validation">
                                        @csrf
                                        <input type="hidden" name="id" id="id" value="0">
                                        <div class="row">







                                            <div class="col mb-12 mt-2">
                                                <div class="form-floating form-floating-outline">
                                                    
                                                    <select name="typ" id="typ"
                                                        class="form-select @error('typ'){{ 'is-invalid' }} @enderror">
                                                        <option value="">--Select--</option>
                                                  
                                                            @foreach ($DeliveryType as $row)
                                                                <option value="{{ $row['id'] }}"
                                                                    {{ isset($TermsEdit) ? ($TermsEdit->type_id == $row['id'] ? 'selected' : '') : '' }}>
                                                                    {{ $row['name'] }}
                                                                </option>
                                                            @endforeach
                                                    
                                                    </select>
                                                    <label for="name">Type</label>
                                                </div>
                                            </div>

                                            <div class="col mb-12 mt-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" id="condition" name="condition" class="form-control"
                                                        value="" placeholder="Add conditions (press Enter to create tags)">
                                                    <label for="condition">Condition</label>
                                                    <small class="form-hint text-danger">
                                                        @error('condition')
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
                                            @if (Helper::checkPermission('is_active'))
                                                <th>Status</th>
                                            @endif
                                            @if (Helper::checkPermission('is_edit'))
                                                <th>Edit</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @foreach ($TermsCondition as $cnt => $row)
                                            <tr>
                                                <td>
                                                    {{ $cnt + 1 }}
                                                </td>
                                                <td>{{ $row->gettype->name }}</td>
                                                <td>{{ $row->content }}</td>
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
                                                @if (Helper::checkPermission('is_edit'))
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

    <!-- Tagify CSS & JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>

    <script>
        // Initialize Tagify for the #condition input with comma-separated output
        var conditionInput = document.getElementById('condition');
        var tagifyCondition = new Tagify(conditionInput, {
            dropdown: {
                enabled: 0
            },
            // Submit value as comma-separated string (e.g. "one,two,three")
            originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
        });

        // If the input already has a value (e.g. old value), populate tags
        if (conditionInput.value) {
            try {
                // If server provided comma-separated string, split into tags
                tagifyCondition.addTags(conditionInput.value.split(',').filter(Boolean));
            } catch (e) {
                // ignore
            }
        }
    </script>

    @if (session()->has('condition_typ') && session()->has('condition_message'))
        <script>
            Swal.fire({
                position: 'center',
                icon: '{{ session('condition_typ') }}',
                title: '{{ session('condition_message') }}',
                showConfirmButton: false,
                timer: 2500
            })
        </script>
    @endif

    <script>
        function changeStatus(id, stat) {
            if (confirm('Are you sure You want to Change Status?') == false) {
                return;
            }

            if (id === '' || stat === '') {
                alert('Something went wrong!!!');
                return;
            }

            $.ajax({
                url: "{{ url('/terms/status') }}",
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
                url: "{{ url('/terms/edit/') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                success: function(response) {
                    if (response.data) {
                        $('#typ').val(response.data.type_id);
                        // Populate Tagify with returned conditions (assumes comma-separated string)
                        try {
                            tagifyCondition.removeAllTags();
                            if (response.data.content) {
                                var tags = response.data.content.split(',').filter(Boolean);
                                tagifyCondition.addTags(tags);
                            }
                        } catch (e) {
                            // fallback to setting raw value
                            $('#condition').val(response.data.content);
                        }
                        $('#id').val(response.data.id);
                        $('#submitBtn').text('Update').prop('disabled', false);
                        $('#typ').focus(); // Focus after populating
                    } else {
                        alert('No data received!');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Something went wrong!!! Error: ' + (xhr.responseJSON?.message || error));
                    $('#submitBtn').prop('disabled', false).text('Submit'); // Reset button
                }
            });
        }
    </script>
@endsection
