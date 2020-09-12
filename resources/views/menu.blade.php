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
<section id="main">
    <nav class="navbar" role="navigation" aria-label="main navigation" style="background-color: #f4faf7">
        <div class="navbar-brand">
            <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false"
               data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu is-active">
            <div class="navbar-start">
            </div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <p v-text="'You ordered ' + order_count + ' pizzas. Total price: ' + total_price + '$'"></p>
                </div>
                <div class="navbar-item">
                    <a class="button is-light">
                        Log in
                    </a>
                    <a class="button is-light" href="{{ route('cart') }}">
                        Cart
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <section class="hero pizza_back">
        <div class="hero-body">
            <div class="container">
                <h1 class="title" style="color: #e3f1fa">
                    Pizza World
                </h1>
                <p class="subtitle" style="color: #e3f1fa">
                    Pizza for every day. <strong>Try special today!</strong>
                </p>
            </div>
        </div>
        <div class="container is-fluid pb-3">
            <div class="columns is-multiline">
                <div v-for="pizza in pizzas" class="column is-one-quarter-desktop">
                    <div class="card" style="background-color: #f2f2f2">
                        <header class="card-header">
                            <p class="card-header-title is-centered is-1" v-text="pizza.name"></p>
                        </header>
                        <div class="card-image">
                            <figure class="image is-4by3">
                                <img v-bind:src="pizza.pic_url" alt="Placeholder image">
                            </figure>
                        </div>
                        <footer class="card-footer">
                            <button @click="toCart(pizza.id)" class="button is-rounded is-success card-footer-item">
                                Add to cart
                            </button>
                            <p v-text="'today for: ' + pizza.cost + '$'" class="card-footer-item"></p>
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
</section>
</body>

<script src="{{ asset('js/app.js') }}"></script>
<script>

    let main = new Vue({
        el: '#main',
        data: {
            pizzas: {!! json_encode($pizzas) !!},
            cart: {!! json_encode($cart) !!},
        },
        mounted() {
            @if(session('order_succeed'))
            Swal.fire({
                toast: true,
                position: 'top',
                title: 'Thanks, for order!',
                timer: '5000',
                icon: 'success',
                showCloseButton: true,
                showConfirmButton: false,
                timerProgressBar: true
            });
            @endif
        },
        computed: {
            order_count: function () {
                let count = 0;
                this.cart.forEach(item => count += item.count);
                return count;
            },
            total_price: function () {
                let total_price = 0;
                this.cart.forEach(item => {
                    let pizza = this.pizzas.find(pizza => pizza.id === item.pizza_id)
                    total_price += (pizza.cost * item.count);
                });

                return total_price;
            }
        },
        methods: {
            toCart(pizza_id) {
                let ex_order = this.cart.find(item => item.pizza_id === pizza_id);
                if (ex_order) {
                    ex_order.count++;
                } else {
                    this.cart.push({
                        pizza_id: pizza_id,
                        count: 1
                    });
                }
                axios.post('{{ route('cart.addPizza') }}', {
                    pizza_id: pizza_id,
                });
            }
        }
    });
</script>
</html>
