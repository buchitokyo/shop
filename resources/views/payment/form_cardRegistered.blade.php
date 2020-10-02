<!-- <html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>

        body {

            padding: 15px;

        }

        #new-card, #update-card {

            border: 1px solid #ccc;
            padding: 8px;

        }

    </style>
</head>
<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
<script>

    new Vue({
        el: '#app',
        data: {}
    });
</script>
<body>
<div id="app" class="container">
<div class="content">
<form action="" method="POST">
    {{ csrf_field() }}
    <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key=""
            data-amount="100"
            data-name="Stripe Demo"
            data-label="決済をする"
            data-description="テストです"
            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
            data-locale="auto"
            data-currency="JPY">
    </script>
    data-shippingAddress="true"
    data-zip-code="true"
    data-allow-remember-me="false"
</form> -->

@extends('layouts.stripe')

@section('content')
<div id="app">
    <v-app id="inspire">
        <div class="card-body">
            <v-form action="" class="card-form" id="form_payment" method="POST">
                @csrf
                <!-- <div class="form-group">
                    <div id="card">
                    </div>
                </div> -->

                <div class="form-group">
                    <label for="name">カード番号</label>
                    <div id="cardNumber"></div>
                </div>

                <div class="form-group">
                    <label for="name">セキュリティコード</label>
                    <div id="securityCode"></div>
                </div>

                <div class="form-group">
                    <label for="name">有効期限</label>
                    <div id="expiration"></div>
                </div>

                <div class="form-group">
                    <v-text-field
                        id="cardName"
                        v-model="cardHolderName"
                        placeholder="名義人（半角ローマ字）"
                    ></v-text-field>
                </div>

                <div class="form-group">
                    <v-btn
                        @click="submit()"
                        id="create_token"
                        class="btn btn-primary"
                    >
                    <!-- data-secret="{{ $intent->client_secret }}" -->
                    カード登録
                    </v-btn>
                </div>

                <div v-if="show_result">@{{ result_message }}</div>
            </v-form>
            <a href="">クレジットカード情報ページに戻る</a>
        </div>
    </v-app>
</div>
@endsection

@section('script')
<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdn.jsdelivr.net/npm/babel-standalone@6.26.0/babel.min.js" integrity="sha256-FiZMk1zgTeujzf/+vomWZGZ9r00+xnGvOgXoj0Jo1jA=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/babel-polyfill@6.26.0/dist/polyfill.min.js" integrity="sha256-WRc/eG3R84AverJv0zmqxAmdwQxstUpqkiE+avJ3WSo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script type="text/babel" data-presets="es2015,es2016,es2017">
    new Vue ({
        el: '#app',
        vuetify: new Vuetify(),
        data: () => ({
            card: null,
            cardNumber: null,
            cardHolderName: '',
            stripe: null,
            publicKey: '{{ config('services.stripe.key') }}',
            show_result: false,
            result_message: '',
            cardHolderName: '',
            intentToken: ''
        }),
        methods: {
            submit() {
                // カード登録
                const self = this;
                self.show_result = false;
                this.stripe.createToken(this.card, {name: document.querySelector('#cardName').value}).then(result => {
                    console.log("result: " + JSON.stringify(result));
                    // エラーの場合
                    if (result.error) {
                        self.show_result = true;
                        self.result_message = result.error.message;
                        alert("カード登録処理時にエラーが発生しました。カード番号が正しいものかどうかをご確認いただくか、別のクレジットカードで登録してみてください。");
                      // 成功の場合
                    } else {
                        self.show_result = true;
                        self.result_message = "token_id: " + result.token.id;
                        this.stripeTokenHandler(result.token);
                    }
                });
            },
            stripeTokenHandler(value) {
                const form = document.getElementById('form_payment');
                const hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                form.submit();
            }
        },
        mounted() {
            // Stripe(`${this.publicKey}`)
            this.stripe = Stripe(this.publicKey);
            const elements = this.stripe.elements();
            /* Stripe Elementsを使ったFormの各パーツをどんなデザインにしたいかを定義 */
            const style = {
                base: {
                    fontSize: '12px',
                    color: "#32325d",
                    border: "solid 1px ccc"
                }
            };

            // const card = elements.create('card', {
            //             style:style,
            //             hidePostalCode: true
            //         });
            // card.mount('#card');
            /* フォームでdivタグになっている部分をStripe Elementsを使ってフォームに変換 */
            this.card = elements.create('cardNumber', {style:style});
            this.card.mount('#cardNumber');

            this.card = elements.create('cardCvc', {style:style});
            this.card.mount('#securityCode');

            this.card = elements.create('cardExpiry', {style:style});
            this.card.mount('#expiration');

        },
    });
</script>
@endsection
