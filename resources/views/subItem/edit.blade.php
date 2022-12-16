@extends('template.default')

@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <form action="{{route('subItem.update',$subItem)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="">Item</label>
                                <select name="item_id" id="" class="form-control @error('item_id') is-invalid @enderror">
                                    @foreach ($items as $item)
                                        <option value="{{$item->id}}" @if ($item->id == $subItem->item_id)
                                            selected
                                        @endif>{{$item->name}}</option>
                                    @endforeach
                                </select>
                                @error('item_id')
                                    <span class="text-danger help-block">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Nama Sub Item</label>
                                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Sub Item" value="{{old('name')??$subItem->name}}">
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