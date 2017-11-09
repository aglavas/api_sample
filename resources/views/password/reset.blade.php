<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Reset password</title>
</head>

<body>
<div class="container">
    {!! Form::open(['route' => ['reset.password', $token]]) !!}
    {{ csrf_field() }}
    {!! Form::hidden('token', $token) !!}
    {!! Form::hidden('email', $email) !!}
    {!! Form::label('password', 'Password:') !!}
    {!! Form::password('password') !!}
    {!! Form::label('password_confirmation', 'Password confirmation:') !!}
    {!! Form::password('password_confirmation') !!}
    {!! Form::submit('Submit') !!}
    {!! Form::close() !!}
</div>
</body>
</html>
