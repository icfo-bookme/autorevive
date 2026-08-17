import React from "react";
import { BASE_URL } from '../config/Constants';

let removeItem = id => {
    axios.post(BASE_URL + "removeItemFromCart", { item_id: id }).then(data => {
        alertify.error("Item removed!");
    });
};

let openNav = () => {
    document.getElementById("mini_cart active");
}

function uuidv4() {
    return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, (c) =>
        (
            c ^
            (crypto.getRandomValues(new Uint8Array(1))[0] & (15 >> (c / 4)))
        ).toString(16)
    );
}

export default function CartContainer(props) {
    let jsxData = [];
    let cartData = props.data.cart;
    let items = [];
    let totalPrice = 0;
    let totalQuantity = 0;
    let shippingCharge = props.data.shippingCharge
        ? props.data.shippingCharge.amount
        : 0;
    let tempKeyCount = 0;



    const handleCartQtyIncrement = (id) => {
        axios.post(BASE_URL + `addToCart`, { id: id }).then((data) => {
        });
    }

    const handleCartQtyDecrement = (id) => {
        axios.post(BASE_URL + `decreaseToCart`, { id: id }).then((response) => {
        });
    }

    if (cartData != undefined) {
        let objectKeys = Object.keys(cartData.items);

        objectKeys.forEach(element => {
            items.push(cartData.items[element].item);
        });
    }

    if (items.length > 0) {
        totalPrice = cartData.totalPrice;
        totalQuantity = cartData.totalQty;


        items.map((item, valKey) => {
            
            tempKeyCount = valKey + 1;
            jsxData.push(
                <div className="cart_item" key={valKey}>
                    <div className="cart_img">
                        <a href="#">
                            <img src={BASE_URL + item.thumbnail} alt="" id="cartImg" className="img__pointers_none" />
                        </a>
                    </div>
                    <div className="cart_info">
                        <a style={{fontWeight:'bold'}} href={BASE_URL + "singleProductDetails/" + item.id}>
                            {item.name}
                        </a>
                        <p>
                            
                            <span onClick={() => handleCartQtyDecrement(item.id)} className="cart-decrement">
                                <i className="fa fa-minus cart-increment-icon"></i>
                            </span>
                            
                            <p style={{ display: "inline",fontSize:"12px",margin:"0 7px" }}>
                                {cartData.items[item.id].qty} {" "}
                                X ৳{item.sales_price}
                            </p> 
                            
                            <span onClick={() => handleCartQtyIncrement(item.id)} className="cart-increment" >
                                <i className="fa fa-plus cart-decrement-icon"></i>
                            </span>

                            {/* <span> ৳{cartData.items[item.id].price} </span>*/}
                            <br />
                            <span className="current_price current_price_sm pl-0 single-item-total">
                                {cartData.items[item.id].price ? " ৳" + cartData.items[item.id].price : null}
                            </span>


                            {cartData.items[item.id].price ? null : (<a href="tel: 01888-022244" className="price_box_price text-center" style={{ fontSize: '12px', background: '#c70909', padding: '8px 10px', borderRadius: '5px', marginLeft: '2px', color: '#fff',marginTop:'5px' }}>Call Us For Price</a>)}

                        </p>
                    </div>
                    <div className="cart_remove">
                        <a
                            onClick={() => removeItem(item.id)}
                        >
                            <i className="ion-android-close"></i>
                        </a>
                    </div>
                </div>
            );
        });


        jsxData.push(
            <div key={tempKeyCount}>
                <input type="hidden" id="getTotalAmount" />
                <input
                    type="hidden"
                    id="getTotalQuantity"
                    value={cartData.totalQty}
                />

                <div className="mini_cart_table">
                    <div className="cart_total">
                        <span>Sub total:</span>
                        <span className="price" id="totalAmount">
                            ৳{cartData.totalPrice}
                        </span>
                    </div>
                    <div className="cart_total mt-10">
                        <span>Shipping:</span>
                        <span className="price">{cartData.totalPrice >= 3000 ? `৳ 0` : `৳${shippingCharge}`}</span>
                    </div>
                    <div className="cart_total mt-10">
                        <span>total:</span>
                        <span className="price" id="totalAmountWithCharge">
                            ৳{cartData.totalPrice >= 3000 ? cartData.totalPrice : parseInt(cartData.totalPrice) + parseInt(shippingCharge)}
                        </span>
                    </div>
                </div>

                <div className="mini_cart_footer">
                    <div className="cart_button">
                        <a className="active" href={BASE_URL + "checkout"}>
                            Proceed To Checkout
                        </a>
                    </div>
                </div>
            </div>
        );
    } else {

        jsxData.push(<h5 className="text-center text-danger" key={1}> Shopping cart is empty</h5>);
    }

    return (
        <div className="mini_cart_wrapper">
            <a className="text-white">
                <i className="icon-shopping-bag2" />
                <span className="cart_price">
                    ৳{totalPrice} <i className="ion-ios-arrow-down" />
                </span>
                <span className="cart_count">{totalQuantity}</span>
            </a>
            <div className="mini_cart">
                <div className="mini_cart_inner">
                    <div id="sideNavCartData">{jsxData}</div>
                </div>
            </div>

            <div className="floating-cart" id="openSideCartId">
                <button className="btn btn-primary btn__cart__float">
                    <i className="icon-shopping-bag2 text-white"></i>

                    <span
                        className="cart_count_two"
                        id="cartSymbolTwo"
                    >

                        {totalQuantity}
                    </span>
                </button>
            </div>
        </div>
    );
}
