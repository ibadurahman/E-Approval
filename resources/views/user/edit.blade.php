@extends('template.default')

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <form action="{{ route('user.update',$user) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input name="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Nama"
                                        value="{{ old('name') ?? $user->name }}">
                                    @error('name')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">E-mail</label>
                                    <input name="email" type="text"
                                        class="form-control @error('email') is-invalid @enderror" placeholder="Grade"
                                        value="{{ old('email') ?? $user->email }}">
                                    @error('email')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Phone</label>
                                    <input name="phone" type="text"
                                        class="form-control @error('phone') is-invalid @enderror" placeholder="Phone Number"
                                        value="{{ old('phone') ?? $user->phone }}">
                                    @error('phone')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Tanggung Jawab Dealer</label>
                                    @foreach ($dealers as $dealer)
                                        <div class="form-check">
                                            <input name="dealer[]" class="form-check-input" type="checkbox" value="{{ $dealer->id }}" @foreach ($user_has_dealer as $userHasDealer)
                                                @if ($dealer->id == $userHasDealer->dealer_id)
                                                    checked
                                                @endif
                                            @endforeach>
                                            <label class="form-check-label">({{ $dealer->code }}) {{ $dealer->name }}</label>
                                        </div>
                                    @endforeach
                                    @error('dealer')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Posisi</label>
                                    @foreach ($positions as $position)
                                        <div class="form-check">
                                            <input name="position" class="form-check-input" type="radio"
                                                value="{{ $position->id }}" @if ($position->id == $user_has_position->position_id)
                                                    checked
                                                @endif>
                                            <label class="form-check-label">
                                                {{ $position->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                    @error('position')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="mb-3">
                                        <label class="form-label">Tanda Tangan</label>
                                        <input class="form-control @error('sign') is-invalid @enderror" type="file" name="sign">
                                        <br>
                                        <img src="{{asset('images\sign\\'.$user->sign)}}" alt="" class="img-thumbnail" width="30%">
                                    </div>
                                    @error('sign')
                                        <span class="text-danger help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Status Akun</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_active" value="1" @if ($user->is_active == 1)
                                            checked
                                        @endif>
                                        <label class="form-check-label">
                                            Aktif
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_active" value="0" @if ($user->is_active == 0)
                                        checked
                                    @endif>
                                        <label class="form-check-label">
                                            Tidak Aktif
                                        </label>
                                    </div>
                                    @error('is_active')
                                        <span class="text-danger help-block">{{ $message }}</span>
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
