import React, { useState, useEffect } from "react";
import { BASE_URL } from "../config/Constants";
import emptyBoxImg from "../../../../public/img/open-box.png"
export default function Wishlist(props) {
    const [wishList, setWishList] = useState([]);
    const [emptyMssge, setEmptyMssge] = useState(false);
    const [counter, setCount] = useState(0);
    let items = [];
    let jsxData = [];

    axios.post(BASE_URL + "getWishReactData").then(({ data }) => {
        if (data.wish) {
            setEmptyMssge(false);
            if (JSON.stringify(wishList) != JSON.stringify(data.wish)) {
                setWishList(data.wish);
            }
        } else {
            setEmptyMssge(true);
        }
    });

    return (
        <div className={emptyMssge ? `wishlist_page_bg d-flex justify-content-center align-items-center` : `wishlist_page_bg`}>
            {itemSetup()}
            <div className="container">
                <div className="wishlist_area">
                    {emptyMssge ? (<div className="row d-flex justify-content-center">
                        <div className="col-lg-10">
                            <div className="card d-flex justify-content-center align-items-center py-5" style={{ backgroundColor: '#FAFAFA' }}>
                                <img src={emptyBoxImg} className="emptyboxStyle mb-2" />
                                <h2 className="emptyTitle" style={{ textAlign: 'center' }}>Your Wishlist is Empty</h2>
                                <p style={{ color: '#A0A0A0', textAlign: 'center' }}>Click heart icon to start saving your favourite items.</p>
                                <a href={BASE_URL + "shopview"} className="addNowBtn">Add Now</a>
                            </div>
                        </div>
                    </div>) : (
                        <>
                            <h2 className="section__title">Wishlist</h2>
                            <div className="wishlist_inner" id="custom__scroll">
                                <form action="#">
                                    <div className="row">
                                        <div className="col-12">
                                            <div className="table_desc wishlist">
                                                <div className="cart_page table-responsive">
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th className="product_remove">
                                                                    Delete
                                                                </th>
                                                                <th className="product_thumb">
                                                                    Image
                                                                </th>
                                                                <th className="product_name">
                                                                    Product
                                                                </th>
                                                                <th className="product-price">
                                                                    Price
                                                                </th>
                                                                <th className="product_quantity">
                                                                    Stock Status
                                                                </th>
                                                                <th className="product_total">
                                                                    Add To Cart
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            {items.map((val, key) => {
                                                                let htmlData = (
                                                                    <tr key={val.id}>
                                                                        <td
                                                                            onClick={() =>
                                                                                removeItemFromWish(
                                                                                    val.id
                                                                                )
                                                                            }
                                                                            style={{
                                                                                cursor:
                                                                                    "pointer"
                                                                            }}
                                                                            className="custom__remove__btn"
                                                                        >
                                                                            <span>
                                                                                X
                                                                            </span>
                                                                        </td>
                                                                        <td className="product_thumb">
                                                                            <a href="#">
                                                                                <img
                                                                                    src={
                                                                                        BASE_URL +
                                                                                        val.thumbnail
                                                                                    }
                                                                                    alt=""
                                                                                    className="img__pointers_none wishlist__img"
                                                                                />
                                                                            </a>
                                                                        </td>
                                                                        <td className="product_name">
                                                                            <a
                                                                                href={
                                                                                    BASE_URL +
                                                                                    "singleProductDetails/" +
                                                                                    val.id
                                                                                }
                                                                            >
                                                                                {
                                                                                    val.name
                                                                                }
                                                                            </a>
                                                                        </td>
                                                                        <td className="product-price">
                                                                            {/* {
                                                                        val.sales_price
                                                                    } */}

                                                                            <span className="current_price current_price_sm pl-0">
                                                                                {val.sales_price
                                                                                    ? " ৳" +
                                                                                    val.sales_price
                                                                                    : null}
                                                                            </span>
                                                                            {val.sales_price ? null : (
                                                                                <a
                                                                                    href="tel: 01888-022244"
                                                                                    className="price_box_price"
                                                                                    style={{
                                                                                        fontSize:
                                                                                            "12px",
                                                                                        background:
                                                                                            "#c70909",
                                                                                        padding:
                                                                                            "8px 10px",
                                                                                        borderRadius:
                                                                                            "5px",
                                                                                        marginLeft:
                                                                                            "2px",
                                                                                        color:
                                                                                            "#fff"
                                                                                    }}
                                                                                >
                                                                                    Call
                                                                                    Us
                                                                                    For
                                                                                    Price
                                                                                </a>
                                                                            )}
                                                                        </td>
                                                                        <td className="product_quantity">
                                                                            In Stock
                                                                        </td>
                                                                        <td className="product_total">
                                                                            <a
                                                                                onClick={() =>
                                                                                    addItemToWishCart(
                                                                                        val.id
                                                                                    )
                                                                                }
                                                                            >
                                                                                Add To
                                                                                Cart
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                );

                                                                jsxData.push(htmlData);
                                                            })}

                                                            {jsxData}
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </>)}
                </div>
            </div>
        </div>
    );

    function itemSetup() {
        if (wishList.items) {
            let objectKeys = Object.keys(wishList.items);

            objectKeys.forEach(element => {
                items.push(wishList.items[element].item);
            });
        }
    }

    function addItemToWishCart(id) {
        axios.post(BASE_URL + `addToCart`, { id: id }).then(data => {
            alertify.success("Added to cart!!");
            removeItemFromWish(id);
        });
    }

    function removeItemFromWish(id) {
        axios
            .post(BASE_URL + "removeItemFromWish", { item_id: id })
            .then(data => {
                //  alertify.error("Successfully removed!");
                setWishList([]);
            });
    }
}
