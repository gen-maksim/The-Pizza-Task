@extends('layouts.auth')

@section('content')
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Registration
            </h1>
            <h2 class="subtitle">
                So, you are going to join a party!
            </h2>
        </div>
        <div class="columns is-centered mt-5">

            <div id="delivery" class="column card is-half">
                <div class="card-content">
                    <h1 class="title is-4">Fill credentials, please</h1>
                    <form id="register" method="post" action="{{ route('register') }}">
                        @csrf
                        <div class="field">
                            <label class="label">Name</label>
                            <div class="control has-icons-left">
                                <input class="input" name="name" type="text" placeholder="To sign your pizza box" value="{{ old('name') }}" required maxlength="250">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>
                                @error('name')
                                    <p class="has-text-danger has-text-weight-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control has-icons-left">
                                <input class="input" name="email" type="email" placeholder="Email goes here" value="{{ old('email') }}" required maxlength="250">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                @error('email')
                                    <p class="has-text-danger has-text-weight-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Password (min 6 chars)</label>
                            <div class="control has-icons-left">
                                <input class="input" name="password" pattern=".{6,}" type="password" placeholder="Do not tell anybody (except this form)" required maxlength="250">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-key"></i>
                                </span>
                                @error('password')
                                    <p class="has-text-danger has-text-weight-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Confirm Password (repeat it, please)</label>
                            <div class="control has-icons-left">
                                <input class="input" name="password_confirmation" pattern=".{6,}" type="password" placeholder="Type it once more" required maxlength="250">
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
