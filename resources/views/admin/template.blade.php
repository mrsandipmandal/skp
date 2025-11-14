@include('admin.header')
@include('admin.left_bar')
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    @yield('main_body')
    <div class="content-backdrop fade"></div>
    @include('admin.footer')
    @yield('modal_div')
    <div class="modal modal-blur fade" id="modal-change-pass" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="post" action="{{ url('change-password') }}" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title">Change Password
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body">
                        <p class="card-title text-center text-danger">
                            @if (isset($perr))
                                @if ($perr)
                                    Old Password Mismatched....
                                @endif
                            @endif
                        </p>
                        @csrf
                        <div>
                            <div class="form-group mb-3 ">
                                <label class="form-label required">Old Password</label>
                                <div>
                                    <input type="text" name ="oldpass" value=""
                                        class="form-control @error('oldpass'){{ 'is-invalid' }} @enderror"
                                        placeholder="Enter Old Password">
                                    <small class="form-hint text-danger">
                                        @error('oldpass')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="form-group mb-3 ">
                                <label class="form-label required">New Password</label>
                                <div>
                                    <input type="text" name ="password" value=""
                                        class="form-control @error('password'){{ 'is-invalid' }} @enderror"
                                        placeholder="Enter New Password">
                                    <small class="form-hint text-danger">
                                        @error('password')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="form-group mb-3 ">
                                <label class="form-label required">Confirm New Password</label>
                                <div>
                                    <input type="text" name ="password_confirmation" value=""
                                        class="form-control @error('password_confirmation'){{ 'is-invalid' }} @enderror"
                                        placeholder="Confirm New Password">
                                    <small class="form-hint text-danger">
                                        @error('password_confirmation')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    @yield('script_div')
    @error('oldpass')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("change_pass").click();
            });
        </script>
    @enderror

    @error('password')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("change_pass").click();
            });
        </script>
    @enderror

    @error('password_confirmation')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("change_pass").click();
            });
        </script>
    @enderror
    </body>

    </html>
