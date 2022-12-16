@extends('template.default')

@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <form action="{{route('item.update',$item)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Item" value="{{old('name')??$item->name}}">
                                @error('name')
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