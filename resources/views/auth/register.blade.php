@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card rounded-0 mt-5">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right"><i class="fas fa-user fa-2x"></i></label>

                            <div class="col-md-6">
                                <input id="name" type="text" placeholder="Name" class="f-input form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right"><i class="fas fa-envelope fa-2x"></i></label>

                            <div class="col-md-6">
                                <input id="email" type="email" placeholder="Email" class="f-input  form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
<!-------------------------------------------------------------------------------->
<div class="form-group row">
    <label for="type" class="col-md-4 col-form-label text-md-right"><i class="fas fa-list-alt fa-2x"></i></label>

    <div class="col-md-6 ">
        <select  id="type"  class="f-input form-control @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}" required>
            <option value="" selected disabled>Select User Type</option>
            <option value="student">Student</option>
            <option value="external">External Examiner</option>
            <option value="supervisor">Supervisor</option>
            <option value="admin">Admin</option>
        </select>

        @error('type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<!-------------------------------------------------------------------------------->
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right"><i class="fas fa-lock fa-2x"></i></label>

                            <div class="col-md-6">
                                <input id="password" placeholder="Password" type="password" class=" f-input  form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right"><i class="fas fa-unlock fa-2x"></i></label>

                            <div class="col-md-6">
                                <input id="password-confirm" placeholder="Confirm Passeord" type="password" class=" f-input  form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 col-sm-8"></div>
                            <div class="col-md-2  col-sm-2">
                                <button type="submit" class="btn  btn-primary rounded-0 px-4 ">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
