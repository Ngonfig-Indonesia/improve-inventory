@component('mail::message')
   <div class="container text-center">
    <h1>List Item Stock Limit</h1>
   </div>
     <x-mail::table>
     <table class="table table-bordered table-hover table-item">
                    <thead>
                        <tr>
                            <th>Kode Item</th>
                            <th>Nama Barang</th>
                            <th>Eom</th>
                            <th>Qty</th>
                            <th>Rak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cekstock as $item)
                            <tr>
                                <td>{{ $item->kode_item}}</td>
                                <td>{{ $item->nama_barang}}</td>
                                <td>{{ $item->eom}}</td>
                                <td>{{ $item->qty}}</td>
                                <td>{{ $item->rak}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
</x-mail::table>
@endcomponent