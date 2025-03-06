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

    <div class="container-fluid">
        <div class="row my-5">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <h3 class="text-light">Manage Permission</h3>
                        {{-- <button class="btn btn-light" data-bs-toggle="modal"
                                 data-bs-target="#addSliderLinkModal"><i class="bi-plus-circle me-2"></i>Add New Employee</button>--}}

                        <a href="{{route('permissions.create')}}" class="btn btn-light"><i class="bi-plus-circle me-2"></i>Add New Permissions</a>
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
                            url: '{{ route('permissions.destroy') }}',
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



            function fetchSlierAllLinks() {
                $.ajax({
                    url: '{{ route('permissions.view') }}',
                    method: 'get',
                    success: function (response) {
                        $("#show_all_Employee_links").html(response);
                        $("table").DataTable({
                            order: [0, 'asc']
                        });
                    }
                });
            }
            // fetch all links ajax request
            fetchSlierAllLinks();
        });
    </script>
@endsection




{{--
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permissions') }}
            </h2>
            <a class="bg-slate-700 text-sm rounded-md text-white px-3 py-2" href="{{route('permissions.create')}}">Create Permission</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-message></x-message>

            <table class="w-full">
                <thead class="bg-gray-50">
                <tr class="border-b">
                    <td class="px-6 py-3 text-left" width="60">#</td>
                    <td class="px-6 py-3 text-left">Name</td>
                    <td class="px-6 py-3 text-left" width="180" >Created</td>
                    <td class="px-6 py-3 text-center" width="180">Action</td>

                </tr>
                </thead>
                <tbody class="bg-white">
                @if($permissions->isNotEmpty())
                    @foreach($permissions as $permission)
                        <tr class="border-b">
                            <td class="px-6 py-3 text-left">{{$permission->id}}</td>
                            <td class="px-6 py-3 text-left">{{$permission->name}}</td>
                            <td class="px-6 py-3 text-left">
                                --}}
{{--{{$permission->created_at}}--}}{{--

                                --}}
{{--And We Can Get Date in our desire format--}}{{--

                                {{\Carbon\Carbon::parse($permission->created_at)->format('d M, Y')}}

                            </td>
                            <td class="px-6 py-3 text-center">
                                <a href="{{route('permissions.edit',$permission->id)}}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-600">Edit</a>
                                <a href="javascript:void(0);" onclick="deletePerission({{$permission->id}})" class="bg-red-700 text-sm rounded-md text-white px-3 py-2 hover:bg-red-600">Delete</a>
                            </td>


                        </tr>
                    @endforeach
                @endif

                </tbody>
            </table>
            {{$permissions->links()}}





        </div>
    </div>



    <x-slot name="script">
        --}}
{{--JS Code Come Here--}}{{--

        <script type="text/javascript">
            function deletePerission(id){

                if(confirm("Are you sure you want to delete?")){
                    $.ajax({
                        url:'{{route('permissions.destroy')}}',
                        type:'delete',
                        data:{id:id},
                        dataType:'json',
                        headers:{
                            'x-csrf-token' : '{{csrf_token()}}'
                        },
                        success:function(response){

                            window.location.href='{{route('permissions.index')}}';
                        }

                    });
                }
            }

        </script>
    </x-slot>

</x-app-layout>
--}}
