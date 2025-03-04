import React, { useState, useEffect, useRef } from 'react';
import { createRoot } from 'react-dom';
import axios from "axios";
import Swal from "sweetalert2";
import { random, sum } from "lodash";
import { useReactToPrint } from "react-to-print";
import './style.css';

const Cart = () => {
    const [cart, setCart] = useState([]);
    const [products, setProducts] = useState([]);
    const [customers, setCustomers] = useState([]);
    const [barcode, setBarcode] = useState("");
    const [search, setSearch] = useState("");
    const [customerId, setCustomerId] = useState("");
    const [systemInvoiceNumber, setSystemInvoiceNumber] = useState("");
    const [translations, setTranslations] = useState({});
    const [amount, setAmount] = useState("");

    // إنشاء مرجع لعنصر الطباعة
    const contentRef = useRef(null);

    const handlePrint = useReactToPrint({
        contentRef
    });

    useEffect(() => {
        loadTranslations();
        loadCart();
        loadProducts();
        loadCustomers();
    }, []);

    const loadTranslations = async () => {
        try {
            const { data } = await axios.get("/admin/locale/cart");
            setTranslations(data);
        } catch (error) {
            console.error("Error loading translations:", error);
        }
    };

    const loadCustomers = async () => {
        try {
            const { data } = await axios.get("/admin/customers");
            setCustomers(data);
        } catch (error) {
            console.error("Error loading customers:", error);
        }
    };

    const loadProducts = async (search = "") => {
        try {
            const query = search ? `?search=${search}` : "";
            const { data } = await axios.get(`/admin/products${query}`);
            setProducts(data.data);
        } catch (error) {
            console.error("Error loading products:", error);
        }
    };

    const loadCart = async () => {
        try {
            const { data } = await axios.get("/admin/cart");
            setCart(data.cart);
            setSystemInvoiceNumber(random(1000, 9999));
        } catch (error) {
            console.error("Error loading cart:", error);
        }
    };

    const handleScanBarcode = async (event) => {
        event.preventDefault();
        if (barcode) {
            try {
                await axios.post("/admin/cart", { barcode });
                loadCart();
                setBarcode("");
            } catch (err) {
                Swal.fire("Error!", err.response?.data?.message || "Error occurred", "error");
            }
        }
    };

    const handleChangeQty = async (productId, qty) => {
        const updatedCart = cart.map((item) => {
            if (item.id === productId) {
                item.pivot.quantity = qty;
            }
            return item;
        });

        setCart(updatedCart);

        if (!qty) return;

        try {
            await axios.post("/admin/cart/change-qty", { product_id: productId, quantity: qty });
        } catch (err) {
            Swal.fire("Error!", err.response?.data?.message || "Error occurred", "error");
        }
    };

    const handleClickDelete = async (productId) => {
        try {
            await axios.post("/admin/cart/delete", { product_id: productId, _method: "DELETE" });
            setCart(cart.filter((item) => item.id !== productId));
        } catch (error) {
            console.error("Error deleting item:", error);
        }
    };

    const handleEmptyCart = async () => {
        try {
            await axios.post("/admin/cart/empty", { _method: "DELETE" });
            setCart([]);
        } catch (error) {
            console.error("Error emptying cart:", error);
        }
    };

    const addProductToCart = async (barcode) => {
        const product = products.find((p) => p.barcode === barcode);
        if (product) {
            const cartItem = cart.find((c) => c.id === product.id);
            if (cartItem) {
                if (product.quantity > cartItem.pivot.quantity) {
                    handleChangeQty(product.id, cartItem.pivot.quantity + 1);
                }
            } else if (product.quantity > 0) {
                const newProduct = {
                    ...product,
                    pivot: {
                        quantity: 1,
                        product_id: product.id,
                        user_id: 1,
                    },
                };
                setCart([...cart, newProduct]);
                try {
                    await axios.post("/admin/cart", { barcode });
                } catch (err) {
                    Swal.fire("Error!", err.response?.data?.message || "Error occurred", "error");
                }
            }
        }
    };

    const getTotal = (cart) => {
        const total = cart.map((item) => item.pivot.quantity * item.price);
        return sum(total).toFixed(2);
    };

    const handleSearch = (event) => {
        if (event.keyCode === 13) {
            loadProducts(search);
        }
    };

    const handleClickSubmit = async () => {
        if (!amount) {
            Swal.fire("Error!", translations["amount_required"] || "Amount is required", "error");
            return;
        }

        try {
            await axios.post("/admin/orders", {
                customer_id: customerId,
                amount,
            });
            handlePrint(); // طباعة الفاتورة بعد الدفع
            loadCart();
        } catch (err) {
            Swal.fire("Error!", err.response?.data?.message || "Error occurred", "error");
        }
    };

    return (
        <div className="row">
            <div className="col-md-6 col-lg-4">
                <div className="row mb-2">
                    <div className="col">
                        <form onSubmit={handleScanBarcode}>
                            <input
                                type="text"
                                className="form-control"
                                placeholder={translations["scan_barcode"]}
                                value={barcode}
                                onChange={(e) => setBarcode(e.target.value)}
                            />
                        </form>
                    </div>
                    <div className="col">
                        <select
                            className="form-control"
                            onChange={(e) => setCustomerId(e.target.value)}
                        >
                            <option value="">{translations["general_customer"]}</option>
                            {customers.map((customer) => (
                                <option key={customer.id} value={customer.id}>
                                    {`${customer.first_name} ${customer.last_name}`}
                                </option>
                            ))}
                        </select>
                    </div>
                </div>

                <div className="user-cart" ref={contentRef}>
                    <div className="card">
                        {/* اسم المحل */}
                        <h2 style={{ textAlign: "center", fontSize: "24px", fontWeight: "bold" }}>
                            {translations["store_name"] || "Cutting"}
                        </h2>

                        {/* تفاصيل الفاتورة */}
                        <div style={{ textAlign: "center", marginBottom: "10px" }}>
                            <p>
                                <strong>{translations["invoice_number"] || "رقم الفاتورة"}:</strong> #{systemInvoiceNumber}
                            </p>
                            <p>
                                <strong>{translations["address"] || "العنوان"}:</strong> ٨٨ شارع عثمان بن عفان ميدان تريومف
                            </p>
                            <p>
                                <strong>{translations["order_date"] || "تاريخ الطلب"}:</strong>{" "}
                                {new Date().toLocaleDateString("ar-EG")}
                            </p>
                        </div>

                        {/* جدول المنتجات */}
                        <table className="table">
                            <thead>
                                <tr>
                                    <th>{translations["product_name:"] || "اسم المنتج"}</th>
                                    <th>{translations["quantity:"] || "الكمية"}</th>
                                    <th className="text-right">{translations["price:"] || "السعر"}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {cart.map((item) => (
                                    <tr key={item.id}>
                                        <td>
                                            <button
                                                className="btn btn-danger btn-sm mr-2"
                                                onClick={() => handleClickDelete(item.id)}
                                            >
                                                <i className="fas fa-trash"></i>
                                            </button>
                                            {item.name}
                                        </td>
                                        <td>{item.pivot.quantity}</td>
                                        <td className="text-right">
                                            {window.APP.currency_symbol} {(item.price * item.pivot.quantity).toFixed(2)}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>

                        {/* الإجمالي */}
                        <div className="total-section text-center" style={{ marginTop: "15px", fontSize: "18px" }}>
                            <strong>{translations["total:"] || "الإجمالي"}: </strong>
                            {window.APP.currency_symbol} {getTotal(cart)}
                        </div>

                        {/* السعر بعد الخصم */}
                        <div className="total-section text-center" style={{ marginTop: "15px", fontSize: "18px" }}>
                            <strong>{translations["total_after_discount"] || "السعر بعد الخصم"}: </strong>
                            {window.APP.currency_symbol} {amount}
                        </div>

                        {/* رسالة الفاتورة */}
                        <div className="footer-message text-center mt-2">
                            <p>{translations["return_policy"] || "يمكنك الاستبدال والإرجاع خلال 14 يومًا."}</p>
                        </div>
                    </div>
                </div>

                <div className="row">
                    <div className="col">{translations["total"]}:</div>
                    <div className="col text-right">
                        {window.APP.currency_symbol} {getTotal(cart)}
                    </div>
                </div>
                <div className="row">
                    <div className="col">
                        <input
                            type="text"
                            className="form-control"
                            placeholder={translations["amount"] || "المبلغ"}
                            value={amount}
                            onChange={(e) => setAmount(e.target.value)}
                        />
                    </div>
                </div>
                <div className="row">
                    <div className="col">
                        <button
                            type="button"
                            className="btn btn-danger btn-block"
                            onClick={handleEmptyCart}
                            disabled={!cart.length}
                        >
                            {translations["cancel"]}
                        </button>
                    </div>
                    <div className="col">
                        <button
                            type="button"
                            className="btn btn-primary btn-block"
                            disabled={!cart.length}
                            onClick={handleClickSubmit}
                        >
                            {translations["checkout"]}
                        </button>
                    </div>
                </div>
                {/* إضافة زر الطباعة */}
                <div className="row mt-2">
                    <div className="col">
                        <button
                            type="button"
                            className="btn btn-secondary btn-block"
                            onClick={() => handlePrint()}
                            disabled={!cart.length}
                        >
                            {translations["print"] || "طباعة الوصل"}
                        </button>
                    </div>
                </div>
            </div>
            <div className="col-md-6 col-lg-8">
                <div className="mb-2">
                    <input
                        type="text"
                        className="form-control"
                        placeholder={translations["search_product"] + "..."}
                        onChange={(e) => setSearch(e.target.value)}
                        onKeyDown={handleSearch}
                    />
                </div>
                <div className="order-product">
                    {products.map((p) => (
                        <div
                            onClick={() => addProductToCart(p.barcode)}
                            key={p.id}
                            className="item"
                        >
                            <img src={p.image_url} alt="" />
                            <h5
                                style={
                                    window.APP.warning_quantity > p.quantity
                                        ? { color: "red" }
                                        : {}
                                }
                            >
                                {p.name}({p.quantity})
                            </h5>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
};

export default Cart;

const root = document.getElementById("cart");
if (root) {
    const rootInstance = createRoot(root);
    rootInstance.render(<Cart />);
}