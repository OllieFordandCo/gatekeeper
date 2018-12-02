<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{config('app.name', 'amaranth')}}</title>

    <!-- Stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="{{asset('/vendor/amaranth/assets/css/amaranth-ui.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://unpkg.com/simplebar@latest/dist/simplebar.css"/>
    <script src="https://unpkg.com/simplebar@latest/dist/simplebar.js"></script>
    <style>
        html {
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            -moz-font-smoothing: unset;
            -moz-osx-font-smoothing: grayscale;
            font-smoothing: antialiased;
            -webkit-backface-visibility: hidden;
            -moz-backface-visibility: hidden;
            backface-visibility: hidden;
        }

        html, body {
            background-color: #f4f7f8;
            color: #767676;
            font-weight: 400;
            height: 100%;
            margin: 0;
            overflow-x: hidden;
        }

        .bg-half {
            position: absolute;
            top: -30px;
            left: -30px;
            right: -30px;
            height: 50%;
            z-index: 0;
            background-color: #c30d40;
            box-shadow: inset 0 0 30px rgba(0, 0, 0, 0.2);
        }

        .full-height {
            height: 100%;
        }

        .title {
            color: #333333 !important;
            -webkit-background-clip: text;
            background-repeat: no-repeat;
            background-size: 100%;
            letter-spacing: -0.17rem;
            line-height: 1em;
            font-weight: 500;
        }

        .card {
            background-color: #fff;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 7px;
        }

        .card.card-dark {
            background: rgb(34, 34, 34); /* Old browsers */
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 15px;
        }

        .card.card-contained {
            overflow: hidden;
        }

        .card > header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        p {
            font-weight: 400;
        }

        .card-sidebar {
            background-color: rgba(255, 255, 255, 0.03);
        }

        .card-sidebar .btn {
            background-color: transparent;
            transition: all 300ms linear;
        }

        .card-sidebar .btn:hover, .card-sidebar .active .btn {
            background-color: rgba(0, 0, 0, 0.1);
        }

        .orb {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: #fff;
            display: inline-block;
        }

        .scroll-content {
            width: 100% !important;
        }
    </style>
</head>
<body class="bg-primary">
<div class="bg-half"></div>
<div class="p-relative full-height">
    <div class="content v-align p-relative">
        <div>
            <div class="container-xs mx-auto">
                <div class="grid-row text-center">
                    <div class="col-12">
                        <h1 class="text-white display-3 my-1">{{ config('app.name') }}</h1>
                        <main class="card card-dark card-contained my-3">
                            <header class="px-3 py-1">
                                <h5 class="my-1 text-grey-light text-thin">Getting Started</h5>
                            </header>
                            <article class="grid-row text-left">
                                <div class="col-12" style="max-height:calc(100vh - 300px);">
                                    <div class="scroll-content text-center py-3 px-3" data-simplebar>
                                        <h2 class="h5 text-white mb-2">Let's get this show on the road!</h2>
                                        <div class="card-block text-white">
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
                                            <?php } else { ?>
                                            <form method="POST" action="{{ route('login') }}"
                                                  class="card-block grid-row text-white text-center">
                                                @csrf

                                                <div class="col-12">
                                                    <label for="email">{{ __('E-Mail Address') }}</label>
                                                    <input id="email" type="email"
                                                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                           name="email" value="{{ old('email') }}" required autofocus>

                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('email') }}</strong>
                                                                    </span>
                                                    @endif
                                                </div>

                                                <div class="col-12">
                                                    <label for="password">{{ __('Password') }}</label>
                                                    <input id="password" type="password"
                                                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                           name="password" required>

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
                            <small class="text-white text-center p-2 d-block">Copyright &copy. Ollie Ford & Co. All
                                rights reserved.
                            </small>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>