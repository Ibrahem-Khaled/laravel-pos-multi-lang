import React from 'react';

const Receipt = React.forwardRef((props, ref) => {
    const { cart, customer, total, currencySymbol } = props;

    return (
        <div ref={ref} style={{ padding: '20px', width: '300px', fontFamily: 'Arial, sans-serif' }}>
            <h2>Receipt</h2>
            <hr />
            <div>
                <strong>Customer:</strong> {customer || 'General Customer'}
            </div>
            <hr />
            <table style={{ width: '100%', textAlign: 'left' }}>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    {cart.map((item) => (
                        <tr key={item.id}>
                            <td>{item.name}</td>
                            <td>{item.pivot.quantity}</td>
                            <td>{currencySymbol} {(item.price * item.pivot.quantity).toFixed(2)}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
            <hr />
            <div style={{ textAlign: 'right' }}>
                <strong>Total:</strong> {currencySymbol} {total}
            </div>
        </div>
    );
});

export default Receipt;
