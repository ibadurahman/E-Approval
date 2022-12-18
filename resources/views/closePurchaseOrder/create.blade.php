@extends('template.default')

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <form action="{{ route('purchaseOrder.store') }}" method="POST" enctype="multipart/form-data"
                                id="purchase-order-form">
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
                                            <li class="list-inline-item">{{ $purchaseOrder->po_num }}</li>
                                        </ul>
                                        <ul class="list-inline">
                                            <li class="list-inline-item"><b>Diajukan Oleh : </b></li>
                                            <li class="list-inline-item">{{ $created_by }}</li>
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
                                            <li class="list-inline-item">{{ $purchaseOrder->release_date }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <hr class="border border-primary border-3 opacity-75">
                                <h3 class="text-center">Purchase Report</h3>
                                <br>
                                <table class="table report">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">#</th>
                                            <th scope="col" class="text-center">Item</th>
                                            <th scope="col" class="text-center">Sub Item</th>
                                            <th scope="col" class="text-center">Keterangan</th>
                                            <th scope="col" class="text-center">Qty</th>
                                            <th scope="col" class="text-center">Harga</th>
                                            <th scope="col" class="text-center">Total</th>
                                            <th scope="col" class="text-center">Total Actual</th>
                                        </tr>
                                    </thead>
                                    <tbody id="purchase-cart-item">
                                        <?php $no = 1; ?>
                                        <?php $totalPrice = 0; ?>
                                        @foreach ($purchaseOrderItem as $item)
                                            <tr id="0" class="table-active">
                                                <td class="text-center">{{ $no }}</td>
                                                <td class="text-center">{{ $item->item->name }}</td>
                                                <td class="text-center">{{ $item->subitem->name }}</td>
                                                <td class="text-center">{{ $item->remarks }}</td>
                                                <td class="text-center">{{ $item->qty }}</td>
                                                <td class="text-center">{{ $item->price }}</td>
                                                <td class="text-center">{{ $item->price * $item->qty }}</td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <?php $totalPrice += $item->price * $item->qty; ?>
                                            <tr id="{{ $item->id }}">
                                                <th colspan="4" class="text-center">Actual</th>
                                                <td><input type="number" class="form-control input-qty"
                                                        id="qty-{{ $item->id }}" placeholder="actual qty"
                                                        value="0"></td>
                                                <td><input type="number" class="form-control input-price"
                                                        id="price-{{ $item->id }}" placeholder="actual price"
                                                        value="0"></td>
                                                <td></td>
                                                <td id="total-price-{{ $item->id }}" class="text-center">0</td>
                                            </tr>
                                            <?php $no++; ?>
                                        @endforeach
                                        <tr id="0" class="table-active">
                                            <th class="text-center" colspan="6">Total Price</th>
                                            <td class="text-center">{{ $totalPrice }}</td>
                                            <th class="text-center" id="total-price">0</th>
                                        </tr>
                                    </tbody>
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
                                </div>
                                <hr class="border border-primary border-3 opacity-75">
                                <h3 class="text-center">Approval</h3>
                                <br>
                                <table class="table no-border">
                                    <tr>
                                        <td class="col-4 text-center" id="level-1">
                                            @if (!is_null($approval['level_1_position']))
                                                {{ $approval['level_1_position'] }}
                                            @endif
                                        </td>
                                        <td class="col-4 text-center" id="level-2">
                                            @if (!is_null($approval['level_2_position']))
                                                {{ $approval['level_2_position'] }}
                                            @endif
                                        </td>
                                        <td class="col-4 text-center" id="level-3">
                                            @if (!is_null($approval['level_3_position']))
                                                {{ $approval['level_3_position'] }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-4 text-center">
                                            @if (!is_null($approval['level_1_name']))
                                                @if (!is_null($is_approved['level_1_approved_by']))
                                                    <img src="{{ asset('images\sign\\' . $is_approved['level_1_approved_sign']) }}"
                                                        class="img" alt="" width="30%">
                                                @endif
                                            @endif
                                        </td>
                                        <td class="col-4 text-center">
                                            @if (!is_null($approval['level_2_name']))
                                                @if (!is_null($is_approved['level_2_approved_by']))
                                                    <img src="{{ asset('images\sign\\' . $is_approved['level_2_approved_sign']) }}"
                                                        class="img" alt="" width="30%">
                                                @endif
                                            @endif
                                        </td>
                                        <td class="col-4 text-center">
                                            @if (!is_null($approval['level_3_name']))
                                                @if (!is_null($is_approved['level_3_approved_by']))
                                                    <img src="{{ asset('images\sign\\' . $is_approved['level_3_approved_sign']) }}"
                                                        class="img" alt="" width="30%">
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="col-4 text-center" id="level-1-name">
                                            @if (!is_null($approval['level_1_name']))
                                                {{ $approval['level_1_name'] }}
                                            @endif
                                        </th>
                                        <th class="col-4 text-center" id="level-2-name">
                                            @if (!is_null($approval['level_2_name']))
                                                {{ $approval['level_2_name'] }}
                                            @endif
                                        </th>
                                        <th class="col-4 text-center" id="level-3-name">
                                            @if (!is_null($approval['level_3_name']))
                                                {{ $approval['level_3_name'] }}
                                            @endif
                                        </th>
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
            document.querySelector("#total-progress").style.opacity = "1"
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            $('#purchase-order-form').submit()
            document.querySelector("#total-progress").style.opacity = "0"
        })

        myDropzone.on("completemultiple", function(progress) {})

        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true)
        }
    </script>
    <script>
        $(function() {
            $('.input-qty').on('input', function(event) {
                const rowId = $(this).closest('tr').attr('id')
                const qty = $('#qty-' + rowId).val()
                const price = $('#price-' + rowId).val()
                var totalPrice = 0
                var actualTotalPrice = 0
                if (!(price == null || qty == null)) {
                    totalPrice = qty * price
                }
                $('#total-price-' + rowId).html(totalPrice)
                $('table.report>tbody>tr').each(function(index, tr) {
                    if (tr.id != 0) {
                        var priceInput = parseInt($('#total-price-' + tr.id).html())
                        if (priceInput != NaN) {
                            actualTotalPrice += priceInput
                        }
                    }
                })
                $('#total-price').html(actualTotalPrice)
            })
            $('.input-price').on('input', function(event) {
                const rowId = $(this).closest('tr').attr('id')
                const qty = $('#qty-' + rowId).val()
                const price = $('#price-' + rowId).val()
                var totalPrice = 0
                var actualTotalPrice = 0
                if (!(price == null || qty == null)) {
                    totalPrice = qty * price
                }
                $('#total-price-' + rowId).html(totalPrice)
                $('table.report>tbody>tr').each(function(index, tr) {
                    if (tr.id != 0) {
                        var priceInput = parseInt($('#total-price-' + tr.id).html())
                        if (priceInput != NaN) {
                            actualTotalPrice += priceInput
                        }
                    }
                })
                $('#total-price').html(actualTotalPrice)
            })
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
            const poForm = $('#purchase-order-form')

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
                        $('#approval-lv-1').val(JSON.stringify(response.dealerApproveRule1))
                    }
                    if (response.ApproveRule2) {
                        level2Approval.html(response.dealerApproveRule2.position)
                        level2ApprovalName.html(response.dealerApproveRule2.name)
                        $('#approval-lv-2').val(JSON.stringify(response.dealerApproveRule2))
                    }
                    if (response.ApproveRule3) {
                        level3Approval.html(response.dealerApproveRule3.position)
                        level3ApprovalName.html(response.dealerApproveRule3.name)
                        $('#approval-lv-2').val(JSON.stringify(response.dealerApproveRule2))
                    }
                }
            })
        }

        $('#submit-btn').on('click', function(event) {
            event.preventDefault()
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        })

        $('#purchase-order-form').on("submit", function(event) {
            purchaseItem.forEach(item => {
                var input = $("<input>").attr({
                    "type": "hidden",
                    "name": "items[]"
                }).val(JSON.stringify(item))
                $('#purchase-order-form').append(input)
            })
            return true
        })
    </script>
@endpush
