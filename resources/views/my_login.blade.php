@extends('layouts.auth')

@section('content')
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Log in
            </h1>
            <h2 class="subtitle">
                It'll save your time!
            </h2>
        </div>
        <div class="columns is-centered mt-5">
            <div id="delivery" class="column card is-half">
                <div class="card-content">
                    <h1 class="title is-4">Fill credentials, please</h1>
                    <h2 class="subtitle is-6">Don't know what to type here? You may want to <a href="{{ route('register') }}">register</a>.</h2>
                    <form method="post" action="{{ route('login') }}">
                        @csrf
                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control has-icons-left">
                                <input class="input" name="email" type="email" placeholder="Email goes here" required>
                                <span class="icon is-small is-left">
                              <i class="fas fa-envelope"></i>
                            </span>
                            </div>
                            @error('login')
                                <p class="has-text-danger has-text-weight-medium">Please, check your email and pass. <a href="{{ route('register') }}">Don't have an account yet?</a></p>
                            @enderror
                        </div>
                        <div class="field">
                            <label class="label">Password</label>
                            <div class="control has-icons-left">
                                <input class="input" name="password" type="password" placeholder="Do not tell anybody (except this form)" required>
                                <span class="icon is-small is-left">
                              <i class="fas fa-key"></i>
                            </span>
                            </div>
                        </div>
                        <div class="control">
                            <button class="button is-link">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="content has-text-centered">
                <p>
                    <strong>Pizza task</strong> by <a href="https://github.com/gen-maksim">Maxim</a>. 2020.
                </p>
            </div>
        </footer>
@endsection
