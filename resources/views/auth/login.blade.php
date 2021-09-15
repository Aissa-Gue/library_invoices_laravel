<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('includes.requirements')

    <title>برنامج الفواتير</title>
</head>
<style>
    .login-form-wrap {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 1000px;
        height: 550px;
        margin: 0 auto;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0px 0px 47px 0px rgba(0, 0, 0, 0.47);
        margin-top: 45px;
        background: #fff;

        background-image: url(img/cover.gif);
        background-size: contain;
        background-repeat: no-repeat;
        object-fit: cover;
    }

    .title {
        text-align: center;
        margin-top: 80px;
        color: #292929;
        line-height: 30px;
        margin-bottom: 30px;
    }


    .form input[type=text],
    .form input[type=password] {
        width: 300px;
        padding: 12px 9px;
        border-radius: 30px;
        border: 1px solid #ddd;
        margin-bottom: 15px;
        outline: none;
        box-shadow: 0px 0px 42px #d4d4d4;
    }

    .form input[type="submit"] {
        display: inline-block;
        border: none;
        width: 170px;
        padding: 10px;
        border-radius: 30px;
        cursor: pointer;
        margin: 20px 0px;
        transition: 0.3s all ease-in-out;
    }

    .form input[type="submit"]:focus {
        outline: none;
    }

    .form input[type="submit"]:hover {
        background: #111;
    }

    .my_logo {
        position: relative;
        transform: scale(0.33);
        bottom: -68px;
        right: -195px;
    }
</style>

<body class="my_bg">
<div class="login-form-wrap">
    <div class="col-md-7 align-self-end">
        <div class="my_logo">
            <a href="" data-bs-toggle="modal" data-bs-target="#info">
                <img src="{{asset('img/aissaGue.png')}}" alt="Developped By Aissa.Gue">
            </a>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="info" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">برنامج الفواتير</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-end">
                        <p><span class="fw-bold">Developped By: </span> Aissa Guellil</p>
                        <p><span class="fw-bold">Phone: </span> +213554005029</p>
                        <p><span class="fw-bold">Email: </span> AissaStarDz@gmail.com</p>
                        <p class="text-left"><span>- </span>September 2021<span> -</span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="title mb-5">
            <h1>مرحبا !</h1>
        </div>
        <div class="form text-center">
            <form action="{{ route('login') }}" method="post">
                @csrf
                <input type="text" class="@error('username') is-invalid @enderror" name="username" placeholder="أدخل اسم المستخدم">
                <input type="password" class="@error('password') is-invalid @enderror" name="password" placeholder="أدخل كلمة المرور">
                @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <input type="submit" name="login" class="btn btn-primary" value="تسجيل الدخول">
            </form>
        </div>
    </div>
</div>

</body>

</html>
