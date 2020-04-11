@extends('layouts.master')

@section('content')
<div id="app">
    <v-app id="inspire">
        <v-container id="wrap_product">
            <div class="float-right">
                    <a href="{{ route('carts.cart.index') }}">カートの中身</a>： <span class="badge badge-pill badge-light" v-text="Object.keys(cartItems).length"></span> 個
            </div>
            <!-- Object.keys(cartItems).length ex)["apple","banana"]-->
            <h1>商品一覧</h1>
            <v-row>
                <v-card v-for="(product, index) in products" class="col-sm-4" v-bind:key="index">
                    <v-card-title v-text="product.name"></v-card-title>
                    <v-card-text>
                        <label>サイズ：</label>
                        <!-- refでvueから参照できる -->
                        <select ref="size" class="form-control">
                            <!-- key, indexでも表示できる -->
                            <option v-for="size in product.sizes" :value="size" v-text="size"></option>
                        </select>
                    </v-card-text>
                    <v-card-text style="text-align:right;">
                        <label>個数：</label>
                        <input ref="qty" type="number" class="form-control" min="0" value="0">
                    </v-card-text>
                    <v-card-actions>
                        <!-- indexで何番目の商品かがわかる -->
                        <v-btn
                            rounded
                            color="primary"
                            dark
                            @click="addCart(index)"
                        >
                            カートへ入れる
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-row>
        </v-container>
    </v-app>
</div>
@endsection

@section('javascript-footer')
<!-- vue呼び込む -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script>
    new Vue({
        vuetify: new Vuetify(),
        el: '#app',
        data: () => ({
            products: [], // 配列
            cartItems: {}, // オブジェクト
        }),
        methods: {
                getProducts: function() {
                    var self = this;
                    axios.get('/ajax/products')
                        .then(function(response) {
                        self.products = response.data;
                    });
                },
                // productsの各index
                addCart: function(index) {
                    if(confirm('カートへ追加します。よろしいですか？')) {
                        // refでhtmlが参照できる。
                        // size[index]で該当するhtmlを参照。
                        // valueで該当するサイズ取得。
                        // console.log(this.$refs.size[index].value);
                        var self = this;
                        var size = this.$refs.size[index].value;
                        var qty = this.$refs.qty[index].value;
                        var product = this.products[index];

                        var url = '/ajax/carts';
                        var params = {
                            size: size,
                            qty: qty,
                            productId: product.id
                        };

                        axios.post(url, params)
                            .then(function(response){
                            self.cartItems = response.data;
                            // console.log(self.cartItems);
                        });

                    }

                },
                getCarts: function() {
                    var self = this;
                    axios.get('/ajax/carts')
                        .then(function(response){
                        self.cartItems = response.data.items;
                    });
                },
            },
        // #appへのマウントが実行された後に実行
        mounted: function() {
            this.getProducts();
            this.getCarts();
        }
    });
</script>
@endsection
