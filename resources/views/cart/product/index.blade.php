<!-- <html>
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
</head> -->
@extends('layouts.master')
    <div id="app">
        <div class="container">
            <div class="float-right">
                カートの中身： <span class="badge badge-pill badge-light" v-text="Object.keys(cartItems).length"></span> 個
            </div>
            <h1>商品一覧</h1>
            <div class="row">
                <div v-for="(product,index) in products" class="col-sm-4">
                    <div class="card border-info">
                        <div class="card-body">
                            <h5 class="card-title" v-text="product.name"></h5>
                            <p class="card-text">
                                <label>サイズ：</label>
                                <select class="form-control">
                                    <option v-for="size in product.sizes" :value="size" v-text="size"></option>
                                </select>
                            </p>
                            <p class="card-text">
                                <label>個数：</label>
                                <input type="number" class="form-control" min="0" value="0">
                            </p>
                        </div>
                        <div class="card-footer text-right">
                            <button type="button" class="btn btn-info">カートへ入れる</button>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
    <script>

        new Vue({]vuetify: new Vuetify()
            el: '#app',
            data: {
                products: [],
                cartItems: {}
            },
            methods: {
                getProducts: function() {

                    var self = this;
                    axios.get('/ajax/products')
                        .then(function(response){

                            self.products = response.data;

                        });

                }
            },
            mounted: function() {

                this.getProducts();

            }
        });

    </script>
