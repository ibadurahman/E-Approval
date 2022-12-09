@extends('template.default')

@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <form action="{{route('dealerApproveRule.store')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">Dealer</label>
                                <select name="dealer_id" id="" class="form-control @error('dealer_id') is-invalid @enderror">
                                    @foreach ($dealers as $dealer)
                                        <option value="{{$dealer->id}}">{{$dealer->name}}</option>
                                    @endforeach
                                </select>
                                @error('dealer_id')
                                    <span class="text-danger help-block">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Level 1 Approval</label>
                                <div class="input-group">
                                    <span class="input-group-text">Minimal price</span>
                                    <input name="level_1_min_nominal" type="text" class="form-control @error('level_1_min_nominal') is-invalid @enderror">
                                    <select name="level_1_position_id" class="form-control @error('level_1_position_id') is-invalid @enderror" id="">
                                        @foreach ($positions as $position)
                                            <option value="{{$position->id}}">{{$position->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('level_1_min_nominal') || $errors->has('level_1_position_id'))
                                        <span class="text-danger help-block"></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Level 2 Approval</label>
                                <div class="input-group">
                                    <span class="input-group-text">Minimal price</span>
                                    <input name="level_2_min_nominal" type="text" class="form-control @error('level_2_min_nominal') is-invalid @enderror">
                                    <select name="level_2_position_id" class="form-control @error('level_2_position_id') is-invalid @enderror" id="">
                                        @foreach ($positions as $position)
                                            <option value="{{$position->id}}">{{$position->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('level_2_min_nominal') || $errors->has('level_2_position_id'))
                                        <span class="text-danger help-block"></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Level 3 Approval</label>
                                <div class="input-group">
                                    <span class="input-group-text">Minimal price</span>
                                    <input name="level_3_min_nominal" type="text" class="form-control @error('level_3_min_nominal') is-invalid @enderror">
                                    <select name="level_3_position_id" class="form-control @error('level_3_position_id') is-invalid @enderror" id="">
                                        @foreach ($positions as $position)
                                            <option value="{{$position->id}}">{{$position->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('level_3_min_nominal') || $errors->has('level_3_position_id'))
                                        <span class="text-danger help-block"></span>
                                    @endif
                                </div>
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