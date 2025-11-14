@extends('admin.template')
@section('main_body')

    <div class="row row-cards">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Menu Entry Form</h3>
                </div>

                <form action="{{ route('menu.save') }}" method="post" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="sl" id="sl" class="form-control span12"
                                value="{{ isset($MenuEdit) ? $MenuEdit->sl : 0 }}">

                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-6">
                                    <select name="root_menu" id="root_menu"
                                        class="form-select @error('root_menu'){{ 'is-invalid' }} @enderror">
                                        <option value="">--Select--</option>
                                        @if (isset($Menu))
                                            @foreach ($Menu as $menu)
                                                <option value="{{ $menu['sl'] }}"
                                                    {{ isset($MenuEdit) ? ($MenuEdit->root_menu == $menu['sl'] ? 'selected' : '') : '' }}>
                                                    {{ $menu['menu_name'] }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="root_menu">Menu</label>
                                    <small class="form-hint text-danger">
                                        @error('root_menu')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-6">
                                    <input type="text" name ="menu_name" id="menu_name"
                                        value="{{ isset($MenuEdit) ? $MenuEdit->menu_name : old('menu_name') }}"
                                        class="form-control @error('menu_name'){{ 'is-invalid' }} @enderror"
                                        placeholder="Type Menu Name Here">
                                    <label for="menu_name">Menu Name</label>
                                    <small class="form-hint text-danger">
                                        @error('menu_name')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-6">
                                    <input type="text" name ="route_name" id="route_name"
                                        value="{{ isset($MenuEdit) ? $MenuEdit->route_name : old('route_name') }}"
                                        class="form-control @error('route_name'){{ 'is-invalid' }} @enderror"
                                        placeholder="Type Route Here">
                                    <label for="route_name">Route</label>
                                    <small class="form-hint text-danger">
                                        @error('route_name')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-6">
                                    <input type="number" name ="ordr" id="ordr"
                                        value="{{ isset($MenuEdit) ? $MenuEdit->ordr : old('ordr') }}"
                                        class="form-control @error('ordr'){{ 'is-invalid' }} @enderror"
                                        placeholder="Type Order By Here">
                                    <label for="ordr">Order By</label>
                                    <small class="form-hint text-danger">
                                        @error('ordr')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-12">
                                    <input type="text" name ="icon" id="icon"
                                        class="form-control @error('icon'){{ 'is-invalid' }} @enderror"
                                        placeholder="Enter or Paste Icon Name"
                                        value="{{ isset($MenuEdit) ? $MenuEdit->icon : old('icon') }}">
                                    <label for="icon">Enter or Paste Icon Name</label>
                                    <a title="*Remix Icon Name Copy From Here*" href="https://remixicon.com"
                                        target="_blank">🔗</a>
                                    <small class="form-hint text-danger">
                                        @error('icon')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                            </div>

                            <div class="col-md p-6">
                                <label class="switch switch-square">
                                    <input type="checkbox" class="switch-input" name="is_edit" value="1"
                                        {{ isset($MenuEdit) && $MenuEdit->is_edit == 1 ? 'checked' : '' }}>
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="icon-base ri ri-check-line"></i></span>
                                        <span class="switch-off"><i class="icon-base ri ri-close-line"></i></span>
                                    </span>
                                    <span class="switch-label">Edit</span>
                                </label>
                            </div>
                            <div class="col-md p-6">
                                <label class="switch switch-square">
                                    <input type="checkbox" class="switch-input" name="is_delete" value="1"
                                        {{ isset($MenuEdit) && $MenuEdit->is_delete == 1 ? 'checked' : '' }}>
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="icon-base ri ri-check-line"></i></span>
                                        <span class="switch-off"><i class="icon-base ri ri-close-line"></i></span>
                                    </span>
                                    <span class="switch-label">Delete</span>
                                </label>
                            </div>
                            <div class="col-md p-6">
                                <label class="switch switch-square">
                                    <input type="checkbox" class="switch-input" name="is_active" value="1"
                                        {{ isset($MenuEdit) && $MenuEdit->is_active == 1 ? 'checked' : '' }}>
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="icon-base ri ri-check-line"></i></span>
                                        <span class="switch-off"><i class="icon-base ri ri-close-line"></i></span>
                                    </span>
                                    <span class="switch-label">Active/Inactive</span>
                                </label>
                            </div>
                            <div class="col-md p-6">
                                <label class="switch switch-square">
                                    <input type="checkbox" class="switch-input" name="is_export" value="1"
                                        {{ isset($MenuEdit) && $MenuEdit->is_export == 1 ? 'checked' : '' }}>
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="icon-base ri ri-check-line"></i></span>
                                        <span class="switch-off"><i class="icon-base ri ri-close-line"></i></span>
                                    </span>
                                    <span class="switch-label">Export</span>
                                </label>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                @if (isset($MenuEdit))
                                    @php
                                        $btn_val = 'Update';
                                        $btn_cls = 'success';
                                    @endphp
                                @else
                                    @php
                                        $btn_val = 'Submit';
                                        $btn_cls = 'primary';
                                    @endphp
                                @endif

                                <div class="text">
                                    <button type="submit"
                                        class="btn btn-{{ $btn_cls }}">{{ $btn_val }}</button>
                                </div>

                            </div>
                        </div>

                    </div>

                </form>

                <hr>
                <h5 class="card-header">{{ $page_title }} List</h5>
                <div class="table-responsive text-nowrap">

                    <table class="invoice-list-table table border-top">
                        <thead>
                            <tr>
                                <th>#</th>
                                @if (Helper::checkPermission('is_export'))
                                    <th>Export</th>
                                @endif
                                @if (Helper::checkPermission('is_edit'))
                                    <th>Edit</th>
                                @endif
                                @if (Helper::checkPermission('is_active'))
                                    <th>Status</th>
                                @endif
                                <th>Main Menu Name</th>
                                <th>Menu Name </th>
                                <th>Route Name </th>
                                <th>Order</th>
                                <th>Assigned</th>
                                <th>Permissions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Menu as $key => $row)
                                @php
                                    $menu_name = $row['menu_name'];
                                    $route_name = $row['route_name'];
                                    $root_menu = $row['root_menu'];
                                    $ordr = $row['ordr'];
                                    $icon = $row['icon'];
                                    $user = $row['user'];
                                    $isall = $row['isall'];
                                    $is_edit = $row['is_edit'];
                                    $is_delete = $row['is_delete'];
                                    $is_active = $row['is_active'];
                                    $is_export = $row['is_export'];
                                    $stat = $row['stat'];
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    @if (Helper::checkPermission('is_export'))
                                        <td>
                                            <button class="btn btn-primary btn-sm waves-effect waves-light"
                                                onclick="assign('{{ $row['sl'] }}','{{ $row['user'] }}','{{ $row['isall'] }}')">
                                                <i
                                                    class="icon-base ri ri-add-line icon-sm me-0 me-sm-1"></i>Assign</button>
                                        </td>
                                    @endif
                                    @if (Helper::checkPermission('is_edit'))
                                        <td>
                                            <button class="btn btn-info btn-sm waves-effect waves-light"
                                                onclick="location.href='{{ url('menu-edit/') }}?sl={{ $row['sl'] }}'">
                                                <i class="icon-base ri ri-edit-line icon-sm me-0 me-sm-1"></i> Edit
                                            </button>
                                        </td>
                                    @endif
                                    @if (Helper::checkPermission('is_active'))
                                        <td>
                                            @if ($stat == 0)
                                                <button class="btn btn-success btn-sm waves-effect waves-light"
                                                    onclick="status_update('{{ $row['sl'] }}','1')" title="Click to Inactive">
                                                    <i class="icon-base ri ri-check-line icon-sm me-0 me-sm-1"></i>Active
                                                </button>
                                            @else
                                                <button class="btn btn-danger btn-sm waves-effect waves-light"
                                                    onclick="status_update('{{ $row['sl'] }}','0')" title="Click to Active">
                                                    <i class="icon-base ri ri-close-line icon-sm me-0 me-sm-1"></i>Inactive
                                                </button>
                                            @endif
                                        </td>
                                    @endif
                                    <td>
                                        @if (\App\Helpers\Helper::searchForId($root_menu, $Menu, 'sl', 'menu_name') == '')
                                            <span class="btn btn-outline-success">ROOT MENU</span>
                                        @else
                                            <span class="btn btn-outline-primary">
                                                <i
                                                    class="menu-icon icon-base ri ri-{{ \App\Helpers\Helper::searchForId($root_menu, $Menu, 'sl', 'icon') }}"></i>{{ \App\Helpers\Helper::searchForId($root_menu, $Menu, 'sl', 'menu_name') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td><i class="menu-icon icon-base ri ri-{{ $icon }}"></i>{{ $menu_name }}
                                    </td>
                                    <td>{{ $route_name }}</td>
                                    <td>{{ $ordr }}</td>
                                    <td>
                                        @php
                                            if ($user != '') {
                                                $arr = explode(',', $user);
                                                $filteredArr = array_diff($arr, ['Admin', 'Users', 'Super Admin']);
                                                $output = [];
                                                foreach ($filteredArr as $item) {
                                                    echo '<span class="badge rounded-pill bg-label-info me-4">' .
                                                        $usertype[
                                                            array_search(
                                                                $item,
                                                                array_column($usertype->toArray(), 'userlevel'),
                                                            )
                                                        ]['typ'] .
                                                        '</span>';
                                                }
                                            }
                                            if ($isall != '') {
                                                echo $isall == '1'
                                                    ? '<span class="badge rounded-pill bg-label-success me-4">All Groups</span>'
                                                    : '';
                                            }
                                        @endphp
                                    </td>
                                    <td>
                                        <div class="card-body d-sm-flex d-block">
                                            @if ($is_edit)
                                                <span class="badge rounded-pill bg-label-success me-4"><i
                                                        class="icon-base ri ri-check-line"></i> Edit</span>
                                            @else
                                                <span class="badge rounded-pill bg-label-danger me-4"><i
                                                        class="icon-base ri ri-close-line"></i> Edit</span>
                                            @endif

                                            @if ($is_delete)
                                                <span class="badge rounded-pill bg-label-success me-4"><i
                                                        class="icon-base ri ri-check-line"></i> Delete</span>
                                            @else
                                                <span class="badge rounded-pill bg-label-danger me-4"><i
                                                        class="icon-base ri ri-close-line"></i> Delete</span>
                                            @endif

                                            @if ($is_active)
                                                <span class="badge rounded-pill bg-label-success me-4"><i
                                                        class="icon-base ri ri-check-line"></i> Active</span>
                                            @else
                                                <span class="badge rounded-pill bg-label-danger me-4"><i
                                                        class="icon-base ri ri-close-line"></i> Active</span>
                                            @endif

                                            @if ($is_export)
                                                <span class="badge rounded-pill bg-label-success me-4"><i
                                                        class="icon-base ri ri-check-line"></i> Export</span>
                                            @else
                                                <span class="badge rounded-pill bg-label-danger me-4"><i
                                                        class="icon-base ri ri-close-line"></i> Export</span>
                                            @endif
                                            </>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('modal_div')
    <!--  end assign modal  -->
    <div class="modal modal-blur fade" id="modal-large" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ url('/menu-assigns') }}" method="post" autocomplete="off">
                    @csrf
                    <input type="hidden" id="id" name="sl">
                    <div class="modal-header">
                        <h5 class="modal-title">Assign User Groups</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-12">
                                <select id="mySelect" name="user[]" class="form-control Mselect2" multiple>
                                    <option value="">-----</option>
                                </select>
                                <label for="mySelect">User Group</label>
                            </div>
                            <label class="switch switch-square">
                                <input type="checkbox" class="switch-input" name="isall" id="isall" value="1" />
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"><i class="icon-base ri ri-check-line"></i></span>
                                    <span class="switch-off"><i class="icon-base ri ri-close-line"></i></span>
                                </span>
                                <span class="switch-label">All</span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Assign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--  end assign modal  -->

    <div class="modal modal-blur fade" id="asignModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-success"></div>
                <div class="modal-body text-center py-4">
                    <!-- Download SVG icon from http://tabler-icons.io/i/circle-check -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-green icon-lg" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <circle cx="12" cy="12" r="9" />
                        <path d="M9 12l2 2l4 -4" />
                    </svg>
                    <h3>Entry succedeed</h3>
                    <div class="text-muted">publicEdit Entry Completed. You Can Go for Another Entry or View
                        publicEdit List.</div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                                    Go for Another Entry
                                </a></div>
                            <div class="col"><a href="{{ url('/view-publicEdit') }}" class="btn btn-success w-100">
                                    View publicEdit List
                                </a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script_div')
    @if (session()->has('Menu_type') && session()->has('Menu_msg'))
        <script>
            Swal.fire({
                position: 'center',
                icon: '{{ session('Menu_type') }}',
                title: '{{ session('Menu_msg') }}',
                showConfirmButton: false,
                timer: 2500
            })
        </script>
    @endif
    <script>
        function assign(sl, user = '', isall = '') {
            if (sl) {
                // Set the value of the hidden field with the ID "id"
                document.getElementById('id').value = sl;
                // URL for fetching data
                const url = "{{ url('/menu-assign') }}";
                // Initialize Select2 for the select field with class "Mselect2"
                $('#mySelect').select2({
                    dropdownParent: $('#modal-large'),
                    width: '100%'
                });
                // Fetch data from the server
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        // Get the select field with the ID "mySelect"
                        const selectField = document.getElementById('mySelect');
                        selectField.innerHTML = '<option value="">-----</option>'; // Reset options
                        // Split the user value into an array of selected values
                        const selectedValues = user.split(',').map(val => val.trim());
                        // Loop through each item in the data
                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.userlevel.toString(); // Convert to string for comparison
                            option.textContent = item.typ;
                            // Check if the item's value matches any value in the selectedValues array
                            if (selectedValues.includes(option.value)) {
                                option.selected = true; // Pre-select the option if it matches
                            }
                            selectField.appendChild(option);
                        });
                        // Reinitialize Select2 to update the selection
                        $('#mySelect').trigger('change');
                        // Set the "isall" checkbox based on the isall parameter
                        if (isall === '1') {
                            document.getElementById('isall').checked = true;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                    });
                // Show the modal with the ID "modal-large"
                $('#modal-large').modal('show');
            }
        }

        function status_update(sl,stat) {
            if (sl == '' || stat == '') {
                alert('Something went wrong!!!');
                return false;
            } else {
                if (!confirm('Are you sure you want to continue?')) {
                    return false;
                } else {
                    document.location = "{{ url('menu-status-update') }}?sl=" + encodeURIComponent(sl) + "&stat=" + encodeURIComponent(stat);
                }
            }
        }
    </script>
    @if (isset($msg))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("smod").click();
            });
        </script>
    @endif
@endsection
