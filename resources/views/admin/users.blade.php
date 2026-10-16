@extends('layouts.adminBase')


@section('content')


        <!-- Sidebar Start -->
@include('admin.includes.sidebar')
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            @include('admin.includes.navbar')
            <!-- Navbar End -->

            @if(Auth::user()->email === 'admin@iremetech.com')
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded p-4">
                    <h6 class="mb-3">Add New Admin</h6>
                    <p class="text-muted">The new admin can sign in immediately. No email is sent, so share the password with them directly.</p>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif

                    <form action="{{ route('storeAdmin') }}" method="POST">
                        @csrf
                        <div class="row g-3 text-start">
                            <div class="col-md-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-md-2">
                                <label for="new_admin_password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="new_admin_password" name="password" minlength="8" required autocomplete="new-password">
                            </div>
                            <div class="col-md-2">
                                <label for="new_admin_password_confirmation" class="form-label">Confirm</label>
                                <input type="password" class="form-control" id="new_admin_password_confirmation" name="password_confirmation" minlength="8" required autocomplete="new-password">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Add Admin</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Recent Users</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $order)
                                <tr>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->email }}</td>
                                    <td>{{ $order->role == 1 ? 'Admin' : 'User' }}</td>
                                    <td>
                                        <div class="button-group">
                                            @if($order->role != 1)
                                            <a href="{{ route('makeAdmin', ['id' => $order->id]) }}" class="btn btn-info btn-sm">Make Admin</a>
                                            @endif
                                            @if(Auth::user()->email === 'admin@iremetech.com')
                                            <button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#reset-{{ $order->id }}">Reset Password</button>
                                            @endif
                                            @if($order->email !== 'admin@iremetech.com')
                                            <a href="{{ route('deleteUser', ['id' => $order->id]) }}" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure to do this?')"> <i class="fa fa-trash"></i></a>
                                            @endif
                                        </div>
                                        @if(Auth::user()->email === 'admin@iremetech.com')
                                        <div class="collapse mt-2" id="reset-{{ $order->id }}">
                                            <form action="{{ route('resetUserPassword', $order->id) }}" method="POST" class="d-flex gap-2">
                                                @csrf
                                                <input type="password" name="password" class="form-control form-control-sm" placeholder="New password" minlength="8" required autocomplete="new-password">
                                                <input type="password" name="password_confirmation" class="form-control form-control-sm" placeholder="Confirm" minlength="8" required autocomplete="new-password">
                                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                            </form>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            
                        </table>
                    </div>
                </div>
            </div>
            <!-- Recent Sales End -->



            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">Kivu Peace View Hotel</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a href="https://iremetech.com">Ireme Technologies</a>
                        </br>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        @include('admin.includes.footer')
 @endsection