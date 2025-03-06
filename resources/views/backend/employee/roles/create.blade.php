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


                        <form action="{{route('roles.store')}}" method="post">
                            @csrf

                            <div class="form-group">
                                <input value="{{old('name')}}" name="name" placeholder="Role Name" type="text"
                                       class="form-control" autocomplete="off"/>
                                @error('name')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>


                            <div class="d-flex flex-wrap gap-4 form-check">
                                @if($permissions->isNotEmpty())
                                    @foreach($permissions as $permission)
                                        <div class="mt-3">
                                            <input type="checkbox" id="permission-{{$permission->id}}"
                                                   class="form-check-input" name="permission[]"
                                                   value="{{$permission->name}}">
                                            <label class="form-check-label"
                                                   for="permission-{{$permission->id}}">{{$permission->name}}</label>
                                        </div>

                                    @endforeach

                                @endif
                            </div>
                            <button class="btn btn-primary float-end m-5 p-3">Submit</button>
                        </form>
                    </div>
                </div>
            </div>


        </div>

    </div>

@endsection


