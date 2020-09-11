<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Pizza app</title>

        <!-- Fonts -->
        <script src="https://kit.fontawesome.com/92abca6220.js" crossorigin="anonymous"></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
            .pizza_back {
                background-image: url('pics/pizza_back.jpg');
                background-size: contain;
            }
            .footer {
                padding: 1rem;
            }
        </style>
    </head>
    <body>
    <nav class="navbar" role="navigation" aria-label="main navigation" style="background-color: #f4faf7">
        <div class="navbar-brand">
            <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
            </div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <a class="button is-primary">
                        <strong>Sign up</strong>
                    </a>
                    <a class="button is-light">
                        Log in
                    </a>
                    <a class="button is-light">
                        Cart
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <section class="hero pizza_back">
        <div class="hero-body">
            <div class="container">
                <h1 class="title" style="color: #e3f1fa">
                    Hello World
                </h1>
                <p class="subtitle" style="color: #e3f1fa">
                    My first website with <strong>Bulma</strong>!
                </p>
            </div>
        </div>
        <div id="tiles" class="container is-fluid pb-3">
            <div class="columns is-multiline">
                <div v-for="pizza in pizzas" class="column is-one-quarter">
                    <div class="card" style="background-color: #f2f2f2">
                        <div class="card-content">
                            <p class="title" v-text="pizza.name"></p>
                        </div>
                        <div class="card-image">
                            <figure class="image is-4by3">
                                <img v-bind:src="pizza.pic_url" alt="Placeholder image">
                            </figure>
                        </div>
                        <footer class="card-footer">
                            <a href="#" class="card-footer-item">Save</a>
                            <a href="#" class="card-footer-item">Edit</a>
                            <a href="#" class="card-footer-item">Delete</a>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer">
        <div class="content has-text-centered">
            <p>
                <strong>Pizza task</strong> by <a href="https://github.com/gen-maksim">Maxim</a>. 2020.
            </p>
        </div>
    </footer>
    </body>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        let main = new Vue({
            el: '#tiles',
            data: {
                pizzas: {!! json_encode($pizzas) !!}
            }
        });
    </script>
</html>
