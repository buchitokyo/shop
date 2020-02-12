@extends('layouts.master')

@section('content')
<div id="app">
    <v-app id="inspire">
        <v-container id="wrap_product">
            <div class="float-right">
                    カートの中身： <span class="badge badge-pill badge-light" v-text="Object.keys(cartItems).length"></span> 個
            </div>
            <!-- Object.keys(cartItems).length ex)["apple","banana"]-->
            <h1>商品一覧</h1>
            <v-row>
                <v-card v-for="(product, index) in products" class="col-sm-4" v-bind:key="index">
                    <v-card-title v-text="product.name"></v-card-title>
                        <v-card-text>
                            <label>サイズ：</label>
                            <!-- refでvueから参照できる -->
                            <!-- <select class="form-control" ref="size">
                                key, indexでも表示できる
                                <option v-for="size in product.sizes" :value="size" v-text="size"></option>
                            </select> -->
                            <v-select
                                solo
                                dense
                                :items="value"
                                :options="sizeOptions"
                            >
                            </v-select>

                        </v-card-text>
                        <v-card-text>
                            <!-- <label>個数：</label>
                            <input type="number" class="form-control" min="0" value="0"> -->
                            <label>数量：</label>
                            <v-text-field
                                ref="size"
                                type="number"
                                min=0
                                max=50
                                value=0
                                solo
                            />
                        </v-card-text style="text-align:right;">

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
<!-- <script src="https://cdn.jsdelivr.net/npm/babel-standalone@6.26.0/babel.min.js" integrity="sha256-FiZMk1zgTeujzf/+vomWZGZ9r00+xnGvOgXoj0Jo1jA=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/babel-polyfill@6.26.0/dist/polyfill.min.js" integrity="sha256-WRc/eG3R84AverJv0zmqxAmdwQxstUpqkiE+avJ3WSo=" crossorigin="anonymous"></script> -->
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
            cartItems: {},
             // オブジェクト
             // value: ['S', 'M', 'L']
             selected: []
        }),
        props: {
            value: String
        },
        methods: {
                getProducts: function() {
                    var self = this;
                    axios.get('/ajax/products')
                        .then(function(response){
                            self.products = response.data;
                            // console.log(self.products);
                        });
                },
                // sizeOptions: function() {
                //     console.log(this.getProducts());
                // }
            },
        // #appへのマウントが実行された後に実行
        mounted: function() {
            this.getProducts();
        },
        computed: {
            sizeOptions() {
                console.log(this.products[0].sizes);
                // return this.products[0].sizes;
                this.products.map(size => console.log((
                    // value = {label:size.id, value: size.sizes}
                    this.value = size.sizes
            )))
                // this.products[0].sizes.map(function (value) {
                //     console.log(value);
                //     return this.value = value;
                // })
            }
        }
    });

</script>
@endsection
