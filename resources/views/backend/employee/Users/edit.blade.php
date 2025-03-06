@extends('backend.layout.master')

@section('content')
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <span>Update Employee</span>
                                <a class="btn btn-warning float-end" href="{{route('users.index')}}"><i
                                        class="fa fa-angle-left" aria-hidden="true"></i> Back</a>
                            </div>
                        </div>

                        <form action="{{route('users.update',$user->id)}}" method="post">
                            @csrf

                            <div class="form-group">
                                <input value="{{old('name',$user->name)}}" name="name" placeholder="Name" type="text"
                                       class="form-control" autocomplete="off"/>
                                @error('name')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input value="{{old('email',$user->email)}}" name="email" placeholder="Enter email"
                                       type="text"
                                       class="form-control">
                                @error('email')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>


                            <div class="form-check">
                                @if($roles->isNotEmpty())
                                    @foreach($roles as $role)
                                        <div class="mt-3">
                                            <input {{$hasRoles->contains($role->id) ?  'checked' : ''}} type="checkbox"
                                                   id="role-{{$role->id}}" class="form-check-input"
                                                   name="role[]"
                                                   value="{{$role->name}}">
                                            <label class="form-check-label"
                                                   for="role-{{$role->id}}">{{$role->name}}</label>
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



























    {{--<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User/Edit
            </h2>
            <a class="bg-slate-700 text-sm rounded-md text-white px-3 py-2" href="{{route('users.index')}}">Back</a>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('users.update',$user->id)}}" method="post" >
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input value="{{old('name',$user->name)}}" name="name" placeholder="Enter Name" type="text" class="border-grey-300 shadow-sm w-1/2 rounded-lg">
                                @error('name')
                                <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>


                            <div class="my-3">
                                <input value="{{old('email',$user->email)}}" name="email" placeholder="Enter Email" type="text" class="border-grey-300 shadow-sm w-1/2 rounded-lg">
                                @error('email')
                                <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>




                            <div class="grid grid-cols-4 mb-3">
                                @if($roles->isNotEmpty())
                                    @foreach($roles as $role)
                                        <div class="mt-3">

                                            <input {{$hasRoles->contains($role->id) ?  'checked' : ''}} type="checkbox" id="role-{{$role->id}}" class="rounded" name="role[]"
                                                   value="{{$role->name}}">
                                            <label for="role-{{$role->id}}">{{$role->name}}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>




                            <button class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Submit</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>--}}
