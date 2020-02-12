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
