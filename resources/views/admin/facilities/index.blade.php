@extends('layouts.adminBase')


@section('content')


        <!-- Sidebar Start -->
@include('admin.includes.sidebar')
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">

            <div class="row">
                @if (session()->has('success'))
                    <div class="arlert alert-success">
                        <button class="close" type="button" data-dismiss="alert">X</button>
                        {{ session()->get('success') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="arlert alert-danger">
                        <button class="close" type="button" data-dismiss="alert">X</button>
                        {{ session()->get('error') }}
                    </div>
                @endif
            </div>
            <!-- Navbar Start -->
            @include('admin.includes.navbar')
            <!-- Navbar End -->

            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Our Facilities</h6>
                        <div class="col-dm3">
                            <button type="button" class="btn btn-primary float-left" data-bs-toggle="modal" data-bs-target="#NewProduct">
                                Add New Facility
                              </button>
                        </div>
                        {{-- <a href="">Show All</a> --}}
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    {{-- <th scope="col"><input class="form-check-input" type="checkbox"></th> --}}
                                    <th scope="col">Facility Title</th>
                                    <th scope="col">Cover Image</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($facilities as $rs)
                                <tr>
                                    {{-- <td><input class="form-check-input" type="checkbox"></td> --}}
                                    <td><a href="{{ route('editFacility',['id'=>$rs->id]) }}">{{ $rs->title }}</a> 
                                    <br> <spam>{{$rs->images->count()}} Images  
                                    </td>
                                    <td><img src="{{ asset('storage/images/facilities/' .$rs->image) }}" alt="" width="120px"></td>
                                    <td>{!! Str::words($rs->description, 50, '...') !!}</td>
                                    <td>
                                        <div class="bg-light rounded ">
                                            <div class="btn-group" role="group">
                                                {{-- <button type="button" class="btn btn-danger"><i class="fa fa-eye"></i></button> --}}
                                                <a href="{{ route('editFacility',['id'=>$rs->id]) }}" class="btn btn-info"><i class="fa fa-images"></i></a>
                                                <a href="{{ route('deleteFacility',['id'=>$rs->id]) }}" class="btn btn-warning"  onclick="return confirm('Are you sure to delete this item?')"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- Content End -->


        <!-- The Modal -->
        <div class="modal fade" id="NewProduct">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
        
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">Adding New Facility</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
        
                <!-- Modal body -->
                <div class="modal-body">
                    <form class="form" action="{{ route('storeFacility') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="row mb-3">
                            <div class="col-lg-4 col-sm-12">
                                <label for="title" class="form-label">Facility Title</label>
                                <input type="text" name="title" class="form-control"
                                    id="title" placeholder="Eg: Heading" required="">
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <label for="image" class="form-label">Cover Image</label>
                            <div class="input-group">

                                <input type="file" name="image" class="form-control"
                                    id="image" required="">

                            </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <label for="summernote" class="form-label">Description</label>
                                <textarea id="facilityDescription" rows="5" class="form-control" name="description"></textarea>
                            </div>

                        </div>
                        
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary text-black">
                            <i class="fa fa-save"></i> Save
                        </button>

                    </div>
                    </form>
                </div>
        
                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
        
            </div>
            </div>
        </div>
        @include('admin.includes.footer')
 @endsection