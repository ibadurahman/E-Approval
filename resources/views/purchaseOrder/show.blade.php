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
                                            <input name="dealer_id" type="text" hidden value="{{ $dealer->id }}">
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
                                        </tr>
                                    </thead>
                                    <tbody id="purchase-cart-item">
                                        <?php $no = 1;
                                        $totalPrice = 0; ?>
                                        @foreach ($items as $item)
                                            <tr>
                                                <td class="text-center">{{ $no }}</td>
                                                <td class="text-center">{{ $item->item->name }}</td>
                                                <td class="text-center">{{ $item->subItem->name }}</td>
                                                <td class="text-center">{{ $item->remarks }}</td>
                                                <td class="text-center">{{ $item->qty }}</td>
                                                <td class="text-center">{{ $item->price }}</td>
                                                <td class="text-center">{{ $item->price * $item->qty }}</td>
                                            </tr>
                                            <?php $no++;
                                            $totalPrice += $item->price * $item->qty; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-right col-9">Total Price</th>
                                            <th class="text-right col-3" id="total-price">{{ $totalPrice }}</th>
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
                                            <ol class="list-group list-group-bullet">
                                                @foreach ($attachments as $attach)
                                                    <li class="list-group-item"><a href="{{url('/purchaseOrder/'.$purchaseOrder->id.'/downloadFile/'.$attach->file_name)}}">{{$attach->file_name}}</a></li>
                                                @endforeach
                                            </ol>
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
                                                {{$approval['level_1_position']}}
                                            @endif
                                        </td>
                                        <td class="col-4 text-center" id="level-2">
                                            @if (!is_null($approval['level_2_position']))
                                                {{$approval['level_2_position']}}
                                            @endif
                                        </td>
                                        <td class="col-4 text-center" id="level-3">
                                            @if (!is_null($approval['level_3_position']))
                                                {{$approval['level_3_position']}}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="col-4 text-center" id="level-1-name">
                                            @if (!is_null($approval['level_1_name']))
                                                {{$approval['level_1_name']}}
                                            @endif
                                        </th>
                                        <th class="col-4 text-center" id="level-2-name">
                                            @if (!is_null($approval['level_2_name']))
                                                {{$approval['level_2_name']}}
                                            @endif
                                        </th>
                                        <th class="col-4 text-center" id="level-3-name">
                                            @if (!is_null($approval['level_3_name']))
                                                {{$approval['level_3_name']}}
                                            @endif
                                        </th>
                                    </tr>
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
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        function sumTotalPrice() {
            const totalPriceTable = $('#total-price')
            var totalPrice = 0
            purchaseItem.forEach(item => {
                totalPrice += item.totalPrice
            });

            totalPriceTable.html(totalPrice)
            reloadApprovalData(totalPrice)
        }
    </script>
@endpush
