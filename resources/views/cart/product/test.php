<v-container>
    <div class="float-right">
            カートの中身： <span class="badge badge-pill badge-light" v-text=""></span> 個
    </div>
    <h1>商品一覧</h1>
    <v-row>
        <div v-for="(product,index) in products" class="col-sm-4">
                <div class="card border-info">
                    <div class="card-body">
                        <h5 class="card-title" v-text="product.name"></h5>
                        <!-- product.name -->
                        <p class="card-text">
                            <label>サイズ：</label>
                            <v-select class="form-control">
                                <option v-for="size in products.sizes" value="size" v-text="size"></option>
                            </v-select>
                        </p>
                        <p class="card-text">
                            <label>個数：</label>
                            <v-input type="number" class="form-control" min="0" value="0">
                        </p>
                    </div>
                    <div class="card-footer text-right">
                        <v-btn type="button" color="primary">カートへ入れる
                        </v-btn>
                    </div>
                </div>
                <br>
        </div>
    </v-row>
</v-container>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    window.app = new Vue()
});

var app = new Vue({
el: '#app',
data: {
},
// methods: {
//     getProducts: function() {
//
//         var self = this;
//         axios.get('/ajax/products')
//             .then(function(response){
//
//                 self.products = response.data;
//
//             });
//
//     }
// },
// mounted: function() {
//
//     this.getProducts();
//
// }
});
</script>
