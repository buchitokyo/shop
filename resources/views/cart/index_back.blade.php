@extends('layouts.master')
@section('content')
<div id="app">
    <v-app id="inspire">
        <v-container id="wrap_cart">
            <h1>カートの中身</h1>
            <table class="table">
                <tr>
                    <th>商品</th>
                    <th>個数</th>
                    <th>価格</th>
                    <th>小計</th>
                    <th></th>
                </tr>
                <!-- cartsのitems -->
                <tr v-for="(cartItem, rowId) in carts.items">
                    <td>
                        <span v-text="cartItem.name"></span> （サイズ： <span v-text="cartItem.options.size"></span>）
                    </td>
                    <td v-text="cartItem.qty"></td>
                    <td v-text="cartItem.price"></td>
                    <th v-text="cartItem.subtotal"></th>
                    <td class="text-right">
                        <v-btn
                            rounded
                            color="primary"
                            dark
                            @click="removeItem(rowId)"
                        >
                            削除
                        </v-btn>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <th>小計</th>
                    <th v-text="carts.subtotal"></th>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <th>税</th>
                    <th v-text="carts.tax"></th>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <th>合計</th>
                    <th v-text="carts.total"></th>
                </tr>
            </table>
            <div class="text-right">
                <button type="button" class="btn btn-success">お会計へ</button>
            </div>
        </v-container>
    </v-app>
</div>
@endsection
@section('javascript-footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script>
    new Vue({
            vuetify: new Vuetify(),
            el: '#app',
            data: {
                carts: {}
            },
            methods: {
                removeItem: function(rowId) {
                    if(confirm('商品を削除します。よろしいですか？')) {
                        var self = this;
                        var cart = this.carts.items[rowId];
                        var url = '/ajax/carts/'+ cart.id;
                        var params = {
                            row_id: rowId,
                            _method: 'delete'
                        };
                        axios.post(url, params)
                            .then(function(response){
                                self.getCarts();
                            });
                    }
                },
                getCarts: function() {
                    var self = this;
                    axios.get('/ajax/carts')
                        .then(function(response){
                            self.carts = response.data;
                        });
                }
            },
            mounted: function() {
                this.getCarts();
            }
        });
</script>
@endsection
