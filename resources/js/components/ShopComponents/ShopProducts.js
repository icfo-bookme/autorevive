import React, { useState, useEffect } from "react";
import { BASE_URL } from "../config/Constants";
import ratingImg from "../../../../public/mazley_assets/img/rating.png"

function uuidv4() {
    return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, (c) =>
        (
            c ^
            (crypto.getRandomValues(new Uint8Array(1))[0] & (15 >> (c / 4)))
        ).toString(16)
    );
}

export default function ShopProducts(props) {
    //const [productNameLength, setProductNameLength] = useState();
    // useEffect(() => {
    //    if(window.innerWidth > 991 && window.innerWidth <= 1366){
    //     setProductNameLength(25);
    //    }
    //    else if (window.innerWidth > 1400 &&  window.innerWidth <= 1600){
    //     setProductNameLength(35);
    //    }else if (window.innerWidth > 1601 &&  window.innerWidth <= 1920){
    //     setProductNameLength(40);
    //    }
    // }, []);

    function getProductRatingJsx(product) {
        let totalRating = 0;
        let rating = [];
        if (product.rating) {
            product.rating.map((r) => (totalRating += r.rating));
            let ratingAverage = Math.ceil(totalRating / product.rating.length);

            for (let i = 0; i < ratingAverage; i++) {
                rating.push(
                    <li key={uuidv4()}>
                        <a>
                            <i
                                className="fa fa-star font__15"
                                style={{ color: "#ffc600" }}
                            ></i>
                        </a>
                    </li>
                );
            }
            return rating;
        } else {
            return rating;
        }
    }

    function openModal() {
        $("#quickViewModal").modal("show");
        $("#quickViewModalLongTitle").text(props.products.name);
        // $("#item_modal_thumbnail").attr(
        //     "src",
        //     BASE_URL + props.products.thumbnail
        // );
        $(".item_modal_image").attr("src", BASE_URL + props.products.thumbnail);
        $(".item_modal_image").attr("xoriginal", BASE_URL+ props.products.thumbnail);
        $("#item_modal_name").html(
            `<a href="${BASE_URL}singleProductDetails/${props.products.id}">${props.products.name}</a>`
        );
        $("#item_modal_detail").html(props.products.details);
    }
    let productName = props.products.name;

    // if (props.products.name.length > productNameLength) {
    //     productName = props.products.name.substring(0, productNameLength) + "...";
    // } else {
    //     productName = props.products.name;
    // }

    let rating = getProductRatingJsx(props.products);
    console.log("props products thumbnail", props.products);

    return (
        <div className="col-6 col-lg-3 col-md-4 col-sm-4">
            <article className="single_product single_product_shop">
                <figure>
                    <div className="product_thumb ">
                        <a
                            className="primary_img"
                            href={
                                BASE_URL +
                                "singleProductDetails/" +
                                props.products.id
                            }
                        >
                            <img src={BASE_URL + props.products.resized_image} id="productThumbnail" className="text-center img__pointers_none" />
                        </a>
                        <div className="quick_button">
                            <a title="quick view" onClick={() => openModal()}>
                                <i className="icon-eye"></i>
                            </a>
                        </div>
                    </div>
                    <div className="product_content grid_content">
                        <div className="product_content_inner">
                            <h4 className="product_name">
                                <a
                                 className="productName_overflow"
                                    href={
                                        BASE_URL +
                                        "singleProductDetails/" +
                                        props.products.id
                                    }
                                    title={props.products.name}
                                >
                                    {" "}
                                    {/* {props.products.name} */}
                                    {productName}
                                </a>
                            </h4>
                            <div className="product_rating mb-2">
                                <ul>
                                    {rating.length ? rating : (<p className="rate__product">
                                        <a href= { BASE_URL + "singleProductDetails/" + props.products.id }>
                                            Rate this product</a>
                                            </p>)}
                                </ul>
                            </div>
                            <div className="price_box">
                                <span className="old_price old_price_sm">
                                    {/* ৳{props.products.regular_price} */}
                                    {props.products.regular_price &&
                                    props.products.regular_price !=
                                        props.products.sales_price
                                        ? "৳" + props.products.regular_price
                                        : ""}
                                </span>

                                <span className="current_price current_price_sm pl-0">
                                   {props.products.sales_price != 0 && props.products.sales_price != null ? " ৳"+ props.products.sales_price : (<a href="tel: 01888-022244" className="price_box_price " style={{ fontSize: '12px', background: '#c70909', padding: '8px 10px', borderRadius: '5px', marginLeft: '2px', color: '#fff' }}>Call Us For Price</a>)}
                                </span>

                                {/* {props.products.sales_price ? null : (<a href="tel: 01888-022244" className="price_box_price" style={{ fontSize: '12px', background: '#c70909', padding: '8px 10px', borderRadius: '5px', marginLeft: '2px', color: '#fff' }}>Call Us For Price</a>)} */}

                                {/* <span className="current_price current_price_sm">
                                    ৳{props.products.sales_price}

                                </span> */}
                            </div>

                            <div className="wishlist-sm my-2">
                                <a
                                    className="text-white"
                                    onClick={() => {
                                        addItemToWish(props.products.id);
                                    }}
                                >
                                    <i className="icon-heart"></i>
                                </a>
                            </div>
                            <a
                                className="btn btn__cart add_to_cart mr-2"
                                onClick={() => {
                                    addItemToCart(props.products.id);
                                }}
                            >
                                Add to Cart
                            </a>
                            {/* <a title="Add to Wishlist" className="sm__wishlist">
                                        <i
                                            className="icon-heart"
                                            onClick={() => {
                                                addItemToWish(props.products.id);
                                            }}
                                        ></i>
                            </a> */}
                            {/* <div className="header_wishlist sm__wishlist sm__mb">
                                <a className="text-white" onClick={() => { addItemToWish(props.products.id); }}><i className="icon-heart"></i></a>
                             </div> */}
                        </div>
                        <div className="action_links lg_screen_btn">
                            <ul>
                                <li
                                    className="add_to_cart"
                                    onClick={() => {
                                        addItemToCart(props.products.id);
                                    }}
                                >
                                    <a title="Add to cart">Add to cart</a>
                                </li>
                                <li className="wishlist pl-3">
                                    <a title="Add to Wishlist">
                                        <i
                                            className="icon-heart"
                                            onClick={() => {
                                                addItemToWish(
                                                    props.products.id
                                                );
                                            }}
                                        ></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </figure>
            </article>
        </div>
    );
}


function addItemToWish(id) {
    axios.post(BASE_URL + `addToWish`, { id: id }).then((data) => {
        alertify.success("Added to wishlist");
    });
}

function addItemToCart(id) {
    axios.post(BASE_URL + `addToCart`, { id: id }).then((data) => {
        alertify.success("Added to cart");

    });
}

function itemSetup() {
    if (wishList.items) {
        let objectKeys = Object.keys(wishList.items);

        objectKeys.forEach((element) => {
            items.push(wishList.items[element].item);
        });
    }
}

function removeItemFromWish(id) {
    axios
        .post(BASE_URL + "removeItemFromWish", { item_id: id })
        .then((data) => {
            alertify.error("Successfully removed!");

            setWishList([]);
        });
}
