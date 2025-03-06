@extends('backend.layout.master')

@section('content')
    <style>
        .dataTables_filter,
        .dataTables_info {
            display: none;
        }

        .dataTables_length {
            display: none;
        }
    </style>

    {{--Adding toast--}}
    <div class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Hello, world! This is a toast message.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    {{-- add new Link modal start --}}

    <div class="modal fade" id="addSliderLinkModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Link</h5>
                </div>
                <form action="#" method="post" id="add_slider_link" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4 bg-light">
                        <div class="row">
                            <div class="col-lg">
                                <label for="fname">Link</label>
                                <input type="text" name="sliderlink" class="form-control"
                                       placeholder="Slider Link" required>
                            </div>
                            <div class="col-lg">
                                <label for="lname">Position</label>
                                <input type="number" name="sliderlocation" class="form-control"
                                       placeholder="Slide Position" required>
                            </div>
                        </div>


                        <div class="my-2">
                            <label for="avatar">Select Avatar</label>
                            <input type="file" name="avatar" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="add_slider_link_btn" class="btn btn-primary">Add Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- add new link modal end --}}

    {{-- edit link modal start --}}
    <div class="modal fade" id="editSliderLinkModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Link</h5>
                </div>
                <form action="#" method="POST" id="edit_Slider_link_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="icon_id" id="icon_id">
                    <input type="hidden" name="icon_avatar" id="icon_avatar">
                    <div class="modal-body p-4 bg-light">
                        <div class="row">
                            <div class="col-lg">
                                <label for="fname">Link</label>
                                <input type="text" name="sliderlink" id="Sliderlink" class="form-control"
                                       placeholder="Slider Link" required>
                            </div>
                            <div class="col-lg">
                                <label for="lname">Position</label>
                                <input type="number" name="sliderposition" id="Sliderposition"
                                       class="form-control" placeholder="Slider Position" required>
                            </div>
                        </div>

                        <div class="my-2">
                            <label for="avatar">Select Avatar</label>
                            <input type="file" name="avatar" class="form-control">
                        </div>
                        <div class="mt-2" id="avatar">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="edit_Slider_link_btn" class="btn btn-success">Update
                            Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- edit link modal end --}}

    <div class="container-fluid">
        <div class="row my-5">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <h3 class="text-light">Manage Employees</h3>
                       {{-- <button class="btn btn-light" data-bs-toggle="modal"
                                data-bs-target="#addSliderLinkModal"><i class="bi-plus-circle me-2"></i>Add New Employee</button>--}}

                         <a href="{{route('users.create')}}" class="btn btn-light"><i class="bi-plus-circle me-2"></i>Add New Employee</a>
                    </div>
                    <div class="card-body" id="show_all_Employee_links">
                        <h1 class="text-center text-secondary my-5">Loading...</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--Innser Code Ends Here--}}

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>

    <script>
        $(function () {
            // Delete User
                        // delete link ajax request
                        $(document).on('click', '.deleteIcon', function (e) {
                            e.preventDefault();
                            let id = $(this).attr('id');
                            let csrf = '{{ csrf_token() }}';
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
                                        url: '{{ route('users.destroy') }}',
                                        method: 'delete',
                                        data: {
                                            id: id,
                                            _token: csrf
                                        },
                                        success: function (response) {
                                            console.log(response);
                                            Swal.fire(
                                                'Deleted!',
                                                'Record has been deleted.',
                                                'success'
                                            )
                                            fetchSlierAllLinks();
                                        }
                                    });
                                }
                            })
                        });

                        // fetch all links ajax request

            // fetch all links ajax request
            fetchSlierAllLinks();

            function fetchSlierAllLinks() {
                $.ajax({
                    url: '{{ route('users.view') }}',
                    method: 'get',
                    success: function (response) {
                        $("#show_all_Employee_links").html(response);
                        $("table").DataTable({
                            order: [0, 'asc']
                        });
                    }
                });
            }
        });
    </script>
@endsection
{{--    New COde Start From Here--}}


