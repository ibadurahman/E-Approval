@extends('template.default')

@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <form action="{{route('dealer.store')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">Kode</label>
                                <input name="code" type="text" class="form-control @error('code') is-invalid @enderror" placeholder="Kode Dealer" value="{{old('code')}}">
                                @error('code')
                                    <span class="text-danger help-block">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Kode Dealer" value="{{old('name')}}">
                                @error('name')
                                    <span class="text-danger help-block">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Address</label>
                                <textarea name="address" id="" class="form-control @error('address') is-invalid @enderror" cols="30" rows="10">{{old('address')}}</textarea>
                                @error('name')
                                    <span class="text-danger help-block">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">E-mail</label>
                                <input name="email" type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Grade" value="{{old('email')}}">
                                @error('email')
                                    <span class="text-danger help-block">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Phone</label>
                                <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone Number" value="{{old('phone')}}">
                                @error('phone')
                                    <span class="text-danger help-block">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <input value="Add" type="submit" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection