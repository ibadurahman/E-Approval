@extends('template.default')

@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <form action="{{route('dealerApproveRule.update',$dealerApproveRule)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="">Dealer</label>
                                <select name="dealer_id" id="" class="form-control @error('dealer_id') is-invalid @enderror">
                                    @foreach ($dealers as $dealer)
                                        <option value="{{$dealer->id}}" @if ($dealer->id == $dealerApproveRule->dealer_id)
                                            selected
                                        @endif>{{$dealer->name}}</option>
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
                                    <input name="level_1_min_nominal" type="text" class="form-control @error('level_1_min_nominal') is-invalid @enderror"
                                    value="{{old('level_1_min_nominal')??$dealerApproveRule->level_1_min_nominal}}">
                                    <select name="level_1_position_id" class="form-select @error('level_1_position_id') is-invalid @enderror" id="">
                                        @foreach ($positions as $position)
                                            <option value="{{$position->id}}" @if ($position->id == $dealerApproveRule->level_1_position_id)
                                                selected
                                            @endif>{{$position->name}}</option>
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
                                    <input name="level_2_min_nominal" type="text" class="form-control @error('level_2_min_nominal') is-invalid @enderror"
                                    value="{{old('level_2_min_nominal')??$dealerApproveRule->level_2_min_nominal}}">
                                    <select name="level_2_position_id" class="form-select @error('level_2_position_id') is-invalid @enderror" id="">
                                        @foreach ($positions as $position)
                                            <option value="{{$position->id}}" @if ($position->id == $dealerApproveRule->level_2_position_id)
                                                selected
                                            @endif>{{$position->name}}</option>
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
                                    <input name="level_3_min_nominal" type="text" class="form-control @error('level_3_min_nominal') is-invalid @enderror"
                                    value="{{old('level_3_min_nominal')??$dealerApproveRule->level_3_min_nominal}}">
                                    <select name="level_3_position_id" class="form-select @error('level_3_position_id') is-invalid @enderror" id="">
                                        @foreach ($positions as $position)
                                            <option value="{{$position->id}}" @if ($position->id == $dealerApproveRule->level_3_position_id)
                                                selected
                                            @endif>{{$position->name}}</option>
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