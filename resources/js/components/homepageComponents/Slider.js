import React from "react";
import { BASE_URL, CSRF_TOKEN } from "../config/Constants";

function openModal (message) {
    // alert(message);
    document.getElementById('free_delivery').innerHTML = message;
    $('#shippingModal').modal('show');
}
const messageList = {
    messageOne: "<h3 class='text-center'>Free Delivery</h3><p>Enjoy free shipping promotion with minimum spend of ৳3000 in certain area for exclusive parts. For orders under ৳3000 we offer ground shipping for flat fee of ৳60. Free return are provided on all exclusive orders.</p>",
    messageTwo: "<h3 class='text-center'>Payment Method</h3><p><b>Credit & Debit Card:</b> Pay securely with your card & save your card details to enjoy smooth payments on your next purchase.</p><p><b>Pay With Your bKash:</b> A smarter way to pay with bKash online payment and a faster checkout experience.</p><p><b>Cash On Delivery:</b> We provide Cash-on-Delivery all over Bangladesh at a very cheap price.</p>",
    messageThree: "<h3 class='text-center'>Return Policy</h3><p class='mb-0'>1. The product must be exact in the same condition and must include the original tags</p> <p>2. 500% money back guarantee if you get fake products on purchase</p>",
    messageFour: "<h3 class='text-center'>Hotline</h3><p>Your friendly chat assistant <a href='https://m.me/automaxbdltd' class='text-danger'>Live Chat</a> services are available daily 9:00 AM – 10:00 PM (Saturday to Friday). Feel free to call us for any products query and other details, <a href='tel: 01888022244' class='text-danger'>Call: 01888022244</a></p>"

}

