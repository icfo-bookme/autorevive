import React, { Component } from "react";
import { BASE_URL } from "../config/Constants";

let ratingValue = 0;

function addItemToCart(id) {
    axios.post(`${BASE_URL}addToCart`, { id: id }).then(data => {
        alertify.success("Added to cart");
    });
}

function itemSetup() {
    if (wishList.items) {
        let objectKeys = Object.keys(wishList.items);

        objectKeys.forEach(element => {
            items.push(wishList.items[element].item);
        });
    }
}

function removeItemFromWish(id) {
    axios.post(BASE_URL + "removeItemFromWish", { item_id: id }).then(data => {
        alertify.error("Successfully removed!");

        setWishList([]);
    });
}

export default function ProductDetails(props) {
    let [reviews, setReviews] = React.useState([]);
    const [changeImgUrl, setChangeImgUrl] = React.useState();
    let rating_counter = 0;

    // let [count, setCount] = React.useState(0);

    // get reviews of present item
    axios
        .post(BASE_URL + "getItemRatingAjax", {
            item_id: location.pathname.split("/")[2]
        })
        .then(({ data }) => {
            if (JSON.stringify(reviews) != JSON.stringify(data)) {
                setReviews(data);
            }
        });

    function setRating(value) {
        ratingValue = value;
    }

    function insertItemRating() {
        //let itemId = location.pathname.split("/")[4];
        let itemId = location.href.split("/")[4];
        // let rating = document.getElementById("product_rating").value;
        let review_comment = document.getElementById("review_comment").value;
        let author = document.getElementById("author").value;
        let email = document.getElementById("emailInput").value;
        if (review_comment == "" || author == "" || email == "") {
            alertify.error("please input all the fields");
        } else {
            axios
                .post(BASE_URL + "insertItemRatingAjax", {
                    item_id: itemId,
                    review: review_comment,
                    name: author,
                    email: email,
                    ratingValue: ratingValue
                })
                .then(({ data }) => {
                    setReviews([]);
                    document.getElementById("reviewForm").reset();
                    //    setCount(count + 1);
                    alertify.success(data);
                    ratingValue = 0;
                    // setTimeout(() => location.reload(), 300);
                });
        }
    }

    function getProductRatingJsx(product) {
        let totalRating = 0;
        let rating = [];

        if (product.rating) {
            product.rating.map(r => (totalRating += r.rating));
            let ratingAverage = Math.ceil(totalRating / product.rating.length);

            for (let i = 0; i < ratingAverage; i++) {
                rating_counter += 1;

                rating.push(
                    <li key={"rating_" + rating_counter}>
                        <a>
                            <i
                                className="fa fa-star"
                                style={{ color: "#ffc600" }}
                            ></i>
                        </a>
                    </li>
                );
            }
            return rating;
        } else {
            return false;
        }
    }
    if (props.productDetail) {
        let rating = getProductRatingJsx(props.productDetail);
        let productSalePrice = props.productDetail.sales_price;
        return (
            <div className="product_page_bg">
                <div className="container">
                    <div className="product_details">
                        <div className="row">
                            <div className="col-lg-5 col-md-6">
                                <div className="product-details-tab">
                                    <div
                                        id="bigImageZoom"
                                        className="d-flex justify-content-center"
                                    >
                                        <a href="#">
                                            <img
                                                id="xzoom-default"
                                                src={
                                                    props.productDetail
                                                        .thumbnail &&
                                                    !changeImgUrl
                                                        ? BASE_URL +
                                                          props.productDetail
                                                              .thumbnail
                                                        : BASE_URL +
                                                          changeImgUrl
                                                }
                                                data-zoom-image={
                                                    props.productDetail
                                                        .thumbnail &&
                                                    !changeImgUrl
                                                        ? BASE_URL +
                                                          props.productDetail
                                                              .thumbnail
                                                        : BASE_URL +
                                                          changeImgUrl
                                                }
                                                alt="big-1"
                                                className="img-fluid bigImage"
                                                xoriginal={
                                                    props.productDetail
                                                        .thumbnail &&
                                                    !changeImgUrl
                                                        ? BASE_URL +
                                                          props.productDetail
                                                              .thumbnail
                                                        : BASE_URL +
                                                          changeImgUrl
                                                }
                                            />
                                        </a>
                                    </div>
                                </div>

                                <div className="row">
                                    <div className="col-4 col-md-3 mt-3">
                                        <img
                                            className="productDetailsImg"
                                            src={
                                                props.productDetail.thumbnail
                                                    ? BASE_URL +
                                                      props.productDetail
                                                          .thumbnail
                                                    : ""
                                            }
                                            alt=""
                                            onClick={() =>
                                                setChangeImgUrl(
                                                    props.productDetail
                                                        .thumbnail
                                                )
                                            }
                                        />
                                    </div>
                                    {props.productDetail
                                        ? props.productDetail.item_images
                                            ? props.productDetail.item_images.map(
                                                  spec => (
                                                      <div
                                                          className="col-4 col-md-3 mt-3"
                                                          key={spec.id}
                                                      >
                                                          <img
                                                              className="productDetailsImg"
                                                              src={
                                                                  spec.image_path
                                                                      ? BASE_URL +
                                                                        spec.image_path
                                                                      : ""
                                                              }
                                                              data-zoom-image={
                                                                  spec.image_path
                                                                      ? BASE_URL +
                                                                        spec.image_path
                                                                      : ""
                                                              }
                                                              alt="big-1"
                                                              onClick={() =>
                                                                  setChangeImgUrl(
                                                                      spec.image_path
                                                                  )
                                                              }
                                                          />
                                                      </div>
                                                  )
                                              )
                                            : null
                                        : null}
                                </div>
                            </div>

                            <div className="col-lg-7 col-md-6">
                                <div className="product_d_right">
                                    <form action="#">
                                        <h3>
                                            <a href={location.href}>
                                                {props.productDetail.name
                                                    ? props.productDetail.name
                                                    : ""}
                                            </a>
                                        </h3>
                                        <div className="product_rating">
                                            <ul>
                                                {rating ? rating : ""}
                                                <li className="review">
                                                    <a href="#reviews">
                                                        ({reviews.length}{" "}
                                                        customer review )
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div className="price_box">
                                            {props.productDetail
                                                .regular_price ? (
                                                props.productDetail
                                                    .sales_price !=
                                                props.productDetail
                                                    .regular_price ? (
                                                    <span className="old_price productDetails__sm">
                                                        {props.productDetail
                                                            .regular_price
                                                            ? `৳ ${props.productDetail.regular_price}`
                                                            : ""}
                                                    </span>
                                                ) : (
                                                    ""
                                                )
                                            ) : (
                                                ""
                                            )}
                                            <span className="current_price productDetails__sm">
                                                {productSalePrice != 0 &&
                                                productSalePrice != 0.0 &&
                                                productSalePrice != null &&
                                                productSalePrice !=
                                                    undefined ? (
                                                    `৳ ${productSalePrice}`
                                                ) : (
                                                    <a
                                                        href="tel: 01888-022244"
                                                        className="price_box_price"
                                                        style={{
                                                            fontSize: "12px",
                                                            background:
                                                                "#c70909",
                                                            padding: "8px 10px",
                                                            borderRadius: "5px",
                                                            marginLeft: "2px",
                                                            color: "#fff"
                                                        }}
                                                    >
                                                        Call Us For Price
                                                    </a>
                                                )}
                                            </span>

                                            {/* {props.productDetail
                                                .sales_price ? null : (
                                                <a
                                                    href="tel: 01888-022244"
                                                    className="price_box_price"
                                                    style={{
                                                        fontSize: "12px",
                                                        background: "#c70909",
                                                        padding: "8px 10px",
                                                        borderRadius: "5px",
                                                        marginLeft: "2px",
                                                        color: "#fff"
                                                    }}
                                                >
                                                    Call Us For Price
                                                </a>
                                            )} */}
                                        </div>
                                        <div
                                            className="product_desc"
                                            dangerouslySetInnerHTML={{
                                                __html: `${
                                                    props.productDetail.details
                                                        ? props.productDetail
                                                              .details
                                                        : ""
                                                }`
                                            }}
                                        ></div>
                                        <div className="product_variant quantity">
                                            <button
                                                className="button"
                                                type="button"
                                                onClick={() =>
                                                    addItemToCart(
                                                        props.productDetail.id
                                                    )
                                                }
                                            >
                                                add to cart
                                            </button>
                                        </div>
                                        <div className="product_meta">
                                            {props.productDetail.category ? (
                                                <span>
                                                    Category:
                                                    <a
                                                        href={
                                                            BASE_URL +
                                                            "shopByCategory/" +
                                                            props.productDetail
                                                                .category.id
                                                        }
                                                    >
                                                        {
                                                            props.productDetail
                                                                .category.name
                                                        }
                                                    </a>
                                                </span>
                                            ) : (
                                                ""
                                            )}
                                        </div>
                                    </form>
                                    {/* <div className="priduct_social">
                                        <ul>
                                            <li>
                                                <a
                                                    className="facebook"
                                                    href="https://www.facebook.com/automaxbdltd/"
                                                    target="_blank"
                                                    title="facebook"
                                                >
                                                    <i className="fa fa-facebook"></i>
                                                    Like
                                                </a>
                                            </li>
                                            <li>
                                                <a
                                                    className="twitter"
                                                    href="#"
                                                    title="twitter"
                                                >
                                                    <i className="fa fa-twitter"></i>{" "}
                                                    tweet
                                                </a>
                                            </li>
                                            <li>
                                                <a
                                                    className="pinterest"
                                                    href="#"
                                                    title="pinterest"
                                                >
                                                    <i className="fa fa-pinterest"></i>
                                                    save
                                                </a>
                                            </li>
                                            <li>
                                                <a
                                                    className="google-plus"
                                                    href="#"
                                                    title="google +"
                                                >
                                                    <i className="fa fa-google-plus"></i>
                                                    share
                                                </a>
                                            </li>
                                            <li>
                                                <a
                                                    className="linkedin"
                                                    href="#"
                                                    title="linkedin"
                                                >
                                                    <i className="fa fa-linkedin"></i>
                                                    linked
                                                </a>
                                            </li>
                                        </ul>
                                    </div> */}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="product_d_info">
                        <div className="row">
                            <div className="col-12">
                                <div className="product_d_inner">
                                    <div className="product_info_button">
                                        <ul className="nav" role="tablist">
                                            <li>
                                                <a
                                                    className="active"
                                                    data-toggle="tab"
                                                    href="#info"
                                                    role="tab"
                                                    aria-controls="info"
                                                    aria-selected="false"
                                                >
                                                    Description
                                                </a>
                                            </li>
                                            <li>
                                                <a
                                                    data-toggle="tab"
                                                    href="#sheet"
                                                    role="tab"
                                                    aria-controls="sheet"
                                                    aria-selected="false"
                                                >
                                                    Specification
                                                </a>
                                            </li>
                                            <li>
                                                <a
                                                    data-toggle="tab"
                                                    href="#reviews"
                                                    role="tab"
                                                    aria-controls="reviews"
                                                    aria-selected="false"
                                                >
                                                    Reviews ({reviews.length})
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div className="tab-content">
                                        <div
                                            className="tab-pane fade show active"
                                            id="info"
                                            role="tabpanel"
                                        >
                                            <div
                                                className="product_info_content"
                                                dangerouslySetInnerHTML={{
                                                    __html: `${
                                                        props.productDetail
                                                            .details
                                                            ? props
                                                                  .productDetail
                                                                  .details
                                                            : ""
                                                    }`
                                                }}
                                            >
                                                {/* <p>
                                                    {props.productDetail.details
                                                        ? props.productDetail
                                                              .details
                                                        : ""}
                                                </p> */}
                                            </div>
                                        </div>
                                        <div
                                            className="tab-pane fade"
                                            id="sheet"
                                            role="tabpanel"
                                        >
                                            <div className="product_d_table">
                                                <form action="#">
                                                    <table>
                                                        <tbody>
                                                            {props.productDetail
                                                                .item_specification ? (
                                                                props.productDetail.item_specification.map(
                                                                    spec => (
                                                                        <tr
                                                                            key={
                                                                                spec.id
                                                                            }
                                                                        >
                                                                            <td className="first_child">
                                                                                {
                                                                                    spec.name
                                                                                }
                                                                            </td>
                                                                            <td>
                                                                                {
                                                                                    spec.details
                                                                                }
                                                                            </td>
                                                                        </tr>
                                                                    )
                                                                )
                                                            ) : (
                                                                <></>
                                                            )}
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                            <div className="product_info_content">
                                                <p>
                                                    {props.productDetail
                                                        .specification_details
                                                        ? props.productDetail
                                                              .specification_details
                                                        : ""}
                                                </p>
                                            </div>
                                        </div>

                                        <div
                                            className="tab-pane fade"
                                            id="reviews"
                                            role="tabpanel"
                                        >
                                            <div className="reviews_wrapper">
                                                <h2>
                                                    {reviews.length} review for{" "}
                                                    {props.productDetail.name}
                                                </h2>
                                                <div className="reviews_comment_box">
                                                    <div className="comment_thmb">
                                                        <img
                                                            src={
                                                                props
                                                                    .productDetail
                                                                    .thumbnail
                                                                    ? BASE_URL +
                                                                      props
                                                                          .productDetail
                                                                          .thumbnail
                                                                    : ""
                                                            }
                                                            alt=""
                                                            className="comment_thmb_img"
                                                        />
                                                    </div>
                                                    {reviews.length != 0 ? (
                                                        <div className="comment_text">
                                                            {reviews.map(
                                                                review => {
                                                                    let count = 0;
                                                                    count += 1;
                                                                    let reviewCount = 0;
                                                                    let jsxDataRating = [];
                                                                    while (
                                                                        reviewCount <
                                                                        review.rating
                                                                    ) {
                                                                        jsxDataRating.push(
                                                                            <li
                                                                                key={
                                                                                    reviewCount
                                                                                }
                                                                            >
                                                                                <a>
                                                                                    <i className="fa fa-star"></i>
                                                                                </a>{" "}
                                                                            </li>
                                                                        );
                                                                        reviewCount++;
                                                                    }
                                                                    return (
                                                                        <div>
                                                                            <div
                                                                                className="reviews_meta bg-light p-3 mb-2"
                                                                                key={
                                                                                    count
                                                                                }
                                                                                style={{
                                                                                    borderRadius:
                                                                                        "25px"
                                                                                }}
                                                                            >
                                                                                <div className="product_rating">
                                                                                    <ul>
                                                                                        {
                                                                                            jsxDataRating
                                                                                        }
                                                                                    </ul>
                                                                                </div>
                                                                                <h3
                                                                                    className="mb-0 text-capitalize"
                                                                                    style={{
                                                                                        fontSize:
                                                                                            "16px",
                                                                                        fontWeight:
                                                                                            "500"
                                                                                    }}
                                                                                >
                                                                                    {
                                                                                        review.name
                                                                                    }
                                                                                </h3>
                                                                                <small
                                                                                    className="mb-0"
                                                                                    style={{
                                                                                        fontSize:
                                                                                            "12px",
                                                                                        display:
                                                                                            "block"
                                                                                    }}
                                                                                >
                                                                                    {
                                                                                        review.created_at
                                                                                    }
                                                                                </small>
                                                                                <span>
                                                                                    {
                                                                                        review.review
                                                                                    }
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    );
                                                                }
                                                            )}
                                                        </div>
                                                    ) : (
                                                        ""
                                                    )}
                                                </div>
                                                <div className="comment_title">
                                                    <h2>Add a review </h2>
                                                    <p>
                                                        Your email address will
                                                        not be published.
                                                    </p>
                                                </div>

                                                <input
                                                    type="hidden"
                                                    id="product_rating"
                                                    value={
                                                        props.productDetail.id
                                                            ? props
                                                                  .productDetail
                                                                  .id
                                                            : ""
                                                    }
                                                />
                                                <div
                                                    // id="product_rating"
                                                    className="product_rating mb-10"
                                                >
                                                    <h3>Your rating</h3>
                                                    <div
                                                        className="rating"
                                                        style={{
                                                            display:
                                                                "inline-block"
                                                        }}
                                                    >
                                                        <input
                                                            type="radio"
                                                            onClick={() =>
                                                                setRating(5)
                                                            }
                                                            value="5"
                                                            name="rating"
                                                            id="rating-5"
                                                        />
                                                        <label
                                                            htmlFor="rating-5"
                                                            title="5 stars"
                                                        >
                                                            <i className="fa fa-star"></i>
                                                        </label>
                                                        <input
                                                            type="radio"
                                                            onClick={() =>
                                                                setRating(4)
                                                            }
                                                            value="4"
                                                            name="rating"
                                                            id="rating-4"
                                                        />
                                                        <label
                                                            htmlFor="rating-4"
                                                            title="4 stars"
                                                        >
                                                            <i className="fa fa-star"></i>
                                                        </label>
                                                        <input
                                                            type="radio"
                                                            onClick={() =>
                                                                setRating(3)
                                                            }
                                                            value="3"
                                                            name="rating"
                                                            id="rating-3"
                                                        />
                                                        <label
                                                            htmlFor="rating-3"
                                                            title="3 stars"
                                                        >
                                                            <i className="fa fa-star"></i>
                                                        </label>
                                                        <input
                                                            type="radio"
                                                            onClick={() =>
                                                                setRating(2)
                                                            }
                                                            value="2"
                                                            name="rating"
                                                            id="rating-2"
                                                        />
                                                        <label
                                                            htmlFor="rating-2"
                                                            title="2 stars"
                                                        >
                                                            <i className="fa fa-star"></i>
                                                        </label>
                                                        <input
                                                            type="radio"
                                                            onClick={() =>
                                                                setRating(1)
                                                            }
                                                            value="1"
                                                            name="rating"
                                                            id="rating-1"
                                                        />
                                                        <label
                                                            htmlFor="rating-1"
                                                            title="1 star"
                                                        >
                                                            <i className="fa fa-star"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div className="product_review_form">
                                                    <form
                                                        id="reviewForm"
                                                        action="#"
                                                    >
                                                        <div className="row">
                                                            <div className="col-12">
                                                                <label htmlFor="review_comment">
                                                                    Your review
                                                                </label>
                                                                <textarea
                                                                    name="comment"
                                                                    id="review_comment"
                                                                ></textarea>
                                                            </div>
                                                            <div className="col-lg-6 col-md-6">
                                                                <label htmlFor="author">
                                                                    Name
                                                                </label>
                                                                <input
                                                                    id="author"
                                                                    type="text"
                                                                />
                                                            </div>
                                                            <div className="col-lg-6 col-md-6">
                                                                <label htmlFor="email">
                                                                    Email{" "}
                                                                </label>
                                                                <input
                                                                    id="emailInput"
                                                                    type="email"
                                                                />
                                                            </div>
                                                        </div>
                                                        <button
                                                            type="button"
                                                            onClick={
                                                                insertItemRating
                                                            }
                                                        >
                                                            Submit
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    } else {
        return <div>NOTHING TO DISPLAY</div>;
    }
}
