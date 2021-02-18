@csrf
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="client_id">Client Name</label>
            <select name="client_id" id="client_id" class="form-control">
                @foreach ($clients as $client)
                    <option value=" {{ $client->id }} " {{ old('client_id') == $client->id ? 'selected' : '' }}>
                        {{ $client->name }} </option>
                @endforeach
            </select>

            @if ($errors->first('name'))
                <span class="text-danger ">
                    {{ $errors->first('name') }}
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="client_id">Order Date</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }} ">
            @if ($errors->first('date'))
                <span class="text-danger ">
                    {{ $errors->first('date') }}
                </span>
            @endif
        </div>
    </div>
</div>

<div class="row">

    <div class="col">

        <h3>Products
            @if ($errors->first('products'))
                <span class="text-danger ">
                    {{ $errors->first('products') }}
                </span>
            @endif


        </h3>
        <button type="button" class="btn btn-info" id="btn-add-new-product">Add Product</button>
    </div>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="products-list">
            @if (old('products'))
                @foreach (old('products') as $rowId => $rowProduct)
                    <tr id="product-{{ $rowId }}">
                        <td>
                            <select name="products[{{ $rowId }}][product_id]"
                                class="form-control input-product-product_id" row-id="product-{{ $rowId }}">
                                @foreach ($products as $product)
                                    @if ($product->id == $rowProduct['product_id'])
                                    
                                    <option value="{{ $product->id }}" selected data-price="{{ $product->price }}">
                                        {{ $product->name }} | {{ $product->price }} </option>
                                    @else

                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                            {{ $product->name }} | {{ $product->price }} </option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->first('products.' . $rowId . '.product_id'))
                                <span class="text-danger ">
                                    {{ $errors->first('products.' . $rowId . '.product_id') }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <input type="number"
                             name="products[{{ $rowId }}][quantity]"
                             value="{{ $rowProduct['quantity'] ?? 1 }}"
                             class="form-control input-product-quantity"
                            row-id="product-{{ $rowId }}">

                            @if ($errors->first('products.' . $rowId . '.quantity'))
                                <span class="text-danger ">
                                    {{ $errors->first('products.' . $rowId . '.quantity') }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <input type="number" 
                            name="products[{{ $rowId }}][price]"
                            class="form-control input-product-price" 
                            row-id="product-{{ $rowId }}"
                            value="{{ $rowProduct['price'] ?? 1 }}" readonly>

                            @if ($errors->first('products.' . $rowId . '.price'))
                                <span class="text-danger ">
                                    {{ $errors->first('products.' . $rowId . '.price') }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <input type="number" 
                            name="products[{{ $rowId }}][total]"
                            value="{{ $rowProduct['total'] == 0 ? $rowProduct['price'] : $rowProduct['total'] }}" 
                            class="form-control input-product-total"
                            row-id="product-{{ $rowId }}" 
                            readonly>

                            @if ($errors->first('products.' . $rowId . '.total'))
                                <span class="text-danger ">
                                    {{ $errors->first('products.' . $rowId . '.total') }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger row-delete"
                                row-id="product-{{ $rowId }}">--</button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr id="product-1">
                    <td>
                        <select name="products[1][product_id]" class="form-control input-product-product_id"
                            row-id="product-1">
                            {{-- @dd($products) --}}
                            @foreach ($products as $product)
                                {{-- @dd($product) --}}
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                    {{ $product->name }} | {{ $product->price }} </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="products[1][quantity]" value="1"
                            class="form-control input-product-quantity" row-id="product-1">
                    </td>
                    <td>
                        <input type="number" name="products[1][price]" class="form-control input-product-price"
                            row-id="product-1" value="{{ $product->first()->price }}" readonly>
                    </td>
                    <td>
                        <input type="number" name="products[1][total]" value="{{ $product->first()->price }}"
                            class="form-control input-product-total" row-id="product-1" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger row-delete" row-id="product-1">--</button>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
<div class="text-center">
    <button type="submit" class="btn btn-success">Save</button>
</div>



@section('js')
    <script>
        $(document).on('click', '#btn-add-new-product', function() {
            const rowId = Date.now();
            const productRow = `<tr id ="product-${rowId}">
                        <td>
                            <select name="products[${rowId}][product_id]"  row-id ="product-${rowId}" 
                            class="form-control input-product-product_id">
                            @foreach ($products as $product)
                                        <option value=" {{ $product->id }}" data-price="{{ $product->price }}">
                                    {{ $product->name }} | {{ $product->price }} </option>
                            @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number"
                                name="products[${rowId}][quantity]" 
                                row-id ="product-${rowId}"
                                value = "1"
                                class="form-control input-product-quantity">
                        </td>
                        <td>
                            <input type="number" 
                            name="products[${rowId}][price]"  
                            row-id ="product-${rowId}" 
                            class="form-control input-product-price" 
                            value="{{ $product->first()->price }}"
                            readonly>
                        </td>
                        <td>
                            <input type="number" 
                            name="products[${rowId}][total]"  
                            row-id ="product-${rowId}" 
                            class="form-control input-product-total"
                            value="{{ $product->first()->price }}"
                                readonly>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger row-delete" row-id ="product-${rowId}">--</button>
                        </td>
                    </tr> `

            $('#products-list').append(productRow)
        });

        $(document).on('click', '.row-delete', function() {
            const rowId = '#' + $(this).attr('row-id');
            $(rowId).remove();
        });

        $(document).on('keyup', '.input-product-quantity', function() {
            const rowId = '#' + $(this).attr('row-id')

            calTotal(rowId);

        });

        $(document).on('change', '.input-product-product_id', function() {

            const rowId = '#' + $(this).attr('row-id'),
                price = $(this).children("option:selected").data('price');

            $(`${rowId} .input-product-price`).val(price);
            calTotal(rowId);
        });

        function calTotal(rowId) {
            const quantity = $(`${rowId} .input-product-quantity`).val(),
                price = $(`${rowId} .input-product-price`).val(),
                total = price * quantity;
            $(`${rowId} .input-product-total`).val(total);

        }

    </script>

@endsection
