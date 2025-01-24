@extends('layouts.admin')

@section('title', __('product.Product_List'))
@section('content-header', __('product.Product_List'))
@section('content-actions')
    <a href="{{ route('products.create') }}" class="btn btn-primary">{{ __('product.Create_Product') }}</a>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
    <div class="card product-list">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('product.ID') }}</th>
                        <th>{{ __('product.Name') }}</th>
                        <th>{{ __('product.Image') }}</th>
                        <th>{{ __('product.Barcode') }}</th>
                        <th>{{ __('product.main_price') }}</th>
                        <th>{{ __('product.Price') }}</th>
                        <th>{{ __('product.Quantity') }}</th>
                        <th>{{ __('product.Status') }}</th>
                        <th>{{ __('product.Created_At') }}</th>
                        <th>{{ __('product.Updated_At') }}</th>
                        <th>{{ __('product.Actions') }}</th>
                        <th>{{ __('product.Print_Barcode') }}</th> <!-- New Column -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td><img class="product-img" src="{{ Storage::url($product->image) }}" alt=""></td>
                            <td>{{ $product->barcode }}</td>
                            <td>{{ $product?->main_price }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>
                                <span
                                    class="right badge badge-{{ $product->status ? 'success' : 'danger' }}">{{ $product->status ? __('common.Active') : __('common.Inactive') }}</span>
                            </td>
                            <td>{{ $product->created_at }}</td>
                            <td>{{ $product->updated_at }}</td>
                            <td>
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-primary"><i
                                        class="fas fa-edit"></i></a>
                                <button class="btn btn-danger btn-delete"
                                    data-url="{{ route('products.destroy', $product) }}"><i
                                        class="fas fa-trash"></i></button>
                            </td>
                            <td>
                                <button class="btn btn-info btn-print-barcode" data-barcode="{{ $product->barcode }}"
                                    data-name="{{ $product->name }}">
                                    <i class="fas fa-print"></i> {{ __('product.Print_Barcode') }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $products->render() }}
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script type="module">
        $(document).ready(function() {
            // حذف المنتج باستخدام SweetAlert2
            $(document).on('click', '.btn-delete', function() {
                var $this = $(this);
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: '{{ __('product.sure') }}',
                    text: '{{ __('product.really_delete') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '{{ __('product.yes_delete') }}',
                    cancelButtonText: '{{ __('product.No') }}',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post($this.data('url'), {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        }, function(res) {
                            $this.closest('tr').fadeOut(500, function() {
                                $(this).remove();
                            });
                        });
                    }
                });
            });

            // طباعة الباركود
            $(document).on('click', '.btn-print-barcode', function() {
                var barcode = $(this).data('barcode'); // الباركود
                var name = $(this).data('name'); // اسم المنتج
                var price = $(this).closest('tr').find('td:eq(5)').text(); // السعر من العمود المناسب

                // فتح نافذة الطباعة
                var printWindow = window.open('', '', 'width=400,height=250'); // أبعاد النافذة بالبكسل
                printWindow.document.write('<html><head><title>Print Barcode</title>');
                printWindow.document.write(
                    `<style>
                    @page { 
                        size: 40mm 25mm; /* تحديد حجم الورقة للطابعة */
                        margin: 0; /* إزالة الهوامش */
                    }
                    body { 
                        font-family: Arial, sans-serif; 
                        text-align: center; 
                        margin: 0; 
                        padding: 0; 
                        display: flex; 
                        justify-content: center; 
                        align-items: center; 
                        width: 100%; 
                        height: 100%;
                        overflow: hidden;
                    }
                    .barcode-container {
                        width: 100%; 
                        height: 100%; 
                        display: flex; 
                        flex-direction: column; 
                        justify-content: center; 
                        align-items: center; 
                        box-sizing: border-box;
                    }
                    h2 {
                        margin: 0; 
                        font-size: 10px; /* حجم خط اسم المنتج */
                        text-align: center;
                    }
                    p {
                        margin: 0; 
                        font-size: 9px; /* حجم خط السعر */
                        text-align: center;
                    }
                    svg {
                        margin-top: 2px;
                        width: 100%; 
                        height: auto;
                    }
                </style>`
                );
                printWindow.document.write('</head><body>');
                printWindow.document.write('<div class="barcode-container">');
                printWindow.document.write('<h2>' + name + '</h2>'); // اسم المنتج
                printWindow.document.write('<p>Price: ' + price + '</p>'); // السعر
                printWindow.document.write('<svg id="barcode"></svg>'); // مكان الباركود
                printWindow.document.write('</div>');
                printWindow.document.write(
                    '<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"><\/script>'
                );
                printWindow.document.write('<script>JsBarcode("#barcode", "' + barcode +
                    '", { width: 1.5, height: 30, fontSize: 8 });<\/script>'); // توليد الباركود
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
            });
        });
    </script>

@endsection
