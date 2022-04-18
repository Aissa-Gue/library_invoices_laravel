<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('includes.requirements')

    <title>المكتبة المركزية | برنامج الفواتير</title>
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
</style>

<body class="my_bg">
<div class="login-form-wrap">
    <div class="col-md-7 align-self-end">
        
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