export default function Slider() {

    return (
        <section className="slider_section">

            <div className="slider_area slider_carousel owl-carousel">
            <div
                    className="single_slider d-flex align-items-center single_slider__one"
                    data-bgimg="mazley_assets/img/slider/slider06.jpg"
                >
                    <div className="container">
                        <div className="row">
                            <div className="col-12">
                                <div className="slider_content">
                                    <h1 className="layer mb-4">
                                        Your One Stop Shop To Buy
                                        <br />
                                        <span className="custom__text__color">necessary interior parts</span>{" "}
                                    </h1>

                                    <a className="button" href="./shopview">
                                        Shop now{" "}
                                        <i
                                            className="fa fa-angle-double-right"
                                            aria-hidden="true"
                                        ></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    className="single_slider d-flex align-items-center single_slider__three"
                    data-bgimg="mazley_assets/img/slider/slider05.jpg"
                >
                     <div className="overlay__black"></div>
                    <div className="container">
                        <div className="row">
                            <div className="col-12">
                                <div className="slider_content">
                                    <h1 className="layer mb-4">
                                        Modify Your Car
                                        <br />
                                        <span className="custom__text__color">With Us</span>{" "}
                                    </h1>

                                    <a className="button" href="./shopview">
                                        Shop now{" "}
                                        <i
                                            className="fa fa-angle-double-right"
                                            aria-hidden="true"
                                        ></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    className="single_slider d-flex align-items-center single_slider__one"
                    data-bgimg="mazley_assets/img/slider/slider2.jpg"
                >
                    
                    <div className="container">
                        <div className="row">
                            <div className="col-12">
                                <div className="slider_content">
                                    <h1 className="layer">
                                        GET FLOOR MATS{" "}
                                        <span className="custom__text__color">TREAT YOUR FEET</span>
                                    </h1>
                                    <br />
                                    {/* <p>We'll get you in and out the door as quickly as possible.</p> */}
                                    <a className="button" href="./shopview">
                                        Shop now{" "}
                                        <i
                                            className="fa fa-angle-double-right"
                                            aria-hidden="true"
                                        ></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    className="single_slider d-flex align-items-center single_slider__one"
                    data-bgimg="mazley_assets/img/slider/slider09.jpg"
                >
                    <div className="container">
                        <div className="row">
                            <div className="col-12">
                                <div className="slider_content">
                                    <h1 className="layer mb-4">
                                        Create Fashion
                                        <br />
                                        <span className="custom__text__color">Car Seat Cover <br />Enjoy The Exquisite Life</span>{" "}
                                    </h1>

                                    <a className="button" href="./shopview">
                                        Shop now{" "}
                                        <i
                                            className="fa fa-angle-double-right"
                                            aria-hidden="true"
                                        ></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    className="single_slider d-flex align-items-center single_slider__one"
                    data-bgimg="mazley_assets/img/slider/slider5.jpg"
                >
                    <div className="overlay__black"></div>
                    <div className="container">
                    
                        <div className="row">
                            <div className="col-12">
                                <div className="slider_content">
                                    <h1
                                        className="layer mb-3">
                                        Largest Automobiles{" "}
                                        <span className="custom__text__color">
                                            Parts & Accessories <br />
                                            Platform in Bangladesh
                                        </span>
                                    </h1>
                                    <a className="button" href="./shopview">
                                        Shop now{" "}
                                        <i
                                            className="fa fa-angle-double-right"
                                            aria-hidden="true"
                                        ></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                {/* <div
                    className="single_slider d-flex align-items-center"
                    data-bgimg="mazley_assets/img/slider/slider3.jpg"
                >
                    <div className="container">
                        <div className="row">
                            <div className="col-12">
                                <div className="slider_content">
                                    <h1 className="layer mb-4">
                                        Get Genuine Car Engine
                                        <br />
                                        <span>From Authorized Dealer</span>{" "}
                                    </h1>

                                    <a className="button" href="./shopview">
                                        Shop now{" "}
                                        <i
                                            className="fa fa-angle-double-right"
                                            aria-hidden="true"
                                        ></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> */}
                
                
            </div>

            <div className="shipping_area shipping_three mt-75 mb-75">
                <div className="container">
                    <div className="shipping_inner">
                        <div
                            className="single_shipping mb-2"
                            onClick={() => openModal(messageList.messageOne)}
                            style={{cursor: 'pointer'}}
                        >
                            <div className="shipping_icone">
                                <img
                                    src="mazley_assets/img/about/shipping6.png"
                                    alt=""
                                />
                            </div>
                            <div className="shipping_content">
                                <h4>Free Delivery</h4> 
                                <p>
                                    Enjoy free shipping for all orders over ৳3000
                                </p>
                            </div>
                        </div>
                        <div className="single_shipping mb-2" onClick={() => openModal(messageList.messageTwo)} style={{cursor: 'pointer'}}>
                            <div className="shipping_icone">
                                <img
                                    src="mazley_assets/img/about/shipping7.png"
                                    alt=""
                                />
                            </div>
                            <div className="shipping_content">
                                <h4>Payment Method</h4>
                                <p>
                                    Pay using your credit card for any purchase
                                </p>
                            </div>
                        </div>
                        <div className="single_shipping mb-2" onClick={() => openModal(messageList.messageThree)} style={{cursor: 'pointer'}}>
                            <div className="shipping_icone pl__two">
                                <img
                                    src="mazley_assets/img/about/shipping8.png"
                                    alt=""
                                />
                            </div>
                            <div className="shipping_content">
                                <h4>Return Policy</h4>
                                <p>
                                    We believe in making your experience quick
                                    and simple
                                </p>
                            </div>
                        </div>
                        <div className="single_shipping mb-2" onClick={() => openModal(messageList.messageFour)} style={{cursor: 'pointer'}}>
                            <div className="shipping_icone pl__two">
                                <img
                                    src="mazley_assets/img/about/shipping9.png"
                                    alt=""
                                />
                            </div>
                            <div className="shipping_content">
                                <h4>Hotline</h4>
                                <p>
                                    Ask any question you have & get instant
                                    answer
                                </p>
                            </div>
                        </div>

                        <div
                            className="modal fade"
                            id="shippingModal"
                            tabIndex="-1"
                            role="dialog"
                            aria-labelledby="shippingModalLabel"
                            aria-hidden="true"
                        >
                            <div className="modal-dialog modal-dialog-centered" role="document" style={{minWidth: '250px'}}>
                                <div className="modal-content" style={{borderRadius: '25px'}}>
                                    <div className="modal-header p-0" style={{border: 'none'}}>
                                        <button
                                            type="button"
                                            className="close__btn"
                                            data-dismiss="modal"
                                            aria-label="Close"
                                            style={{left: '95%'}}
                                        >
                                            <span aria-hidden="true">
                                                &times;
                                            </span>
                                        </button>
                                    </div>
                                    <div className="modal-body px-3 py-3" >
                                       <div id="free_delivery" style={{color: '#333'}}>

                                       </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {/* <div className="banner_area mb-80">
                <div className="container">
                <div className="row">
                    <div className="col-12">
                        <div className="welcome_title">
                            <h3>WELCOME TO Automax</h3>
                            <h2>CUSTOM <span>SHOPPING STORE ONLINE</span></h2>
                        </div>
                    </div>
                </div>
                    <div className="row">
                        <div className="col-lg-4 col-md-4">
                            <figure className="single_banner">
                                <div className="banner_thumb">
                                    <a href={BASE_URL + "shopview"}><img src= {BASE_URL + 'mazley_assets/img/bg/banner1.jpg'} alt=""/></a>
                                </div>
                            </figure>
                        </div>
                        <div className="col-lg-4 col-md-4">
                            <figure className="single_banner">
                                <div className="banner_thumb">
                                    <a href={BASE_URL + "shopview"}><img src= {BASE_URL + 'mazley_assets/img/bg/banner2.jpg'} alt=""/></a>
                                </div>
                            </figure>
                        </div>
                        <div className="col-lg-4 col-md-4">
                            <figure className="single_banner">
                                <div className="banner_thumb">
                                    <a href={BASE_URL + "shopview"}><img src= {BASE_URL + 'mazley_assets/img/bg/banner3.jpg'} alt=""/></a>
                                </div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div> */}
        </section>
    );
}