{{--    <script>--}}
{{--        // Slider Images Crud Start Form Her Here--}}
{{--        /*-----------------------------------------------------------------------------------------------------------------*/--}}


{{--        $(function () {--}}

{{--            // add new Link ajax request--}}
{{--            $("#add_slider_link").submit(function (e) {--}}
{{--                e.preventDefault();--}}
{{--                const fd = new FormData(this);--}}
{{--                $("#add_slider_link_btn").text('Adding...');--}}
{{--                $.ajax({--}}
{{--                    --}}{{--url: '{{ route('admin.sliderstore') }}',--}}
{{--                    method: 'post',--}}
{{--                    data: fd,--}}
{{--                    cache: false,--}}
{{--                    contentType: false,--}}
{{--                    processData: false,--}}
{{--                    dataType: 'json',--}}
{{--                    success: function (response) {--}}
{{--                        if (response.status == 200) {--}}
{{--                            Swal.fire(--}}
{{--                                'Added!',--}}
{{--                                'Link Added Successfully!',--}}
{{--                                'success'--}}
{{--                            )--}}
{{--                            fetchSlierAllLinks();--}}
{{--                        }--}}
{{--                        $("#add_slider_link_btn").text('Add Link');--}}
{{--                        $("#add_slider_link")[0].reset();--}}
{{--                        $("#addSliderlinkModal").modal('hide');--}}
{{--                    }--}}
{{--                });--}}
{{--            });--}}


{{--            // edit Link ajax request--}}
{{--            $(document).on('click', '.editIcon', function (e) {--}}
{{--                e.preventDefault();--}}
{{--                let id = $(this).attr('id');--}}
{{--                $.ajax({--}}
{{--                    --}}{{--url: '{{ route('admin.slideredit') }}',--}}
{{--                    method: 'get',--}}
{{--                    data: {--}}
{{--                        id: id,--}}
{{--                        _token: '{{ csrf_token() }}'--}}
{{--                    },--}}
{{--                    success: function (response) {--}}
{{--                        $("#Sliderlink").val(response.link);--}}
{{--                        $("#Sliderposition").val(response.position);--}}
{{--                        $("#avatar").html(--}}
{{--                            `<img src="../storage/images/${response.avatar}" width="100" class="img-fluid img-thumbnail">`);--}}
{{--                        $("#icon_id").val(response.id);--}}
{{--                        $("#icon_avatar").val(response.avatar);--}}
{{--                    }--}}
{{--                });--}}
{{--            });--}}

{{--            // update Link ajax request--}}
{{--            $("#edit_Slider_link_form").submit(function (e) {--}}
{{--                e.preventDefault();--}}
{{--                const fd = new FormData(this);--}}
{{--                $("#edit_Slider_link_btn").text('Updating...');--}}
{{--                $.ajax({--}}
{{--                    --}}{{--url: '{{ route('admin.sliderupdate') }}',--}}
{{--                    method: 'POST',--}}
{{--                    data: fd,--}}
{{--                    cache: false,--}}
{{--                    contentType: false,--}}
{{--                    processData: false,--}}
{{--                    dataType: 'json',--}}
{{--                    success: function (response) {--}}
{{--                        if (response.status == 200) {--}}
{{--                            Swal.fire(--}}
{{--                                'Updated!',--}}
{{--                                'Link Updated Successfully!',--}}
{{--                                'success'--}}
{{--                            )--}}

{{--                            fetchSlierAllLinks();--}}
{{--                        }--}}
{{--                        $("#edit_Slider_link_btn").text('Update Link');--}}
{{--                        $("#edit_Slider_link_form")[0].reset();--}}
{{--                        $("#editSliderLinkModal").modal('hide');--}}
{{--                    }--}}
{{--                });--}}
{{--            });--}}



{{--            function fetchSlierAllLinks() {--}}
{{--                $.ajax({--}}
{{--                    --}}{{--url: '{{ route('admin.sliderfetchAll') }}',--}}
{{--                    method: 'get',--}}
{{--                    success: function (response) {--}}
{{--                        $("#show_all_Slider_links").html(response);--}}
{{--                        $("table").DataTable({--}}
{{--                            order: [0, 'asc']--}}
{{--                        });--}}
{{--                    }--}}
{{--                });--}}
{{--            }--}}
{{--        });--}}

{{--        // Slider Image Crud Ends Here--}}
{{--        /*-----------------------------------------------------------------------------------------------------------------*/--}}
{{--    </script>--}}












































{{--    <div class="page-header">--}}

{{--        <div class="container">--}}
{{--            <div class="page-inner">--}}
{{--                <div class="page-header">--}}
{{--                    <h3 class="fw-bold mb-3">DataTables.Net</h3>--}}
{{--                    <ul class="breadcrumbs mb-3">--}}
{{--                        <li class="nav-home">--}}
{{--                            <a href="#">--}}
{{--                                <i class="icon-home"></i>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="separator">--}}
{{--                            <i class="icon-arrow-right"></i>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="#">Tables</a>--}}
{{--                        </li>--}}
{{--                        <li class="separator">--}}
{{--                            <i class="icon-arrow-right"></i>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="#">Datatables</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--                <div class="row">--}}




{{--                    <div class="col-md-12">--}}
{{--                        <div class="card">--}}
{{--                            <div class="card-header">--}}
{{--                                <div class="d-flex align-items-center">--}}
{{--                                    <h4 class="card-title">Add Row</h4>--}}
{{--                                    <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addRowModal">--}}
{{--                                        <i class="fa fa-plus"></i>--}}
{{--                                        Add Row--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="card-body">--}}
{{--                                <!-- Modal -->--}}
{{--                                <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">--}}
{{--                                    <div class="modal-dialog" role="document">--}}
{{--                                        <div class="modal-content">--}}
{{--                                            <div class="modal-header border-0">--}}
{{--                                                <h5 class="modal-title">--}}
{{--														<span class="fw-mediumbold">--}}
{{--														New</span>--}}
{{--                                                    <span class="fw-light">--}}
{{--															Row--}}
{{--														</span>--}}
{{--                                                </h5>--}}
{{--                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                                    <span aria-hidden="true">&times;</span>--}}
{{--                                                </button>--}}
{{--                                            </div>--}}
{{--                                            <div class="modal-body">--}}
{{--                                                <p class="small">Create a new row using this form, make sure you fill them all</p>--}}
{{--                                                <form>--}}
{{--                                                    <div class="row">--}}
{{--                                                        <div class="col-sm-12">--}}
{{--                                                            <div class="form-group form-group-default">--}}
{{--                                                                <label>Name</label>--}}
{{--                                                                <input id="addName" type="text" class="form-control" placeholder="fill name">--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="col-md-6 pe-0">--}}
{{--                                                            <div class="form-group form-group-default">--}}
{{--                                                                <label>Position</label>--}}
{{--                                                                <input id="addPosition" type="text" class="form-control" placeholder="fill position">--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="col-md-6">--}}
{{--                                                            <div class="form-group form-group-default">--}}
{{--                                                                <label>Office</label>--}}
{{--                                                                <input id="addOffice" type="text" class="form-control" placeholder="fill office">--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </form>--}}
{{--                                            </div>--}}
{{--                                            <div class="modal-footer border-0">--}}
{{--                                                <button type="button" id="addRowButton" class="btn btn-primary">Add</button>--}}
{{--                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="table-responsive">--}}
{{--                                    <table id="add-row" class="display table table-striped table-hover" >--}}
{{--                                        <thead>--}}
{{--                                        <tr>--}}
{{--                                            <th>Name</th>--}}
{{--                                            <th>Position</th>--}}
{{--                                            <th>Office</th>--}}
{{--                                            <th style="width: 10%">Action</th>--}}
{{--                                        </tr>--}}
{{--                                        </thead>--}}
{{--                                        <tfoot>--}}
{{--                                        <tr>--}}
{{--                                            <th>Name</th>--}}
{{--                                            <th>Position</th>--}}
{{--                                            <th>Office</th>--}}
{{--                                            <th>Action</th>--}}
{{--                                        </tr>--}}
{{--                                        </tfoot>--}}
{{--                                        <tbody>--}}
{{--                                        <tr>--}}
{{--                                            <td>Tiger Nixon</td>--}}
{{--                                            <td>System Architect</td>--}}
{{--                                            <td>Edinburgh</td>--}}
{{--                                            <td>--}}
{{--                                                <div class="form-button-action">--}}
{{--                                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">--}}
{{--                                                        <i class="fa fa-edit"></i>--}}
{{--                                                    </button>--}}
{{--                                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">--}}
{{--                                                        <i class="fa fa-times"></i>--}}
{{--                                                    </button>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                        <tr>--}}
{{--                                            <td>Garrett Winters</td>--}}
{{--                                            <td>Accountant</td>--}}
{{--                                            <td>Tokyo</td>--}}
{{--                                            <td>--}}
{{--                                                <div class="form-button-action">--}}
{{--                                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">--}}
{{--                                                        <i class="fa fa-edit"></i>--}}
{{--                                                    </button>--}}
{{--                                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">--}}
{{--                                                        <i class="fa fa-times"></i>--}}
{{--                                                    </button>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                        <tr>--}}
{{--                                            <td>Ashton Cox</td>--}}
{{--                                            <td>Junior Technical Author</td>--}}
{{--                                            <td>San Francisco</td>--}}
{{--                                            <td>--}}
{{--                                                <div class="form-button-action">--}}
{{--                                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">--}}
{{--                                                        <i class="fa fa-edit"></i>--}}
{{--                                                    </button>--}}
{{--                                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">--}}
{{--                                                        <i class="fa fa-times"></i>--}}
{{--                                                    </button>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                        <tr>--}}
{{--                                            <td>Cedric Kelly</td>--}}
{{--                                            <td>Senior Javascript Developer</td>--}}
{{--                                            <td>Edinburgh</td>--}}
{{--                                            <td>--}}
{{--                                                <div class="form-button-action">--}}
{{--                                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">--}}
{{--                                                        <i class="fa fa-edit"></i>--}}
{{--                                                    </button>--}}
{{--                                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">--}}
{{--                                                        <i class="fa fa-times"></i>--}}
{{--                                                    </button>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                        <tr>--}}
{{--                                            <td>Airi Satou</td>--}}
{{--                                            <td>Accountant</td>--}}
{{--                                            <td>Tokyo</td>--}}
{{--                                            <td>--}}
{{--                                                <div class="form-button-action">--}}
{{--                                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">--}}
{{--                                                        <i class="fa fa-edit"></i>--}}
{{--                                                    </button>--}}
{{--                                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">--}}
{{--                                                        <i class="fa fa-times"></i>--}}
{{--                                                    </button>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                        <tr>--}}
{{--                                            <td>Brielle Williamson</td>--}}
{{--                                            <td>Integration Specialist</td>--}}
{{--                                            <td>New York</td>--}}
{{--                                            <td>--}}
{{--                                                <div class="form-button-action">--}}
{{--                                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">--}}
{{--                                                        <i class="fa fa-edit"></i>--}}
{{--                                                    </button>--}}
{{--                                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">--}}
{{--                                                        <i class="fa fa-times"></i>--}}
{{--                                                    </button>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                        <tr>--}}
{{--                                            <td>Herrod Chandler</td>--}}
{{--                                            <td>Sales Assistant</td>--}}
{{--                                            <td>San Francisco</td>--}}
{{--                                            <td>--}}
{{--                                                <div class="form-button-action">--}}
{{--                                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">--}}
{{--                                                        <i class="fa fa-edit"></i>--}}
{{--                                                    </button>--}}
{{--                                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">--}}
{{--                                                        <i class="fa fa-times"></i>--}}
{{--                                                    </button>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                        <tr>--}}
{{--                                            <td>Rhona Davidson</td>--}}
{{--                                            <td>Integration Specialist</td>--}}
{{--                                            <td>Tokyo</td>--}}
{{--                                            <td>--}}
{{--                                                <div class="form-button-action">--}}
{{--                                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">--}}
{{--                                                        <i class="fa fa-edit"></i>--}}
{{--                                                    </button>--}}
{{--                                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">--}}
{{--                                                        <i class="fa fa-times"></i>--}}
{{--                                                    </button>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                        <tr>--}}
{{--                                            <td>Colleen Hurst</td>--}}
{{--                                            <td>Javascript Developer</td>--}}
{{--                                            <td>San Francisco</td>--}}
{{--                                            <td>--}}
{{--                                                <div class="form-button-action">--}}
{{--                                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">--}}
{{--                                                        <i class="fa fa-edit"></i>--}}
{{--                                                    </button>--}}
{{--                                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">--}}
{{--                                                        <i class="fa fa-times"></i>--}}
{{--                                                    </button>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                        <tr>--}}
{{--                                            <td>Sonya Frost</td>--}}
{{--                                            <td>Software Engineer</td>--}}
{{--                                            <td>Edinburgh</td>--}}
{{--                                            <td>--}}
{{--                                                <div class="form-button-action">--}}
{{--                                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">--}}
{{--                                                        <i class="fa fa-edit"></i>--}}
{{--                                                    </button>--}}
{{--                                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">--}}
{{--                                                        <i class="fa fa-times"></i>--}}
{{--                                                    </button>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                        </tbody>--}}
{{--                                    </table>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}



{{--<x-app-layout>--}}
{{--    <x-slot name="header">--}}
{{--        <div class="flex justify-between">--}}
{{--            <h2 class="font-semibold text-xl text-gray-800 leading-tight">--}}
{{--                {{ __('Users') }}--}}
{{--            </h2>--}}
{{--            <a class="bg-slate-700 text-sm rounded-md text-white px-3 py-2" href="{{route('users.create')}}">Create User</a>--}}
{{--        </div>--}}
{{--    </x-slot>--}}

{{--    <div class="py-12">--}}
{{--        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}

{{--            <x-message></x-message>--}}

{{--            <table class="w-full">--}}
{{--                <thead class="bg-gray-50">--}}
{{--                <tr class="border-b">--}}
{{--                    <td class="px-6 py-3 text-left" width="60">#</td>--}}
{{--                    <td class="px-6 py-3 text-left" width="60">Name</td>--}}
{{--                    <td class="px-6 py-3 text-left" width="60">Email</td>--}}
{{--                    <td class="px-6 py-3 text-left" width="60">Roles</td>--}}
{{--                    <td class="px-6 py-3 text-left" width="180" >Created</td>--}}
{{--                    <td class="px-6 py-3 text-center" width="180">Action</td>--}}

{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody class="bg-white">--}}
{{--                @if($users->isNotEmpty())--}}
{{--                    @foreach($users as $user)--}}
{{--                        <tr class="border-b">--}}
{{--                            <td class="px-6 py-3 text-left">{{$user->id}}</td>--}}
{{--                            <td class="px-6 py-3 text-left">{{$user->name}}</td>--}}
{{--                            <td class="px-6 py-3 text-left">{{$user->email}}</td>--}}
{{--                            <td class="px-6 py-3 text-left">{{$user->roles->pluck('name')->implode(', ')}}</td>--}}
{{--                            <td class="px-6 py-3 text-left">--}}
{{--                                --}}{{--And We Can Get Date in our desire format--}}
{{--                                {{\Carbon\Carbon::parse($user->created_at)->format('d M, Y')}}--}}

{{--                            </td>--}}
{{--                            <td class="px-6 py-3 text-center">--}}
{{--                                <a href="{{route('users.edit',$user->id)}}" class="bg-slate-700 hover:bg-slate-500 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-600">Edit</a>--}}

{{--                                <a href="javascript:void(0);" onclick="deleteUser({{$user->id}})" class="bg-red-700 text-sm rounded-md text-white px-3 py-2 hover:bg-red-600">Delete</a>--}}

{{--                            </td>--}}


{{--                        </tr>--}}
{{--                    @endforeach--}}
{{--                @endif--}}

{{--                </tbody>--}}
{{--            </table>--}}
{{--            {{$users->links()}}--}}





{{--        </div>--}}
{{--    </div>--}}



{{--    <x-slot name="script">--}}
{{--        --}}{{--JS Code Come Here--}}
{{--        <script type="text/javascript">--}}
{{--            function deleteUser(id){--}}

{{--                if(confirm("Are you sure you want to delete?")){--}}
{{--                    $.ajax({--}}
{{--                        url:'{{route('users.destroy')}}',--}}
{{--                        type:'delete',--}}
{{--                        data:{id:id},--}}
{{--                        dataType:'json',--}}
{{--                        headers:{--}}
{{--                            'x-csrf-token' : '{{csrf_token()}}'--}}
{{--                        },--}}
{{--                        success:function(response){--}}

{{--                            window.location.href='{{route('users.index')}}';--}}
{{--                        }--}}

{{--                    });--}}
{{--                }--}}
{{--            }--}}

{{--        </script>--}}
{{--    </x-slot>--}}

{{--</x-app-layout>--}}
