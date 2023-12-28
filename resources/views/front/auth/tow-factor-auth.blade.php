<x-front-layout name="Tow Factor Login">
        <!-- Start Breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Login</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="index.html"><i class="lni lni-home"></i> Home</a></li>
                            <li>Login</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <!-- End Breadcrumbs -->

    <!-- Start Account Login Area -->
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" action="{{route('two-factor.enable')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                <h3>Tow Factors Log in</h3>
                                <p>you can enable/disable 2fa. </p>
                            </div>
                            @if(session('status') == 'two-factor-authentication-enabled')
                            <div class="mb4 font-medium text-sm">
                                please finish configuring two factor authentication below.
                            </div>
                            @endif
                            <div class="button">
                                @if( !$user -> two_factor_secret )
                                    <button class="btn" type="submit">Enable</button>
                                @else
                                    <div class="p-4">
                                    {   !!  Auth::user()-> twoFactorQrCodeSvg() !!}
                                    </div>
                                    <h3>Recovery Codes</h3>
                                    <ul class="mb-3">
                                        @foreach($user->recoveryCodes() as $code)
                                        <li>{{$code}}</li>
                                        @endforeach
                                    </ul>
                                    <br/>
                                    </br>
                                @method('delete')
                                <button class="btn btn-danger" type="submit">disable</button>
                                @endif
                            </div> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Login Area -->

</x-front-layout > 