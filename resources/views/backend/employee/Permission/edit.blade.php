@extends('backend.layout.master')

@section('content')
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <span>Add New Role</span>
                                <a class="btn btn-warning float-end" href="{{route('roles.index')}}"><i
                                        class="fa fa-angle-left" aria-hidden="true"></i> Back</a>
                            </div>
                        </div>


                        <form action="{{route('permissions.update',$permission->id)}}" method="post">
                            @csrf

                            <div class="form-group">
                                <input value="{{old('name',$permission->name)}}" name="name" placeholder="Permission Name" type="text"
                                       class="form-control" autocomplete="off"/>
                                @error('name')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>

                            <button class="btn btn-primary float-end m-5 p-3">Submit</button>
                        </form>
                    </div>
                </div>
            </div>


        </div>

    </div>

@endsection



