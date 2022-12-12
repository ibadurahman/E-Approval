@extends('template.default')

@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <form action="{{route('purchaseOrder.store')}}" method="POST">
                            @csrf
                            <h3 class="text-center">Dealer Info</h3>
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <ul class="list-inline">
                                        <li class="list-inline-item"><b>Dealer : </b></li>
                                        <li class="list-inline-item">{{$dealer->name}}</li>
                                    </ul>
                                    <ul class="list-inline">
                                        <li class="list-inline-item"><b>Alamat : </b></li>
                                        <li class="list-inline-item">{{$dealer->address}}</li>
                                    </ul>
                                    <ul class="list-inline">
                                        <li class="list-inline-item"><b>No. PO : </b></li>
                                        <li class="list-inline-item">{{$poNumber}}</li>
                                    </ul>
                                    <ul class="list-inline">
                                        <li class="list-inline-item"><b>Diajukan Oleh : </b></li>
                                        <li class="list-inline-item">{{Auth::user()->name}}</li>
                                    </ul>
                                </div>
                                <div class="col-6">
                                    <ul class="list-inline">
                                        <li class="list-inline-item"><b>Kode Dealer : </b></li>
                                        <li class="list-inline-item">{{$dealer->code}}</li>
                                    </ul>
                                    <ul class="list-inline">
                                        <li class="list-inline-item"><b>Telp / Email: </b></li>
                                        <li class="list-inline-item">{{$dealer->phone}}/{{$dealer->email}}</li>
                                    </ul>
                                    <ul class="list-inline">
                                        <li class="list-inline-item"><b>Tanggal PO: </b></li>
                                        <li class="list-inline-item">{{Date('Y-m-d')}}</li>
                                    </ul>
                                </div>
                            </div>
                            <hr class="border border-primary border-3 opacity-75">
                            <h3 class="text-center">Order Item</h3>
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Item</label>
                                        <select name="item_id" id="item-combobox" class="form-select @error('item_id') is-invalid @enderror">
                                            @foreach ($items as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('item_id')
                                            <span class="text-danger help-block">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Qty</label>
                                        <input name="qty" id="qty" type="number" class="form-control @error('item_id') is-invalid @enderror">
                                        @error('qty')
                                            <span class="text-danger help-block">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Keterangan</label>
                                        <textarea name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror" id="" cols="30" rows="5"></textarea>
                                        @error('remarks')
                                            <span class="text-danger help-block">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Nama Sub Item</label>
                                        <select name="sub_item_id" id="subItem-combobox" class="form-select @error('item_id') is-invalid @enderror">
                                        </select>
                                        @error('name')
                                            <span class="text-danger help-block">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Harga Satuan</label>
                                        <input name="price" id="price" type="number" class="form-control @error('price') is-invalid @enderror">
                                        @error('price')
                                            <span class="text-danger help-block">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-3 float-right">
                                        <div class="row">
                                            <button class="btn btn-primary" onclick="addPurchaseItem(event)">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="border border-primary border-3 opacity-75">
                            <h3 class="text-center">Purchase Cart</h3>
                            <br>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col" class="text-center">Item</th>
                                        <th scope="col" class="text-center">Sub Item</th>
                                        <th scope="col" class="text-center">Keterangan</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">Harga</th>
                                        <th scope="col" class="text-center">Total</th>
                                        <th scope="col" class="text-center">Hapus</th>
                                    </tr>
                                </thead>
                                <tbody id="purchase-cart-item">
                                </tbody>
                            </table>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-right col-9">Total Price</th>
                                        <th class="text-right col-3" id="total-price"></th>
                                    </tr>
                                </thead>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(function(){
            $('#item-combobox').on('change',function(event)
            {
                const comboboxItem = $('#item-combobox').val()
                const comboboxSubItem = $('#subItem-combobox')
                $.ajax({
                    url:'/purchaseOrder/getSubItem',
                    type:'POST',
                    data:{
                        item    : comboboxItem,
                        _token  :'{{csrf_token()}}'
                    },
                    success:function(response)
                    {
                        var optionList = ''
                        response.forEach(element => {
                            optionList += '<option value="'+element.id+'">'+element.name+'</option>'
                        })
                        comboboxSubItem.html(optionList)
                    }
                })
            })
            $('#item-combobox').trigger('change')
        })

        var no = 1
        var purchaseItem = []
        function addPurchaseItem(e)
        {
            e.preventDefault()

            const itemCombobox      = $('#item-combobox').val()
            const subItemCombobox   = $('#subItem-combobox').val()
            const qty               = $('#qty').val()
            const price             = $('#price').val()
            const remarks           = $('#remarks').val()
            const table             = $('#purchase-cart-item')

            if (itemCombobox == '' || subItemCombobox == '' || qty == 0 || qty == ''
                || price == 0 || price == '') {
                alert('Error : Lengkapi Data Dengan Benar')
                return;
            }

            var totalPrice = price * qty

            table.append(
                '<tr>' +
                    '<td class="text-center">'+no+'</td>' +
                    '<td class="text-center">'+itemCombobox+'</td>' + 
                    '<td class="text-center">'+subItemCombobox+'</td>' + 
                    '<td class="text-center">'+remarks+'</td>' + 
                    '<td class="text-center">'+qty+'</td>' + 
                    '<td class="text-center">'+price+'</td>' + 
                    '<td class="text-center">'+totalPrice+'</td>' +
                    '<td class="text-center"><a href="" onclick="event.preventDefault()" class="text-danger"><i class="fa-solid fa-trash"></i></a></td>' +
                '</tr>'
            )

            purchaseItem.push({
                item_id       : itemCombobox,
                sub_item_id   : subItemCombobox,
                remarks       : remarks,
                qty           : qty,
                price         : price,
                totalPrice    : totalPrice
            }) 
            no++
            sumTotalPrice()
        }
        function sumTotalPrice()
        {
            const totalPriceTable = $('#total-price')
            var totalPrice = 0
            purchaseItem.forEach(item => {
                totalPrice += item.totalPrice
            });

            totalPriceTable.html(totalPrice)
        }
    </script>
@endpush