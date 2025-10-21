let cart = [];

$(document).ready(function () {

    $('.addToCart').click(function () {
        const productId = $(this).closest('.producto').data('id');
        const productName = $(this).closest('.producto').find('img').attr('alt');
        const productPrice = $(this).closest('.producto').data('price');
        
        
        const existingProduct = cart.find(item => item.id === productId);

        if (existingProduct) {
            
            existingProduct.quantity += 1;
        } else {
            
            cart.push({
                id: productId,
                name: productName,
                price: productPrice,
                quantity: 1
            });
        }

        updateCart();  
    });


    function updateCart() {
        
        $('#cartItems').empty();

       
        let total = 0;
        cart.forEach(item => {
            $('#cartItems').append(`
                <li>
                    <span>${item.name}</span> 
                    <span>Cantidad: ${item.quantity}</span>
                    <span>Precio: $${(item.price * item.quantity).toFixed(2)}</span>
                    <button class="removeItem" data-id="${item.id}">Eliminar</button>
                </li>
            `);
            total += item.price * item.quantity;
        });

       
    $('#cartTotal').text(`Total: $${total.toFixed(2)}`);

    // exponer función para otros scripts
    window.getCartTotal = function(){ return total; };
    window.getCartItems = function(){ return cart; };
    window.updateCartUI = updateCart;

        
        if (cart.length > 0) {
            $('#cart').show();
        } else {
            $('#cart').hide();
        }
    }

    
    $(document).on('click', '.removeItem', function () {
        const productId = $(this).data('id');
        cart = cart.filter(item => item.id !== productId);  
        updateCart();  
    });
    
    // Mostrar formulario de checkout al presionar el botón
    $('#checkoutButton').off('click').on('click', function () {
        if (cart.length === 0) {
            alert("Tu carrito está vacío");
            return;
        }
        // mostrar formulario
        $('#checkoutForm').show();
        // actualizar campo total si existe
        const total = cart.reduce((s,i) => s + i.price * i.quantity, 0);
        $('#cartTotal').text(`Total: $${total.toFixed(2)}`);
    });

    // Manejo del formulario de compra (generar factura y permitir imprimir)
    $('#purchaseForm').on('submit', function(e){
        e.preventDefault();
        const name = $('#name').val();
        const phone = $('#phone').val();
        const location = $('#location').val();
        const payment = $('#payment').val();

        const itemsHtml = cart.map(item => `
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;">${item.name}</td>
                <td style="padding: 8px; border: 1px solid #ddd; text-align: center;">${item.quantity}</td>
                <td style="padding: 8px; border: 1px solid #ddd; text-align: right;">$${(item.price*item.quantity).toFixed(2)}</td>
            </tr>
        `).join('');
        const total = cart.reduce((s,i) => s + i.price * i.quantity, 0).toFixed(2);
        const fecha = new Date().toLocaleDateString('es-MX');

        const invoiceHtml = `
            <div class="invoice-container" style="padding:20px; font-family:Arial, sans-serif; color:#000; background-color:#fff; max-width:800px; margin:0 auto;">
                <div style="text-align:center; margin-bottom:20px; border-bottom:2px solid #000; padding-bottom:10px;">
                    <h2 style="margin:0; color:#000; font-size:24px;">Factura - IC Norte</h2>
                    <p style="margin:5px 0; font-size:14px;">Fecha: ${fecha}</p>
                </div>
                
                <div style="margin-bottom:30px;">
                    <h3 style="margin-bottom:10px; color:#000;">Información del Cliente</h3>
                    <div style="background-color:#f8f8f8; padding:15px; border-radius:5px;">
                        <p style="margin:5px 0;"><strong>Nombre:</strong> ${escapeHtml(name)}</p>
                        <p style="margin:5px 0;"><strong>Teléfono:</strong> ${escapeHtml(phone)}</p>
                        <p style="margin:5px 0;"><strong>Ubicación:</strong> ${escapeHtml(location)}</p>
                        <p style="margin:5px 0;"><strong>Forma de Pago:</strong> ${escapeHtml(payment)}</p>
                    </div>
                </div>

                <div style="margin-bottom:30px;">
                    <h3 style="margin-bottom:10px; color:#000;">Detalle de Productos</h3>
                    <table style="width:100%; border-collapse:collapse; background-color:#fff;">
                        <thead>
                            <tr style="background-color:#f0f0f0;">
                                <th style="padding:12px; border:1px solid #ddd; text-align:left;">Producto</th>
                                <th style="padding:12px; border:1px solid #ddd; text-align:center;">Cantidad</th>
                                <th style="padding:12px; border:1px solid #ddd; text-align:right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${itemsHtml}
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" style="padding:12px; border:1px solid #ddd; text-align:right;"><strong>Total:</strong></td>
                                <td style="padding:12px; border:1px solid #ddd; text-align:right;"><strong>$${total}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div style="text-align:center; margin-top:30px; font-size:14px; color:#666;">
                    <p style="margin:5px 0;">¡Gracias por su compra!</p>
                    <p style="margin:5px 0;">IC Norte - Su tienda de confianza</p>
                </div>
            </div>
        `;

        $('#invoiceContent').html(invoiceHtml);
        $('#invoiceContainer').show();

        // permitir imprimir
        $('#printInvoice').off('click').on('click', function(){
            const printWindow = window.open('', '_blank');
            const invoiceContent = $('#invoiceContent').html();
            
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <title>Factura - IC Norte</title>
                    <style>
                        @page {
                            size: A4;
                            margin: 1cm;
                        }
                        body {
                            font-family: Arial, sans-serif;
                            margin: 0;
                            padding: 0;
                            background-color: white;
                            color: black;
                        }
                        * {
                            box-sizing: border-box;
                            -webkit-print-color-adjust: exact !important;
                            print-color-adjust: exact !important;
                        }
                        .invoice-container {
                            padding: 20px;
                            background-color: white !important;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin: 20px 0;
                            background-color: white !important;
                        }
                        th, td {
                            border: 1px solid #000;
                            padding: 8px;
                            background-color: white !important;
                        }
                        th {
                            background-color: #f0f0f0 !important;
                        }
                        @media print {
                            body {
                                width: 210mm;
                                height: 297mm;
                            }
                            .invoice-container {
                                page-break-after: always;
                            }
                            button {
                                display: none !important;
                            }
                        }
                    </style>
                </head>
                <body>
                    ${invoiceContent}
                </body>
                </html>
            `);
            
            printWindow.document.close();
            
            // Esperar a que el contenido se cargue antes de imprimir
            printWindow.onload = function() {
                setTimeout(function() {
                    printWindow.print();
                    // printWindow.close();
                }, 250);
            };
        });

        // cerrar factura
        $('#closeInvoice').off('click').on('click', function(){
            $('#invoiceContainer').hide();
        });

        // limpiar carrito después de mostrar factura
        cart = [];
        updateCart();
        $('#checkoutForm').hide();
    });

    function escapeHtml(text){ return String(text).replace(/[&<>\"]/g, function(c){ return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]; }); }

    function getTotal() {
        let total = 0;
        cart.forEach(item => {
            total += item.price * item.quantity;
        });
        return total;
    }
});
