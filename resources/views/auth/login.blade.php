@extends('layouts.app')

@section('content')
    <v-container fluid fill-height>
        <v-row align="center" justify="center">
            <!-- Login Form Column -->
            <v-col cols="12" sm="12" md="6">

                <img class="my-2" style="max-height:64px; max-width:300px" src="/images/DSWD-DVO-LOGO.png" contain
                    alt="DSWD" />
                <div class="my-2"> 
                    <b>Welcome to DSWD-AICS Onsite Payroll Generation & Encoding App!</b> <br>
                 </div>
                <form method="POST" class="my-2" action="{{ route('login') }}" background="primary">
                    @csrf

                    <div class="row mb-3">
                        <div>
                            <input id="email" type="text" placeholder="Email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">

                        <div>
                            <input id="password" type="password" placeholder="Password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-12">
                            <v-btn color="primary" type="submit" block>
                                {{ __('Login') }}
                            </v-btn>


                        </div>
                    </div>
                </form>
                <div>
                    <!-- <a href="Register">Register</a> -->
                </div>
                <!--<v-card outlined>
                    <v-card-title class="headline text-center">
                       
                    </v-card-title>
                    <v-card-text class="text-center" >
                       
                    </v-card-text>
                </v-card>-->
            </v-col>

            <!-- Image Column class="fill-height" -->
            <v-col cols="12" sm="4" md="6">
                <v-img src="/images/login-bg.png" alt="Login Image" style="max-width:80%;"></v-img>
            </v-col>
        </v-row>
    </v-container>
@endsection
