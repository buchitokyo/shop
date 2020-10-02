<template>
    <v-app id="inspire">
        <v-container id="wrap_cart">
            <v-form
                id="form"
                method="post"
                action=""
                ref="form"
                >
            <h1>カートの中身</h1>
            <v-simple-table
                dense
            >
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th>商品</th>
                            <th>個数</th>
                            <th>価格</th>
                            <th>小計</th>
                            <th></th>
                        </tr>
                    </thead>
                    <!-- cartsのitems -->
                    <tbody>
                        <tr v-for="(cartItem, rowId) in carts.items">
                            <td>
                                <span v-text="cartItem.name"></span> （サイズ： <span v-text="cartItem.options.size"></span>）
                            </td>
                            <td v-text="cartItem.qty"></td>
                            <td v-text="cartItem.price"></td>
                            <td v-text="cartItem.subtotal"></td>
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
                            <v-text-field
                                v-model="carts.total"
                                name="total"
                                v-show="false"
                            >
                            </v-text-field>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>
                <div class="text-right">
                    <v-btn
                        @click="stripe()"
                        color="success"
                        dark
                        >
                        お会計へ
                    </v-btn>
                </div>

                <input type="hidden" name="_token" :value="csrf">
            </v-form>
        </v-container>
    </v-app>
</template>

<script>
    export default {
        props: {
            // cartcomponent側の値をpropしている
            endpoint: {
                type: String,
            },
            csrf: {
                type: String,
                required: true,
            }
        },
        data: () => ({
            carts: {},
        }),
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
            },
            stripe: function() {
                form.action = this.endpoint;
                form.submit();
            },
        },
        mounted: function() {
            this.getCarts();
        }
    }
</script>
