@extends('template.default')

@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <form action="{{route('dealerApproveOrganization.update',$dealerApproveOrg)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="">Dealer</label>
                                <select name="dealer_id" id="dealer-id" class="form-select @error('dealer_id') is-invalid @enderror">
                                    @foreach ($dealers as $dealer)
                                        <option value="{{$dealer->id}}" @if ($dealer->id == $dealerApproveOrg->dealer_id)
                                            selected
                                        @endif>{{$dealer->name}}</option>
                                    @endforeach
                                </select>
                                <div id="error-not-found">
                                    @error('dealer_id')
                                        <span class="text-danger help-block">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Level 1 Approval</label>
                                <div class="input-group">
                                    <span class="input-group-text">Approval Position</span>
                                    <select name="level_1_approval" id="level-1-approval" class="form-select @error('level_1_approval') is-invalid @enderror"></select>
                                    <span class="input-group-text">PIC</span>
                                    <select name="level_1_user_id" class="form-select @error('level_1_user_id') is-invalid @enderror" id="level-1-user-id"></select>
                                    @if ($errors->has('level_1_approval') || $errors->has('level_1_user_id'))
                                        <span class="text-danger help-block"></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Level 2 Approval</label>
                                <div class="input-group">
                                    <span class="input-group-text">Approval Position</span>
                                    <select name="level_2_approval" id="level-2-approval" class="form-select @error('level_2_approval') is-invalid @enderror"></select>
                                    <span class="input-group-text">PIC</span>
                                    <select name="level_2_user_id" class="form-select @error('level_2_user_id') is-invalid @enderror" id="level-2-user-id"></select>
                                    @if ($errors->has('level_2_approval') || $errors->has('level_2_user_id'))
                                        <span class="text-danger help-block"></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Level 3 Approval</label>
                                <div class="input-group">
                                    <span class="input-group-text">Approval Position</span>
                                    <select name="level_3_approval" id="level-3-approval" class="form-select @error('level_3_approval') is-invalid @enderror"></select>
                                    <span class="input-group-text">PIC</span>
                                    <select name="level_3_user_id" class="form-select @error('level_3_user_id') is-invalid @enderror" id="level-3-user-id"></select>
                                    @if ($errors->has('level_3_approval') || $errors->has('level_3_user_id'))
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
@push('scripts')
    <script>
        $(function(){
            const level1Approval = $('#level-1-approval')
            const level1UserId  = $('#level-1-user-id')
            const level2Approval = $('#level-2-approval')
            const level2UserId  = $('#level-2-user-id')
            const level3Approval = $('#level-3-approval')
            const level3UserId  = $('#level-3-user-id')
            
            $('#dealer-id').on('change',function(){
                const dealerCombobox = $('#dealer-id').val()

                $.ajax({
                    url:'/dealerApproveOrganization/getPosition',
                    type:'POST',
                    data:{
                        dealer_id:dealerCombobox,
                        _token:'{{csrf_token()}}'
                    },
                    success:function(response){
                        level1Approval.html('<option value="'+response.level_1_position_id.id+'">'+response.level_1_position_id.name+'</option>')
                        level2Approval.html('<option value="'+response.level_2_position_id.id+'">'+response.level_2_position_id.name+'</option>')
                        level3Approval.html('<option value="'+response.level_3_position_id.id+'">'+response.level_3_position_id.name+'</option>')

                        $.ajax({
                            url:'/dealerApproveOrganization/getPersonCharge',
                            type:'POST',
                            data:{
                                dealer_id:dealerCombobox,
                                level_1_position_id:level1Approval.val(),
                                level_2_position_id:level2Approval.val(),
                                level_3_position_id:level3Approval.val(),
                                _token:'{{csrf_token()}}'
                            },
                            success:function(response){
                                level1UserList = []
                                response.level1.forEach(res => {
                                    level1UserList.push('<option value="'+res.id+'" >'+res.name+'</option>')
                                })
                                level2UserList = []
                                response.level2.forEach(res => {
                                    level2UserList.push('<option value="'+res.id+'" >'+res.name+'</option>')
                                })
                                level3UserList = []
                                response.level3.forEach(res => {
                                    level3UserList.push('<option value="'+res.id+'" >'+res.name+'</option>')
                                })
                                level1UserId.html(level1UserList)
                                level2UserId.html(level2UserList)
                                level3UserId.html(level3UserList)
                            }
                        })

                        $('#error-not-found').html('')
                    },
                    error:function(response){
                        level1Approval.html('')
                        level2Approval.html('')
                        level3Approval.html('')
                        level1UserId.html('')
                        level2UserId.html('')
                        level3UserId.html('')
                        $('#error-not-found').html('<span class="text-danger help-block">Dealer Approve Rule Not Found</span>')
                    }
                })
            })
            $('#dealer-id').trigger('change')
        })

    </script>
@endpush