<x-front-layout name="2fa challenge">
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
                            <li>2fa challenge</li>
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
                    <form class="card login-form" action="{{route('two-factor.login')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                @if($errors->has('code'))
                                 <div class="alert alert-danger">Errors :
                                    {{ $errors->first('code') }}
                                 </div>
                                @endif
                                <h3>2fa challenge</h3>
                                <p>You must enter 2fa code.</p>
                            </div>

                            <div class="form-group input-group">
                                <label for="reg-fn">2FA Code</label>
                                <input class="form-control" type="text" name="code" id="reg-code" >
                            </div>
                            <div class="form-group input-group">
                                <label for="reg-fn">Recovery Code</label>
                                <input class="form-control" type="text" name="recovery_code" id="reg-recovery-code">
                            </div>
                            
                            <div class="button">
                                <button class="btn" type="submit">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Login Area -->

</x-front-layout >