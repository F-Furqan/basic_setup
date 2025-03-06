

@extends('backend.layout.master')

@section('content')
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <span>Add New Permission</span>
                                <a class="btn btn-warning float-end" href="{{route('permissions.index')}}"><i
                                        class="fa fa-angle-left" aria-hidden="true"></i> Back</a>
                            </div>
                        </div>


                        <form action="{{route('permissions.store')}}" method="post">
                            @csrf

                            <div class="form-group">
                                <input value="{{old('name')}}" name="name" placeholder="Permission Name" type="text"
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
















