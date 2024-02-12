<x-layout>
    @section('title', 'Login')
    <style>
        main {
            background: url("{{asset('assets/img/bg.png')}}");
            background-size: contain;
            background-position: right;
            background-repeat: no-repeat;
        }
        .logo img {
            max-height: 46px;
            margin-right: 6px;
        }
    </style>
    <main>
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-center py-4">
                                    <a href="#" class="logo d-flex align-items-center w-auto">
                                        <img src="{{asset('assets/img/logo.png')}}" alt="" class="img-fluid">
                                        <span class="d-none d-lg-block"><img src="{{('assets/img/logo-text.png')}}" alt="" class="img-fluid"></span>
                                    </a>
                                </div>
                                <form method="POST" action="{{ route('login') }}" class="row g-3 needs-validation" novalidate>
                                    @csrf
                                    <div class="col-12">
                                        <label for="email" class="form-label">Username</label>
                                        <div class="input-group has-validation">
                                            {{-- <span class="input-group-text" id="inputGroupPrepend">@</span> --}}
                                            <input id="email" type="text"
                                            class="form-control @error('username') is-invalid @enderror" name="username"
                                            value="{{ old('username') }}" required autofocus>
                                            @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="password" class="form-label">Password</label>
                                            <div class="input-group has-validation">
                                            <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" value="true"
                                                id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Remember me</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Login</button>
                                    </div>
                                    {{-- <div class="col-12">
                                        <p class="small mb-0">Don't have account? <a href="pages-register.html">Create
                                                an account</a></p>
                                    </div> --}}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    </div>
    </main>
</x-layout>
