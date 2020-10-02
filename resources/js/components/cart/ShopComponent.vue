<template>
    <v-app id="inspire">
        <v-container id="wrap_product">
            <v-row class="float-right">
                    <a v-bind:href="endpoint">カートの中身</a>： <span class="badge badge-pill badge-light" v-text="Object.keys(cartItems).length"></span> 個
            </v-row>
            aaaaaa
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
                    <v-card-text>
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
</template>

<script>
export default {
    data: () => ({
        products: [], // 配列
        cartItems: {}, // オブジェクト
    }),

    props: {
        // shopcomponent側の値をpropしている
        endpoint: {
            type: String,
        },
    },

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
                if(this.$refs.qty[index].value == 0) {
                    return alert('0ではだめ')
                }
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
    }
</script>
