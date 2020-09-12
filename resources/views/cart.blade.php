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
<section>
    <nav class="navbar" role="navigation" aria-label="main navigation" style="background-color: #f4faf7">
        <div class="navbar-brand">
            <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu is-active">
            <div class="navbar-start">
            </div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <a class="button is-light">
                        Log in
                    </a>
                    <a class="button is-light" href="{{ route('menu') }}">
                        Menu
                        <i class="fas fa-pizza-slice"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Cart
            </h1>
            <h2 class="subtitle">
                Get your pizza delivered
            </h2>
        </div>
    <div class="columns is-centered mt-5">
        <div id="cart" class="column">
            <div v-if="cart.length < 1">
                <p> First you need to choose any pizza, try or special!</p>
            </div>
            <div v-else>
                <article v-for="item in cart" class="media">
                    <figure class="media-left">
                        <p class="image is-128x128">
                            <img :src="getPizza(item.pizza_id).pic_url">
                        </p>
                    </figure>
                    <div class="media-content">
                        <div class="content">
                            <p>
                                <strong>@{{ getPizza(item.pizza_id).name }}</strong> <small v-text="(getPizza(item.pizza_id).cost * item.count) + '$'"></small>
                                <br>
                                What our clients say: "@{{ getPizza(item.pizza_id).description }}"
                            </p>
                        </div>
                        <nav class="level is-mobile">
                            <div class="level-left">
                                <button class="level-item button is-white has-text-danger-dark" :disabled="item.count <= 1" @click="deletePizza(item.pizza_id)">
                                    <span class="icon is-medium"><i class="fas fa-minus-circle"></i></span>
                                </button>
                                <p class="level-item">
                                    <span class="is-medium" v-text="item.count"></span>
                                </p>
                                <button class="level-item button is-white has-text-success-dark" @click="addPizza(item.pizza_id)">
                                    <span class="icon is-medium"><i class="fas fa-plus-circle"></i></span>
                                </button>
                            </div>
                        </nav>
                    </div>
                    <div class="media-right">
                        <button class="delete" @click="removePizza(item.pizza_id)"></button>
                    </div>
                </article>
                <article class="media">
                <div class="media-content">
                    <p>So, your total price is: <strong>@{{ total_price }}$ (included 10$ deliver)</strong></p>
                </div>
            </article>
            </div>
        </div>
        <div id="delivery" class="column card is-half">
            <div class="card-content">
                <form method="post" action="{{ route('order.store') }}">
                    @csrf
                    <div class="field">
                        <label class="label">Name</label>
                        <div class="control has-icons-left">
                            <input class="input" name="name" v-model="name" type="text" placeholder="To sign you pizza box" required>
                            <span class="icon is-small is-left">
                              <i class="fas fa-user"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Address</label>
                        <div class="control has-icons-left">
                            <input class="input" name="address" v-model="address" placeholder="To tell pizza man where to go" required>
                            <span class="icon is-small is-left">
                              <i class="fas fa-map-marked-alt"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Phone</label>
                        <div class="control has-icons-left">
                            <input class="input" name="phone" v-model="phone" v-mask="'8(###)###-##-##'" pattern="8\([0-9]{3}\)[0-9]{3}-[0-9]{2}-[0-9]{2}" type="tel" placeholder="To clarify some details" required>
                            <span class="icon is-small is-left">
                              <i class="fas fa-phone"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                                <input type="checkbox" name="remember_delivery" v-model="remember_delivery" {{ auth()->user() == false ? 'disabled' : '' }}>
                                Save your data (we will fill it for you next time) <strong>{{ auth()->user() == false ? 'Sorry, this feature is only for logged in users' : '' }}</strong>
                            </label>
                        </div>
                    </div>
                    <div class="control">
                        <button class="button is-link" :disabled="cartIsntEmpty()">Submit</button>
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
</section>
</body>

<script src="{{ asset('js/app.js') }}"></script>
<script>

    let cart = new Vue({
        el: '#cart',
        data: {
            pizzas: {!! json_encode($pizzas) !!},
            cart: {!! json_encode($cart) !!},
        },
        computed: {
            order_count: function () {
                let count = 0;
                this.cart.forEach(item => count += item.count);
                return count;
            },
            total_price: function() {
                let total_price = 10;
                this.cart.forEach(item => {
                    let pizza = this.pizzas.find(pizza => pizza.id === item.pizza_id)
                    total_price += (pizza.cost * item.count);
                });

                return total_price;
            }
        },
        methods: {
            getPizza(pizza_id) {
                return this.pizzas.find(pizza => pizza.id === pizza_id);
            },
            addPizza(pizza_id) {
                let ex_order = this.cart.find(item => item.pizza_id === pizza_id);
                if (ex_order) {
                    ex_order.count++;
                }
                axios.post('{{ route('cart.addPizza') }}', {
                    pizza_id: pizza_id,
                });
            },
            deletePizza(pizza_id) {
                let ex_order = this.cart.find(item => item.pizza_id === pizza_id);
                if (ex_order) {
                    if (ex_order.count > 1) {
                        ex_order.count--;

                        axios.post('{{ route('cart.deletePizza') }}', {
                            pizza_id: pizza_id,
                        });
                    }
                }
            },
            removePizza(pizza_id) {
                this.cart = this.cart.filter(item => item.pizza_id !== pizza_id);
                axios.post('{{ route('cart.removePizza') }}', {
                    pizza_id: pizza_id
                });
            }
        }
    });

    let delivery = new Vue({
        el: '#delivery',
        data: {
            'name': '',
            'address': '',
            'phone': '',
            'remember_delivery': '',
        },
        methods: {
            cartIsntEmpty () {
                return !(cart.cart.length > 0);
            },
        }
    });
</script>
</html>
