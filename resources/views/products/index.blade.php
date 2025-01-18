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

            // Print Barcode Functionality
            $(document).on('click', '.btn-print-barcode', function() {
                var barcode = $(this).data('barcode');
                var name = $(this).data('name');
                var price = $(this).closest('tr').find('td:eq(5)').text(); // الحصول على السعر من العمود المناسب

                // إنشاء نافذة جديدة للتحكم في الحجم
                var controlWindow = window.open('', '', 'width=400,height=300');
                controlWindow.document.write('<html><head><title>Control Barcode Size</title>');
                controlWindow.document.write(
                    '<style>body { font-family: Arial, sans-serif; text-align: center; padding: 20px; } .preview { margin: 20px 0; }</style>'
                );
                controlWindow.document.write('</head><body>');
                controlWindow.document.write('<h2>Control Barcode Size</h2>');
                controlWindow.document.write('<p>Adjust the size of the barcode:</p>');
                controlWindow.document.write('<input type="range" id="sizeControl" min="0.5" max="3" step="0.1" value="1">');
                controlWindow.document.write('<div class="preview"><svg id="barcodePreview"></svg></div>');
                controlWindow.document.write('<button id="printButton">Print Barcode</button>');
                controlWindow.document.write(
                    '<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"><\/script>'
                );
                controlWindow.document.write('<script>');
                controlWindow.document.write('var sizeControl = document.getElementById("sizeControl");');
                controlWindow.document.write('var barcodePreview = document.getElementById("barcodePreview");');
                controlWindow.document.write('JsBarcode(barcodePreview, "' + barcode + '", { width: 1, height: 20, fontSize: 10 });');
                controlWindow.document.write('sizeControl.addEventListener("input", function() {');
                controlWindow.document.write('    var size = parseFloat(sizeControl.value);');
                controlWindow.document.write('    barcodePreview.setAttribute("width", size * 100);');
                controlWindow.document.write('    barcodePreview.setAttribute("height", size * 20);');
                controlWindow.document.write('});');
                controlWindow.document.write('document.getElementById("printButton").addEventListener("click", function() {');
                controlWindow.document.write('    var size = parseFloat(sizeControl.value);');
                controlWindow.document.write('    var printWindow = window.open("", "", "width=600,height=400");');
                controlWindow.document.write('    printWindow.document.write(\'<html><head><title>Print Barcode</title>\');');
                controlWindow.document.write('    printWindow.document.write(\'<style>body { font-family: Arial, sans-serif; text-align: center; }</style>\');');
                controlWindow.document.write('    printWindow.document.write(\'</head><body>\');');
                controlWindow.document.write('    printWindow.document.write(\'<h2 style="font-size: 12px;">' + name + '</h2>\');');
                controlWindow.document.write('    printWindow.document.write(\'<p style="font-size: 12px;">Price: ' + price + '</p>\');');
                controlWindow.document.write('    printWindow.document.write(\'<svg id="barcode"></svg>\');');
                controlWindow.document.write('    printWindow.document.write(\'<script>JsBarcode("#barcode", "' + barcode + '", { width: \' + size + \', height: 20, fontSize: 10 });<\/script>\');');
                controlWindow.document.write('    printWindow.document.write(\'</body></html>\');');
                controlWindow.document.write('    printWindow.document.close();');
                controlWindow.document.write('    printWindow.print();');
                controlWindow.document.write('});');
                controlWindow.document.write('</script>');
                controlWindow.document.write('</body></html>');
                controlWindow.document.close();
            });
        });
    </script>
@endsection