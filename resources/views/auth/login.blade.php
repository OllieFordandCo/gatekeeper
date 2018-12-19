@extends('uiManager::layouts.app')

@section('content')
<div class="p-relative full-height">
    <div class="content v-align p-relative">
        <div>
            <div class="container-xs mx-auto">
                <div class="grid-row text-center">
                    <div class="col-12">
                        <h1 class="display-3 my-1">{{ config('app.name') }}</h1>
                        <main class="card card-contained my-3">
                            <header class="px-3 py-1">
                                <h5 class="my-1 text-grey-light text-thin">Getting Started</h5>
                            </header>
                            <article class="grid-row text-left">
                                <div class="col-12" style="max-height:calc(100vh - 300px);">
                                    <div class="scroll-content text-center py-3 px-3" data-simplebar>
                                        <h2 class="h5 mb-2">Let's get this show on the road!</h2>
                                        <div class="card-block">
                                            <?php if(!\Schema::hasTable('users')) { ?>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <b>Hoc loco
                                                    tenere se Triarius non potuit.</b> Sed id ne cogitari quidem potest
                                                quale sit, ut non repugnet ipsum sibi. Duo enim genera quae erant, fecit
                                                tria. <i>At eum nihili facit;</i> Vide, ne etiam menses! nisi forte eum
                                                dicis, qui, simul atque arripuit, interficit. Sed quanta sit alias, nunc
                                                tantum possitne esse tanta. Fortitudinis quaedam praecepta sunt ac paene
                                                leges, quae effeminari virum vetant in dolore. Duo Reges: constructio
                                                interrete. </p>

                                            <p>Unum est sine dolore esse, alterum cum voluptate. <a
                                                        href="http://loripsum.net/" target="_blank">Scrupulum, inquam,
                                                    abeunti;</a>
                                                <mark>Itaque fecimus.</mark>
                                                Nec enim, dum metuit, iustus est, et certe, si metuere destiterit, non
                                                erit;
                                            </p>

                                            <p>Quod quidem iam fit etiam in Academia.
                                                <mark>Sed fortuna fortis;</mark>
                                                <mark>Egone quaeris, inquit, quid sentiam?</mark>
                                                <i>Aliter enim explicari, quod quaeritur, non potest.</i> Mihi vero,
                                                inquit, placet agi subtilius et, ut ipse dixisti, pressius. <b>Quid
                                                    censes in Latino fore?</b> Et harum quidem rerum facilis est et
                                                expedita distinctio.
                                            </p>

                                            <a href="./install" class="btn btn-primary my-3">Start installation</a>
                                            <?php } else {

                                                ?>

                                                <a href="{{ route('loginWith', ['provider' => 'facebook']) }}" class="btn btn-facebook mb-2">
                                                    <i class="fab fa-facebook mr-2"></i> {{ __('Login with Facebook') }}
                                                </a>
                                            <form method="POST" action="{{ route('login') }}"
                                                  class="card-block grid-row text-white text-center">
                                                @csrf

                                                <div class="col-12">
                                                    <label for="email" class="sr-only">{{ __('E-Mail Address') }}</label>
                                                    <input id="email" type="email"
                                                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                           name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}" required autofocus>

                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="col-12">
                                                    <label for="password" class="sr-only">{{ __('Password') }}</label>
                                                    <input id="password" type="password"
                                                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                           name="password" placeholder="{{ __('Password') }}" required>

                                                    @if ($errors->has('password'))
                                                        <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('password') }}</strong>
                                                                    </span>
                                                    @endif
                                                </div>


                                                <div class="form-check text-left">
                                                    <input class="form-check-input" type="checkbox" name="remember"
                                                           id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                    <label class="form-check-label" for="remember">
                                                        {{ __('Remember Me') }}
                                                    </label>
                                                </div>


                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Login') }}
                                                </button>

                                                <div class="col-12 text-center">
                                                    <a class="btn btn-link" href="#">
                                                        {{ __('Forgot Your Password?') }}
                                                    </a>
                                                </div>

                                            </form>
                                            </form>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </main>
                    </div>
                    <div class="col-12">
                        <footer>
                            <small class="text-center p-2 d-block">Copyright &copy. Ollie Ford & Co. All
                                rights reserved.
                            </small>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection