@extends('template.default')

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <form action="{{ route('purchaseOrder.store') }}" method="POST" enctype="multipart/form-data" id="purchase-order-form">
                                @csrf
                                <h3 class="text-center">Dealer Info</h3>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <ul class="list-inline">
                                            <li class="list-inline-item"><b>Dealer : </b></li>
                                            <li class="list-inline-item">{{ $dealer->name }}</li>
                                        </ul>
                                        <ul class="list-inline">
                                            <li class="list-inline-item"><b>Alamat : </b></li>
                                            <li class="list-inline-item">{{ $dealer->address }}</li>
                                        </ul>
                                        <ul class="list-inline">
                                            <li class="list-inline-item"><b>No. PO : </b></li>
                                            <li class="list-inline-item">{{ $poNumber }}</li>
                                        </ul>
                                        <ul class="list-inline">
                                            <li class="list-inline-item"><b>Diajukan Oleh : </b></li>
                                            <li class="list-inline-item">{{ Auth::user()->name }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-6">
                                        <ul class="list-inline">
                                            <li class="list-inline-item"><b>Kode Dealer : </b></li>
                                            <li class="list-inline-item">{{ $dealer->code }}</li>
                                        </ul>
                                        <ul class="list-inline">
                                            <li class="list-inline-item"><b>Telp / Email: </b></li>
                                            <li class="list-inline-item">{{ $dealer->phone }}/{{ $dealer->email }}</li>
                                        </ul>
                                        <ul class="list-inline">
                                            <li class="list-inline-item"><b>Tanggal PO: </b></li>
                                            <li class="list-inline-item">{{ Date('Y-m-d') }}</li>
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
                                            <select name="item_id" id="item-combobox"
                                                class="form-select @error('item_id') is-invalid @enderror">
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('item_id')
                                                <span class="text-danger help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Qty</label>
                                            <input name="qty" id="qty" type="number"
                                                class="form-control @error('item_id') is-invalid @enderror">
                                            @error('qty')
                                                <span class="text-danger help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Keterangan</label>
                                            <textarea name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror" id=""
                                                cols="30" rows="5"></textarea>
                                            @error('remarks')
                                                <span class="text-danger help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">Nama Sub Item</label>
                                            <select name="sub_item_id" id="subItem-combobox"
                                                class="form-select @error('item_id') is-invalid @enderror">
                                            </select>
                                            @error('name')
                                                <span class="text-danger help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Harga Satuan</label>
                                            <input name="price" id="price" type="number"
                                                class="form-control @error('price') is-invalid @enderror">
                                            @error('price')
                                                <span class="text-danger help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-3 float-right">
                                            <div class="row">
                                                <button class="btn btn-primary"
                                                    onclick="addPurchaseItem(event)">Add</button>
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
                                <hr class="border border-primary border-3 opacity-75">
                                <h3 class="text-center">Attachment</h3>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card card-default">
                                            <div class="card-header">
                                                <h3 class="card-title">Documents Upload</h3>
                                            </div>
                                            <div class="card-body">
                                                <div id="actions" class="row">
                                                    <div class="col-lg-6">
                                                        <div class="btn-group w-100">
                                                            <span class="btn btn-success col fileinput-button">
                                                                <i class="fas fa-plus"></i>
                                                                <span>Add files</span>
                                                            </span>
                                                            <button type="reset" class="btn btn-warning col cancel">
                                                                <i class="fas fa-times-circle"></i>
                                                                <span>Cancel upload</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 d-flex align-items-center">
                                                        <div class="fileupload-process w-100">
                                                            <div id="total-progress"
                                                                class="progress progress-striped active"
                                                                role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                                                aria-valuenow="0">
                                                                <div class="progress-bar progress-bar-success"
                                                                    style="width:0%;" data-dz-uploadprogress></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table table-striped files" id="previews">
                                                    <div id="template" class="row mt-2">
                                                        <div class="col-auto">
                                                            <span class="preview"><img src="data:," alt=""
                                                                    data-dz-thumbnail /></span>
                                                        </div>
                                                        <div class="col d-flex align-items-center">
                                                            <p class="mb-0">
                                                                <span class="lead" data-dz-name></span>
                                                                (<span data-dz-size></span>)
                                                            </p>
                                                            <strong class="error text-danger"
                                                                data-dz-errormessage></strong>
                                                        </div>
                                                        <div class="col-4 d-flex align-items-center">
                                                            <div class="progress progress-striped active w-100"
                                                                role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                                                aria-valuenow="0">
                                                                <div class="progress-bar progress-bar-success"
                                                                    style="width:0%;" data-dz-uploadprogress></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto d-flex align-items-center">
                                                            <div class="btn-group">
                                                                <button data-dz-remove class="btn btn-warning cancel">
                                                                    <i class="fas fa-times-circle"></i>
                                                                    <span>Cancel</span>
                                                                </button>
                                                                <button data-dz-remove class="btn btn-danger delete">
                                                                    <i class="fas fa-trash"></i>
                                                                    <span>Delete</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="border border-primary border-3 opacity-75">
                                    <h3 class="text-center">Approval</h3>
                                    <br>
                                    <table class="table no-border">
                                        <tr>
                                            <td class="col-4 text-center" id="level-1"></td>
                                            <td class="col-4 text-center" id="level-2"></td>
                                            <td class="col-4 text-center" id="level-3"></td>
                                        </tr>
                                        <tr>
                                            <th class="col-4 text-center" id="level-1-name"></th>
                                            <th class="col-4 text-center" id="level-2-name"></th>
                                            <th class="col-4 text-center" id="level-3-name"></th>
                                        </tr>
                                    </table>
                                    <hr class="border border-primary border-3 opacity-75">
                                    <br>
                                    <div class="row">
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-12 text-center">
                                                    <button class="btn btn-primary col-6" id="submit-btn">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        Dropzone.autoDiscover = false

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/purchaseOrder/uploadFiles", // Set the url
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            parallelUploads: 10,
            maxFiles: 10,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button",
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file, xhr, formData) {
            formData.append('po_num','{{$poNumber}}')
            document.querySelector("#total-progress").style.opacity = "1"
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            $('#purchase-order-form').submit()
            document.querySelector("#total-progress").style.opacity = "0"
        })

        myDropzone.on("completemultiple", function(progress) {
        })

        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true)
        }
    </script>
    <script>
        $(function() {
            $('#item-combobox').on('change', function(event) {
                const comboboxItem = $('#item-combobox').val()
                const comboboxSubItem = $('#subItem-combobox')
                $.ajax({
                    url: '/purchaseOrder/getSubItem',
                    type: 'POST',
                    data: {
                        item: comboboxItem,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        var optionList = ''
                        response.forEach(element => {
                            optionList += '<option value="' + element.id + '">' +
                                element.name + '</option>'
                        })
                        comboboxSubItem.html(optionList)
                    },
                })
            })
            $('#item-combobox').trigger('change')
        })
        var no = 1
        var purchaseItem = []

        function addPurchaseItem(e) {
            e.preventDefault()

            const itemCombobox = $('#item-combobox').val()
            const subItemCombobox = $('#subItem-combobox').val()
            const qty = $('#qty').val()
            const price = $('#price').val()
            const remarks = $('#remarks').val()
            const table = $('#purchase-cart-item')

            if (itemCombobox == '' || subItemCombobox == '' || qty == 0 || qty == '' ||
                price == 0 || price == '') {
                alert('Error : Lengkapi Data Dengan Benar')
                return;
            }

            var totalPrice = price * qty

            table.append(
                '<tr>' +
                '<td class="text-center">' + no + '</td>' +
                '<td class="text-center" id="itemName-' + no + '"></td>' +
                '<td class="text-center" id="subItemName-' + no + '"></td>' +
                '<td class="text-center">' + remarks + '</td>' +
                '<td class="text-center">' + qty + '</td>' +
                '<td class="text-center">' + price + '</td>' +
                '<td class="text-center">' + totalPrice + '</td>' +
                '<td class="text-center"><a href="" onclick="event.preventDefault()" class="text-danger"><i class="fa-solid fa-trash"></i></a></td>' +
                '</tr>'
            )

            const itemNameColumn = $('#itemName-' + no)
            const subItemNameColumn = $('#subItemName-' + no)
            $.ajax({
                url: '/purchaseOrder/getItemName',
                type: 'POST',
                data: {
                    item_id: itemCombobox,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    itemNameColumn.html(response.name)
                }
            })

            $.ajax({
                url: '/purchaseOrder/getSubItemName',
                type: 'POST',
                data: {
                    subItem_id: subItemCombobox,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    subItemNameColumn.html(response.name)
                }
            })

            purchaseItem.push({
                item_id: itemCombobox,
                sub_item_id: subItemCombobox,
                remarks: remarks,
                qty: qty,
                price: price,
                totalPrice: totalPrice
            })
            sumTotalPrice()
            no++
        }

        function sumTotalPrice() {
            const totalPriceTable = $('#total-price')
            var totalPrice = 0
            purchaseItem.forEach(item => {
                totalPrice += item.totalPrice
            });

            totalPriceTable.html(totalPrice)
            reloadApprovalData(totalPrice)
        }

        function reloadApprovalData(value) {
            const level1Approval = $('#level-1')
            const level2Approval = $('#level-2')
            const level3Approval = $('#level-3')
            const level1ApprovalName = $('#level-1-name')
            const level2ApprovalName = $('#level-2-name')
            const level3ApprovalName = $('#level-3-name')

            $.ajax({
                url: '/purchaseOrder/getApprovalData',
                type: 'POST',
                data: {
                    dealer_id: '{{ $dealer->id }}',
                    total_price: value,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.ApproveRule1) {
                        level1Approval.html(response.dealerApproveRule1.position)
                        level1ApprovalName.html(response.dealerApproveRule1.name)
                    }
                    if (response.ApproveRule2) {
                        level2Approval.html(response.dealerApproveRule2.position)
                        level2ApprovalName.html(response.dealerApproveRule2.name)
                    }
                    if (response.ApproveRule3) {
                        level3Approval.html(response.dealerApproveRule3.position)
                        level3ApprovalName.html(response.dealerApproveRule3.name)
                    }
                }
            })
        }

        $('#submit-btn').on('click', function(event) {
            event.preventDefault()
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        })

        $('#purchase-order-form').on("submit",function(event){
            purchaseItem.forEach(item => {
                var input = $("<input>").attr({"type":"hidden","name":"items[]"}).val(JSON.stringify(item))
                $('#purchase-order-form').append(input)
            })
            return true
        })
    </script>
@endpush
