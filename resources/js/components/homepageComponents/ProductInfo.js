import React, { useState, useEffect } from 'react';
import { BASE_URL } from '../config/Constants';

function uuidv4() {
    return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, (c) =>
        (
            c ^
            (crypto.getRandomValues(new Uint8Array(1))[0] & (15 >> (c / 4)))
        ).toString(16)
    );
}

export default function ProductInfo(props) {
    let detailLink = "./singleProductDetails/" + props.product.id;
   // const [productNameLength, setProductNameLength] = useState();
    // useEffect(() => {
    //    if(window.innerWidth > 991 && window.innerWidth <= 1366){
    //     setProductNameLength(25);
    //    }
    //    else if (window.innerWidth > 1400 &&  window.innerWidth <= 1600){
    //     setProductNameLength(35);
    //    }else if (window.innerWidth > 1601 &&  window.innerWidth <= 1920){
    //     setProductNameLength(40);
    //    }
    // }, [productNameLength])
    // console.log(props.name);
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
        $("#quickViewModalLongTitle").text(props.product.name);
        $(".item_modal_image").attr("src", props.product.thumbnail);
        $(".item_modal_image").attr("xoriginal", props.product.thumbnail);
        $("#item_modal_name").html(
            `<a href="${BASE_URL}singleProductDetails/${props.product.id}">${props.product.name}</a>`
        );
        $("#item_modal_detail").html(props.product.details);
    }

    // const productNameLength = 30;
    let productName = props.product.name;

    // if (props.product.name.length > productNameLength) {
    //     productName = props.product.name.substring(0, productNameLength) + "...";
    // } else {
    //     productName = props.product.name;
    // }

    let rating = getProductRatingJsx(props.product);
    return (
        <div className="item mb__custom">
            <article className="single_product single_productHeight">
                <figure>
                    <div className="product_thumb">
                        <a
                            className="primary_img"
                            href={
                                BASE_URL +
                                "singleProductDetails/" +
                                props.product.id
                            }

                        >
                            <img src={props.product.resized_image} alt="" id="productThumbnail" className="text-center img__pointers_none" onMouseDown={(e) => preventImageDownload(e)}/>
                        </a>
                        {/* <a
                            className="secondary_img"
                            href={
                                BASE_URL +
                                "singleProductDetails/" +
                                props.product.id
                            }
                        >
                            <img src={props.product.thumbnail} alt=""  id="secondaryThumbnail" className="text-center img__pointers_none" onMouseDown={(e) => preventImageDownload(e)}/>
                        </a> */}
                        <div className="label_product">
                            {props.product.regular_price &&
                            props.product.regular_price !=
                                props.product.sales_price ? (
                                // <span className="label_sale">
                                //     {(props.product.sales_price -
                                //         props.product.regular_price) /
                                //         100}{" "}
                                //     %
                                // </span>
                                <span className="label_sale">
                                    {
                                        Math.abs(Math.round((props.product.sales_price - props.product.regular_price) / props.product.regular_price * 100))
                                    }
                                    %
                                </span>
                            ) : null}
                        </div>
                        <div className="quick_button">
                            <a title="quick view" onClick={() => openModal()}>
                                <i className="icon-eye"></i>
                            </a>
                        </div>
                    </div>
                    <div className="product_content">
                        <div className="product_content_inner product_content_inner_two">
                            {/* <p className="manufacture_product text__truncate">
                                {props.product.category ? (
                                    <a
                                        target="_BLANK"
                                        href={
                                            BASE_URL +
                                            "shopByCategory/" +
                                            props.product.category.id
                                        }
                                    >
                                        {props.product.category.name}
                                    </a>
                                ) : (
                                    ""
                                )}


                            </p> */}
                            <p className="manufacture_product text__truncate">
                                {props.product.sub_category ? (
                                    <a  target="_BLANK" href={
                                        BASE_URL +
                                        "shopBySubCategory/" +
                                        props.product.sub_category.id
                                    } >
                                        {
                                            props.product.sub_category.name
                                        }
                                        </a>
                                ) : (
                                    ""
                                )}


                            </p>
                            <h4 className="product_name">
                                <a
                                    className="productName_overflow"
                                    target="_BLANK"
                                    href={
                                        BASE_URL +
                                        "singleProductDetails/" +
                                        props.product.id
                                    }
                                    title={props.product.name}
                                >
                                    {/* {props.product.name} */}
                                    {productName}
                                </a>
                            </h4>
                            <div className="product_rating">
                                <ul>
                                    {rating.length ? (
                                        rating
                                    ) : (
                                        <p className="rate__product rate__productIndex"><a href={ BASE_URL + "singleProductDetails/" + props.product.id }>Rate this product</a></p>
                                    )}
                                </ul>
                            </div>
                            <div className="price_box py-2">
                                <span className="old_price old_price_sm">
                                    {props.product.regular_price &&
                                    props.product.regular_price !=
                                        props.product.sales_price
                                        ? "৳" + props.product.regular_price
                                        : ""}
                                </span>

                                <span className="current_price current_price_sm pl-0">
                                   {props.product.sales_price != 0 && props.product.sales_price != null ? " ৳"+ props.product.sales_price : (<a href="tel: 01888-022244" className="price_box_price" style={{ fontSize: '12px', background: '#c70909', padding: '8px 10px', borderRadius: '5px', marginLeft: '2px', color: '#fff' }}>Call Us For Price</a>)}
                                </span>
                                {/* {props.product.sales_price ? null : (<a href="tel: 01888-022244" className="price_box_price" style={{ fontSize: '12px', background: '#c70909', padding: '8px 10px', borderRadius: '5px', marginLeft: '2px', color: '#fff' }}>Call Us For Price</a>)} */}


                            </div>
                            {/* <a title="Add to Wishlist" className="sm__wishlist">
                                <i
                                    className="icon-heart"
                                    onClick={() => {
                                        addItemToWish(props.product.id);
                                    }}
                                ></i>
                            </a> */}
                            <div className="wishlist-sm sm__mb">
                                <a
                                    className="text-white"
                                    onClick={() => {
                                        addItemToWish(props.product.id);
                                    }}
                                >
                                    <i className="icon-heart"></i>
                                </a>
                            </div>


                            <a
                                className="btn btn__cart add_to_cart mr-2"
                                onClick={() => {
                                    addItemToCart(props.product.id);
                                }}
                            >
                                {props.product.category.name == 'Book A Service' ? 'Book Now' : 'Add to Cart'}
                            </a>
                        </div>
                        <div className="action_links lg_screen_btn">
                            <ul>
                                <li
                                id={"singleProduct_" + props.product.id}
                                  key={props.product.id}
                                    className="add_to_cart"
                                    onClick={() => {
                                        addItemToCart(props.product.id);
                                    }}
                                >



                                   {props.product.category.name == 'Book A Service' ?
                                    <a title="Add to cart">Book Now</a>
                                    :
                                    <a title="Add to cart">Add to cart</a>
                                   }
                                </li>
                                <li className="wishlist pl-3">
                                    <a title="Add to Wishlist">
                                        <i
                                            className="icon-heart"
                                            onClick={() => {
                                                addItemToWish(props.product.id);
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



function addItemToWish(id){
    axios.post(BASE_URL + `addToWish`, { id: id }).then(data => {
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
