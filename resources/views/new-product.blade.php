@extends('base')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">

                <h1>Create New Product</h1>

                <br />

                @include('partials.messages')

                <br />

                <form method="POST" id="frmNewProduct">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" id="title" />
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Vendor</label>
                        <input type="text" class="form-control" name="vendor" id="vendor" />
                    </div>

                    <div class="form-group">
                        <label>SKU</label>
                        <input type="text" class="form-control" name="sku" id="sku" />
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <div class="input-group">
                            <span class="input-group-addon">&pound;</span>
                            <input type="text" class="form-control" name="price" id="price" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Weight</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="weight" id="weight" />
                            <span class="input-group-addon">g</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Product Type</label>
                        <input type="text" class="form-control" name="product_type" id="product_type" />
                    </div>

                    <h2>Images</h2>
                    <div class="dropzone" id="imageDropzone"></div>

                    <br />

                    <button type="button" id="btnSaveNewProduct" class="btn btn-primary">Create Product</button>
                </form>

            </div>
        </div>

    </div>

    <br />
@endsection