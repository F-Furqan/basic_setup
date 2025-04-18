@extends('backend.layout.master')

@section('content')
<style>
    .folder-box {
        cursor: pointer;
        transition: transform 0.2s;
    }
    .folder-box:hover {
        transform: scale(1.05);
        color: orange;
    }
    .delete-folder {
        z-index: 10;
    }
</style>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#create_folder">Create
                    Folder</a>

            </div>
        </div>

    </div>


    {{--Fetch Data Start From Here--}}

    <div class="container-fluid">
        <div class="row my-5">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <h3 class="text-light">Manage Folders</h3>

                    </div>
                    <div class="card-body" id="show_all_folders">
                        <h1 class="text-center text-secondary my-5">Loading...</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--Fetch Data Ends Here--}}


    {{--Create Folder Model--}}
    <div class="modal fade" id="create_folder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create Folder</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addFolder">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Folder Name" name="name" id="name">
                            <span id="name_error" class="text-danger"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <script>


        $(document).ready(function () {

            // Store Record
            $('#addFolder').submit(function (e) {
                e.preventDefault();

                $('#create_folder').modal('hide');
                // Send data using AJAX POST
                $.ajax({
                    url: '{{ route("folder.store") }}',
                    method: 'POST',
                    data: $(this).serialize(), // Automatically serialize the form data
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

                    success: function (response) {
                        if (response.status == true) {
                            Swal.fire('Success', response.message, 'success');
                            // Reset form data
                            let gallery_form=document.getElementById('addFolder');
                            gallery_form.reset();

                            fetchSlierAllLinks(); // Call it when the page loads
                        }
                    },
                    error: function (response) {

                        if(response.status == 404)
                        {
                            const parsedResponse = JSON.parse(response.responseText);
                            // console.log(response.data.name[0]);
                            $('#create_folder').modal('toggle');
                            document.getElementById('name_error').innerText = parsedResponse.data.name;
                            document.getElementById('name_error').innerText = parsedResponse.data.unique;
                        }
                        else if(response.status == 500){

                            Swal.fire('Error','Error', 'Something went wrong please try again');
                        }

                      //  let errors = response.responseJSON.errors;

                    }
                });
            });

        });



        /*Delete Folder*/
        $(document).on('click', '.delete-folder', function () {
            const folderId = $(this).data('id');
            const confirmed = confirm('Are you sure you want to delete this folder?');

            if (confirmed) {
                $.ajax({
                    url: 'folder/' + folderId, // Adjust to your actual route
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}' // Important for Laravel!
                    },
                    success: function (response) {
                        Swal.fire('Success', response.message, 'success');
                        fetchSlierAllLinks(); // Refresh the folder list
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",

                        });
                    }
                });
            }
        });

        function fetchSlierAllLinks() {
            $.ajax({
                url: '{{ route('folder.fetch') }}', // Make sure this route returns the controller's show()
                method: 'get',
                success: function (response) {
                    $("#show_all_folders").html(response);
                }
            });
        }

        fetchSlierAllLinks(); // Call it when the page loads
    </script>
@endsection
