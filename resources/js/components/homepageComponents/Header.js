import React, { Component, Fragment } from "react";
import CategoryList from "./CategoryList";
import CartContainer from "./CartContainer";
import MainnavCategories from "./MainnavCategories";
import { BASE_URL, CSRF_TOKEN } from "../config/Constants";
import WishlistContainer from "./WishlistContainer";
import ChangePasswordModal from "./ChangePasswordModal";
import UserDetailModal from "../MyaccountComponents/UserDetailModal";

export default class Header extends Component {
    constructor(props) {
        super(props);
        this.state = {
            error: null,
            count: true,
            total: 0,
            isLoaded: false,
            cart: [],
            wish: [],
            totalWish: 0,
            categories: [],
            isLoggedIn: 0,
            selectedCategoryId: this.getCategoryFromUrl(),
            searchInput: undefined,
            showAllCategory: false,
            showSubCategory: false,
            categoryVisible: false
        };

        this.doLogOut = this.doLogOut.bind(this);
        this.login = this.login.bind(this);
        this.catProdutSearch = this.catProdutSearch.bind(this);
        this.catProductSearchByEnter = this.catProductSearchByEnter.bind(this);
        this.catProdutSearchMobile = this.catProdutSearchMobile.bind(this);
        this.requestProduct = this.requestProduct.bind(this);
        this.handleMyAccount = this.handleMyAccount.bind(this);
        this.userLoggedIn = this.userLoggedIn.bind(this);
        this.handleCategorySelect = this.handleCategorySelect.bind(this);
        this.handleSearchInput = this.handleSearchInput.bind(this);
        this.getCategoryFromUrl = this.getCategoryFromUrl.bind(this);
        this.getUserDetails = this.getUserDetails.bind(this);

        this.loggedInJsx = (
            <a
                style={{ color: "#000" }}
                onClick={() => {
                    logOut();
                }}
                data-a="0"
            >
                Logout
            </a>
        );

        this.topLoggedInJsx = undefined;
    }

    componentWillUnmount() {
        clearInterval(this.interval);
    }

    componentDidMount() {
        let select_option = document.getElementById("select_category");
        let parentThis = this;

        let token = document.head.querySelector('meta[name="csrf-token"]');
        const headers = new Headers({
            "Content-Type": "x-www-form-urlencoded",
            "X-CSRF-TOKEN": token.content
        });

        let isLoggedIn = Number(document.getElementById("logged").value);
        if (this.state.isLoggedIn != isLoggedIn) {
            this.setState({ isLoggedIn: isLoggedIn });
        }

        function logOut() {
            axios
                .post(
                    BASE_URL + "logout",
                    {},
                    {
                        headers: headers
                    }
                )
                .then(data => {
                    parentThis.setState({ isLoggedIn: 0 });
                })
                .catch(err => {
                    console.error(err);
                });
        }

        function categoryRedirect(id) {
            window.open("./shopByCat/" + id);
        }

        axios.post(BASE_URL + "categories").then(res => {
            this.setState({ categories: res.data });
        });

        axios.post(BASE_URL + "getSidecartReactData").then(({ data }) => {
            if (data.cart) {
                parentThis.setState({ cart: data });
                if (data.cart) {
                    parentThis.setState({ total: data.cart.totalQty });
                }
            }
        });

        axios.post(BASE_URL + "getWishReactData").then(({ data }) => {
            if (data.wish) {
                parentThis.setState({ wish: data });
            }
        });

        let refresh = () => {
            axios.post(BASE_URL + "getSidecartReactData").then(({ data }) => {
                parentThis.setState({ cart: data });
                if (data.cart) {
                    parentThis.setState({ total: data.cart.totalQty });
                }
            });

            axios.post(BASE_URL + "getWishReactData").then(({ data }) => {
                if (data.wish) {
                    parentThis.setState({ wish: data });
                } else {
                    parentThis.setState({ wish: {} });
                }
            });
        };

        setInterval(() => refresh(), 1000);
    }

    login(e) {
        e.preventDefault();

        let isValid = true;
        let min_password_length = 8;
        let errors = { email: "", password: "" };
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;
        let login_token = document.getElementById("login_token").value;

        if (typeof email !== "undefined") {
            let pattern = new RegExp(
                /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i
            );
            if (!pattern.test(email)) {
                isValid = false;
                errors["email"] = "Invalid Email";
            }
        }

        if (typeof password !== "undefined") {
            if (password.length < min_password_length) {
                isValid = false;
                errors["password"] = "Invalid Password";
            }
        }

        if (!isValid) {
            Object.keys(errors).map(err => {
                if (errors[err].length > 0) {
                    alertify.error(errors[err]);
                }
            });
        } else {
            axios
                .post(BASE_URL + "login", {
                    email: email,
                    password: password,
                    _token: login_token
                })
                .then(data => {
                    if (data.status >= 400) {
                        alertify.error("Email or Password is wrong!");
                    } else {
                        if (
                            data.headers["content-type"] ==
                            "text/html; charset=UTF-8"
                        ) {
                            history.go(0);
                            this.props.doRerender();
                        }
                    }
                })
                .catch(err => {
                    if (err.response) {
                        alertify.error(err.response.data.message);
                    }
                });
        }
    }

    doLogOut() {
        let token = document.head.querySelector('meta[name="csrf-token"]');
        let headersData = new Headers({
            "Content-Type": "x-www-form-urlencoded",
            "X-CSRF-TOKEN": token.content
        });
        axios
            .post(
                BASE_URL + "logout",
                {},
                {
                    headers: headersData
                }
            )
            .then(data => {
                this.setState({ isLoggedIn: 0 });
                history.go(0);
            })
            .catch(err => {
                console.error(err);
            });
    }

    handleSearchInput(e) {
        this.setState({ searchInput: e.target.value });
    }

    handleCategorySelect(e) {
        this.setState({ selectedCategoryId: e.target.value });
    }

    catProdutSearch() {
        let slug = document.getElementById("searchPost").value;
        let category_id = document.getElementById("select_category").value;
        location.href = `${BASE_URL}shopview?catId=${category_id}&slug=${slug}`;
    }

    catProductSearchByEnter(e) {
        if (e.key === "Enter" || e.keyCode === 13) {
            let slug = document.getElementById("searchPost").value;
            let category_id = document.getElementById("select_category").value;
            location.href = `${BASE_URL}shopview?catId=${category_id}&slug=${slug}`;
        }
    }

    catProdutSearchMobile() {
        let slug = this.state.searchInput ? this.state.searchInput : "";
        let category_id = this.state.selectedCategoryId
            ? this.state.selectedCategoryId
            : "";

        if (this.state.selectedCategoryId || this.state.searchInput) {
            location.href = `${BASE_URL}shopview?catId=${category_id}&slug=${slug}`;
        } else {
            location.href = `${BASE_URL}shopview?catId=${category_id}&slug=${slug}`;
        }
    }

    getCategoryFromUrl() {
        let query_cat_key = undefined;
        let query_cat_val = undefined;

        let getKeyValByIndex = index => {
            query_cat_key = location.search
                .split("&")
                [index].replace("?", "")
                .split("=")[0];

            query_cat_val = location.search
                .split("&")
                [index].replace("?", "")
                .split("=")[1];
        };

        // if it is search result page
        if (location.search.split("&").length > 1) {
            location.search
                .split("&")[0]
                .replace("?", "")
                .split("=")[0] == "catId"
                ? getKeyValByIndex(0)
                : location.search
                      .split("&")[1]
                      .replace("?", "")
                      .split("=")[0] == "catId"
                ? getKeyValByIndex(1)
                : "";

            if (query_cat_key === "catId") {
                return query_cat_val;
            }
        }
        return "";
    }

    requestProduct() {
        // let req_user_name = document.getElementById("req_user_name").value;
        // let req_user_phone = document.getElementById("req_user_phone").value;
        // let req_user_email = document.getElementById("req_user_email").value;
        // let req_product_detail = document.getElementById("req_product_detail").value;
        let product_detail = document.getElementById("req_product_detail")
            .value;
        let user_name = document.getElementById("req_user_name").value;
        let user_phone = document.getElementById("req_user_phone").value;
        let user_email = document.getElementById("req_user_email").value;
        let mailformat = /^[A-Za-z0-9._]*\@[A-Za-z]*\.[A-Za-z]{2,5}$/;
        let phoneno = /^(01)[0-9]{9}$/;

        var formData = new FormData($("#requestDetailsForm")[0]);
        let token = document.head.querySelector('meta[name="csrf-token"]');

        if (user_name === "") {
            alertify.error("Please enter name");
        } else if (user_email !== "" && !mailformat.test(user_email)) {
            alertify.error("Please enter valid email");
        } else if (!phoneno.test(user_phone)) {
            alertify.error("Please enter valid phone");
        } else if (product_detail === "") {
            alertify.error("Please enter product details");
        } else {
            axios
                .post(BASE_URL + "admin/requestInsertAjax", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                        "X-CSRF-TOKEN": token.content
                    }
                })
                .then(({ data }) => {
                    if (data == "Success") {
                        alertify.success(data);
                        setTimeout(function() {
                            document.getElementById("req_user_name").value = "";
                            document.getElementById("req_user_phone").value =
                                "";
                            document.getElementById("req_user_email").value =
                                "";
                            document.getElementById(
                                "req_product_detail"
                            ).value = "";
                            $("#exampleModal").modal("hide");
                            $(".modal-backdrop").hide();
                            location.reload();
                        }, 2000);
                    } else {
                        alertify.error("please input all the fields");
                    }
                });
        }

        // axios
        //     .post(BASE_URL + "admin/requestInsertAjax", {
        //         user_name: req_user_name,
        //         user_phone: req_user_phone,
        //         user_email: req_user_email,
        //         product_detail: req_product_detail,
        //     })
        //     .then(({ data }) => {
        //         if (data == "Success") {
        //             alertify.success(data);
        //             document.getElementById("req_user_name").value = "";
        //             document.getElementById("req_user_phone").value = "";
        //             document.getElementById("req_user_email").value = "";
        //             document.getElementById("req_product_detail").value = "";
        //             $("#exampleModal").modal("hide");
        //             $('.modal-backdrop').hide()
        //         }
        //     });
    }

    handleMyAccount() {
        if (document.getElementById("logged").value == 0) {
            $(".login__form")[0].setAttribute(
                "style",
                'style="position: absolute; transform: translate3d(794px, 5px, 0px); top: 0px; left: 0px; will-change: transform;"'
            );
            $(".login__form")[0].classList.add("show");
        } else {
            location.href = BASE_URL + "myAccountView";
        }
    }

    userLoggedIn() {
        return document.getElementById("logged").value != 0;
    }

    getUserDetails() {
        axios.post(`${BASE_URL}getUserDetails`).then(({ data }) => {
            document.getElementById("first_name").value = data["first_name"];
            document.getElementById("last_name").value = data["last_name"];
            document.getElementById("city").value = data["city"];
            document.getElementById("area").value = data["area"];
            document.getElementById("house_no").value = data["house_no"];
            document.getElementById("phone").value = data["phone"];
            document.getElementById("email").value = data["email"];
            document.getElementById("district").value = data["district"];
            document.getElementById("thana").value = data["thana"];
            document.getElementById("road_no").value = data["road_no"];
            document.getElementById("flat_no").value = data["flat_no"];
            document.getElementById("address").value = data["address"];
        });
    }

    render() {
        // this.getUserDetails();
        return (
            <div>
                <div className="off_canvars_overlay"></div>
                <div className="offcanvas_menu">
                    <div className="container">
                        <div className="row">
                            <div className="col-12">
                                <div className="canvas_open">
                                    <a>
                                        <i className="ion-navicon"></i>
                                    </a>
                                </div>
                                <div className="offcanvas_menu_wrapper">
                                    <div className="canvas_close">
                                        <a>
                                            <i className="ion-android-close"></i>
                                        </a>
                                    </div>
                                    <div className="call_support">
                                        <p>
                                            <i
                                                className="icon-phone-call"
                                                aria-hidden="true"
                                            ></i>{" "}
                                            <span>
                                                Call us:{" "}
                                                <a href="tel: 01888-022244">
                                                    01888-022244
                                                </a>
                                            </span>
                                        </p>
                                    </div>
                                    <div className="header_top_links">
                                        {!this.userLoggedIn() ? (
                                            <ul>
                                                <li>
                                                    <a
                                                        className="text-dark"
                                                        href={
                                                            BASE_URL +
                                                            "register"
                                                        }
                                                    >
                                                        Register
                                                    </a>
                                                </li>
                                                <li>
                                                    <a
                                                        className="text-dark"
                                                        href={
                                                            BASE_URL + "login"
                                                        }
                                                    >
                                                        login
                                                    </a>
                                                </li>
                                            </ul>
                                        ) : (
                                            <ul>
                                                <li>
                                                    <a
                                                        className="text-dark"
                                                        onClick={() =>
                                                            this.doLogOut()
                                                        }
                                                    >
                                                        logout
                                                    </a>
                                                </li>
                                            </ul>
                                        )}
                                    </div>
                                    <div id="menu" className="text-left ">
                                        <ul className="offcanvas_main_menu">
                                            {/* <li className="menu-item-has-children active">
                                                <a href={BASE_URL}>Home</a>
                                            </li> */}
                                            <li className="menu-item-has-children">
                                                <a href={BASE_URL + "shopview"}>
                                                    Shop
                                                </a>
                                            </li>

                                            <li className="menu-item-has-children">
                                                <a
                                                    href={`${BASE_URL}shopview?offer=onsale`}
                                                >
                                                    Offer
                                                </a>
                                            </li>
                                            {this.userLoggedIn() ? (<li>
                                                <div className="dropdown">
                                                    <a
                                                        className="dropdown-toggle default__bg"
                                                        href="#"
                                                        role="button"
                                                        id="dropdownMenu2"
                                                        data-toggle="dropdown"
                                                        aria-haspopup="true"
                                                        aria-expanded="false"
                                                    >
                                                        Account
                                                    </a>
                                                    <div
                                                        className="dropdown-menu"
                                                        aria-labelledby="dropdownMenu2"
                                                    >
                                                        <a
                                                            className="dropdown-item"
                                                            href={
                                                                BASE_URL +
                                                                "myAccountView"
                                                            }
                                                        >
                                                            <i className="fa fa-user"></i>{" "}
                                                            &nbsp; Order History
                                                        </a>
                                                        
                                                            <Fragment>
                                                                <a
                                                                    className="dropdown-item"
                                                                    data-toggle="modal"
                                                                    data-target="#changePasswordModal"
                                                                >
                                                                    <i className="fa fa-key"></i>
                                                                    &nbsp;
                                                                    Change
                                                                    Password
                                                                </a>
                                                                <a
                                                                    className="dropdown-item"
                                                                    data-toggle="modal"
                                                                    data-target="#user_detail_modal"
                                                                    onClick={
                                                                        this
                                                                            .getUserDetails
                                                                    }
                                                                >
                                                                    <i className="fa fa-info-circle"></i>
                                                                    &nbsp; Edit
                                                                    Profile Info
                                                                </a>
                                                            </Fragment>
                                                    </div>
                                                </div>
                                            </li>): null}
                                            
                                            {/* <li className="menu-item-has-children">
                                                <a href={BASE_URL + "wishList"}>
                                                    Wishlist
                                                </a>
                                            </li> */}
                                            {/* <li className="menu-item-has-children">
                                                <a
                                                    href={
                                                        BASE_URL +
                                                        "contactFormView"
                                                    }
                                                >
                                                    Contact Us
                                                </a>
                                            </li> */}
                                            <li className="menu-item-has-children">
                                                <a
                                                    href={
                                                        BASE_URL +
                                                        "connectWithUs"
                                                    }
                                                >
                                                    Contact Us
                                                </a>
                                            </li>
                                            {/* <li className="menu-item-has-children">
                                                <a href={BASE_URL + "checkout"}>
                                                    Checkout
                                                </a>
                                            </li> */}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <header>
                    <div className="main_header">
                        {/* top header */}
                        <div className="header_top">
                            <div className="container">
                                <div className="row align-items-center">
                                    <div
                                        className="col-lg-4 col-md-5"
                                        style={{ marginTop: "-11px" }}
                                    >
                                        <div className="header_account">
                                            <ul>
                                                <li className="language">
                                                    <i
                                                        className="icon-phone-call"
                                                        aria-hidden="true"
                                                    />{" "}
                                                    <a
                                                        href="tel: 01888-022244"
                                                        style={{
                                                            fontWeight: "bold",
                                                            color: "#4e4e4e"
                                                        }}
                                                    >
                                                        Call us:{" "}
                                                        <span
                                                            className="phone__color"
                                                            style={{
                                                                fontWeight:
                                                                    "bold",
                                                                color: "#C70909"
                                                            }}
                                                        >
                                                            01888-022244
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div
                                        className="col-lg-8 col-md-7"
                                        style={{ marginTop: "-11px" }}
                                    >
                                        <div className="header_top_links text-right">
                                            <ul>
                                                {this.userLoggedIn() ? (
                                                    <li>
                                                        {" "}
                                                        <div className="dropdown show">
                                                            <a
                                                                className="dropdown-toggle default__bg"
                                                                href="#"
                                                                role="button"
                                                                id="dropdownMenuLink"
                                                                data-toggle="dropdown"
                                                                aria-haspopup="true"
                                                                aria-expanded="false"
                                                            >
                                                                Account
                                                            </a>

                                                            <div
                                                                className="dropdown-menu mt-3 topAccount"
                                                                aria-labelledby="dropdownMenuLink"
                                                                style={{
                                                                    padding:
                                                                        "0px"
                                                                }}
                                                            >
                                                                <a
                                                                    className="dropdown-item default__bg customDropdown__item"
                                                                    href={
                                                                        BASE_URL +
                                                                        "myAccountView"
                                                                    }
                                                                >
                                                                    <i className="fa fa-user"></i>{" "}
                                                                    &nbsp; Order
                                                                    History
                                                                </a>

                                                                <Fragment>
                                                                    <a
                                                                        className="dropdown-item default__bg"
                                                                        data-toggle="modal"
                                                                        data-target="#changePasswordModal"
                                                                    >
                                                                        <i className="fa fa-key"></i>
                                                                        &nbsp;
                                                                        Change
                                                                        Password
                                                                    </a>
                                                                    <a
                                                                        className="dropdown-item default__bg"
                                                                        data-toggle="modal"
                                                                        data-target="#user_detail_modal"
                                                                        onClick={
                                                                            this
                                                                                .getUserDetails
                                                                        }
                                                                    >
                                                                        <i className="fa fa-info-circle"></i>
                                                                        &nbsp;
                                                                        Edit
                                                                        Profile
                                                                        Info
                                                                    </a>
                                                                </Fragment>
                                                            </div>
                                                        </div>
                                                    </li>
                                                ) : null}

                                                {this.state.isLoggedIn == 0 ? (
                                                    <li>
                                                        <a
                                                            href="#"
                                                            data-toggle="dropdown"
                                                            className="nav-item nav-link dropdown-toggle p-0 mr-3 default__bg"
                                                            id="login"
                                                        >
                                                            Login
                                                        </a>
                                                        <div
                                                            className="dropdown-menu login__form"
                                                            style={{
                                                                position:
                                                                    "absolute",
                                                                top: "-20px"
                                                            }}
                                                        >
                                                            <form
                                                                action={
                                                                    BASE_URL +
                                                                    "login"
                                                                }
                                                                method="post"
                                                                onSubmit={e =>
                                                                    this.login(
                                                                        e
                                                                    )
                                                                }
                                                            >
                                                                <div className="form-group my-2">
                                                                    <input
                                                                        type="hidden"
                                                                        name="_token"
                                                                        id="login_token"
                                                                        value={
                                                                            CSRF_TOKEN
                                                                        }
                                                                    />
                                                                    <label>
                                                                        Email
                                                                    </label>
                                                                    <input
                                                                        type="email"
                                                                        name="email"
                                                                        id="email"
                                                                        className="form-control"
                                                                        required="required"
                                                                    />
                                                                </div>
                                                                <div className="form-group my-2">
                                                                    <div className="clearfix">
                                                                        <label>
                                                                            Password
                                                                        </label>
                                                                    </div>
                                                                    <input
                                                                        type="password"
                                                                        name="password"
                                                                        id="password"
                                                                        className="form-control"
                                                                        required="required"
                                                                    />
                                                                </div>
                                                                <input
                                                                    type="submit"
                                                                    onClick={e =>
                                                                        this.login(
                                                                            e
                                                                        )
                                                                    }
                                                                    className="btn btn-primary btn-block my-3"
                                                                    value="Login"
                                                                />
                                                            </form>

                                                            <div className="clearfix"></div>
                                                            <div className="text-center custom__hieght">
                                                                <a
                                                                    href={
                                                                        BASE_URL +
                                                                        "password/reset"
                                                                    }
                                                                    className="default__bg"
                                                                >
                                                                    <small>
                                                                        Forgotten
                                                                        Password?
                                                                    </small>
                                                                </a>
                                                            </div>

                                                            <div className="clearfix text-center custom__hieght">
                                                                <span className="text-muted">
                                                                    <small className="pr-2">
                                                                        Don't
                                                                        have an
                                                                        account?
                                                                    </small>
                                                                    <a
                                                                        className="default__bg"
                                                                        href={
                                                                            BASE_URL +
                                                                            "register"
                                                                        }
                                                                    >
                                                                        Sign up
                                                                    </a>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                ) : (
                                                    <li>
                                                        <span></span>
                                                    </li>
                                                )}

                                                {this.state.isLoggedIn != 0 ? (
                                                    <li>
                                                        <a
                                                            style={{
                                                                color:
                                                                    "#04043B "
                                                            }}
                                                            onClick={() =>
                                                                this.doLogOut()
                                                            }
                                                            data-a="0"
                                                        >
                                                            Logout
                                                        </a>
                                                    </li>
                                                ) : (
                                                    <></>
                                                )}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/*header middel start*/}
                        <div className="header_middle h_middle_two">
                            <div className="container">
                                <div className="row align-items-center">
                                    <div className="col-lg-2 col-md-4 col-sm-4 col-4">
                                        <div
                                            className="logo"
                                            style={{ marginTop: "-15px" }}
                                        >
                                            <a href={BASE_URL}>
                                                <img
                                                    src={
                                                        BASE_URL +
                                                        "mazley_assets/img/logo/automax-lg.png"
                                                    }
                                                    alt=""
                                                />
                                            </a>
                                        </div>
                                    </div>
                                    <div className="col-lg-10 col-md-6 col-sm-6 col-6">
                                        <div className="header_right_box">
                                            <div className="search_container">
                                                <form>
                                                    <div className="hover_category">
                                                        <CategoryList
                                                            categoryList={
                                                                this.state
                                                                    .categories
                                                            }
                                                            handleCategorySelect={
                                                                this
                                                                    .handleCategorySelect
                                                            }
                                                        />
                                                    </div>
                                                    <div className="search_box">
                                                        <input
                                                            placeholder="Search product..."
                                                            type="text"
                                                            id="searchPost"
                                                            onKeyUp={e =>
                                                                this.catProductSearchByEnter(
                                                                    e
                                                                )
                                                            }
                                                        />
                                                        <button
                                                            type="button"
                                                            onClick={
                                                                this
                                                                    .catProdutSearch
                                                            }
                                                        >
                                                            Search
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div className="header_configure_area">
                                                <WishlistContainer
                                                    data={this.state.wish}
                                                />
                                                <CartContainer
                                                    data={this.state.cart}
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        className="col-sm-12 pt-4"
                                        id="search_box_sm_screen"
                                        style={{ display: "none" }}
                                    >
                                        <div className="">
                                            <form>
                                                <div className="hover_category">
                                                    <CategoryList
                                                        categoryList={
                                                            this.state
                                                                .categories
                                                        }
                                                        handleCategorySelect={
                                                            this
                                                                .handleCategorySelect
                                                        }
                                                    />
                                                </div>
                                                <div className="clearfix"></div>
                                                <div className="search_box">
                                                    <input
                                                        placeholder="Search product..."
                                                        type="text"
                                                        id="searchBarMobile"
                                                        onKeyUp={e =>
                                                            this.handleSearchInput(
                                                                e
                                                            )
                                                        }
                                                    />
                                                    <button
                                                        type="button"
                                                        onClick={
                                                            this
                                                                .catProdutSearchMobile
                                                        }
                                                    >
                                                        Search
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {/*header middel end*/}
                        {/*header bottom satrt*/}
                        <div className="header_bottom sticky-header">
                            <div className="container">
                                <div className="row align-items-center">
                                    <div
                                        className="col-lg-4 col-xl-3"
                                        id="cat__menu"
                                    >
                                        <div className="d-flex justify-content-start">
                                            <ul
                                                className="flex-item"
                                                style={{ marginRight: "20px" }}
                                            >
                                                <li className="mega_items">
                                                    <a
                                                        href={BASE_URL}
                                                        style={{
                                                            lineHeight: "0",
                                                            marginTop: "-5px",
                                                            color: "#fff"
                                                        }}
                                                    >
                                                        <i className="fa fa-home fa-2x"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div
                                                className="categories_menu"
                                                id="catgoryMenu"
                                                style={{ width: "100%" }}
                                            >
                                                <div id="category__goryTitle">
                                                    <h2 className="categoryHeader">
                                                        ALL CATEGORIES
                                                    </h2>
                                                </div>
                                                <div
                                                    id="allCategoryBox"
                                                    style={{
                                                        backgroundColor: "#fff",
                                                        border:
                                                            "1px solid #ebebeb",
                                                        backgroundColor: "#fff",
                                                        position: "absolute",
                                                        width: "100%",
                                                        top: "100%",
                                                        zIndex: "9",
                                                        height: "450px",
                                                        overflow: "auto",
                                                        display: "none"
                                                    }}
                                                >
                                                    {/* <ul >
                                                        <MainnavCategories />
                                                    </ul> */}
                                                    <MainnavCategories />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-lg-6">
                                        <div className="main_menu menu_position text-left">
                                            <nav>
                                                <ul>
                                                    {/* <li className="menu-item-has-children active">
                                                   <a href={BASE_URL} style={{ lineHeight: '0', marginTop: '-5px' }}><i className="fa fa-home fa-2x"></i></a>
                                                 </li> */}
                                                    <li className="mega_items">
                                                        <a
                                                            href={
                                                                BASE_URL +
                                                                "shopview"
                                                            }
                                                        >
                                                            Shop
                                                        </a>
                                                    </li>
                                                    <li className="mega_items">
                                                        <a
                                                            href={`${BASE_URL}shopview?offer=onsale`}
                                                        >
                                                            Offer
                                                        </a>
                                                    </li>
                                                    {/* <li>
                                                        <a
                                                            className="text-white"
                                                            id="myAccountLink"
                                                            onClick={() => this.handleMyAccount()}
                                                        >
                                                            My Account
                                                        </a>
                                                    </li> */}
                                                    {/* <li>
                                                        <a
                                                            href={
                                                                BASE_URL +
                                                                "wishList"
                                                            }
                                                        >
                                                            Wishlist
                                                        </a>
                                                    </li> */}
                                                    {/* <li>
                                                        <a
                                                            href={
                                                                BASE_URL +
                                                                "contactFormView"
                                                            }
                                                        >
                                                            Contact Us
                                                        </a>
                                                    </li> */}
                                                    <li>
                                                        <a
                                                            href={
                                                                BASE_URL +
                                                                "connectWithUs"
                                                            }
                                                        >
                                                            Contact Us
                                                        </a>
                                                    </li>
                                                    {/* <li>
                                                        <a
                                                            href={
                                                                BASE_URL +
                                                                "checkout"
                                                            }
                                                        >
                                                            Checkout
                                                        </a>
                                                    </li> */}
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                {/* Request a product */}
                <div
                    className="modal fade"
                    id="exampleModal"
                    tabIndex="-1"
                    role="dialog"
                    aria-labelledby="exampleModalLabel"
                    aria-hidden="true"
                >
                    <div
                        className="modal-dialog modal-dialog-centered"
                        role="document"
                    >
                        <div
                            className="modal-content p-3"
                            style={{ borderRadius: "25px" }}
                        >
                            <h4
                                className="modal-title"
                                id="exampleModalLabel"
                                style={{
                                    fontWeight: 500,
                                    textAlign: "center",
                                    fontSize: "20px"
                                }}
                            >
                                Request a Product
                            </h4>
                            <button
                                type="button"
                                className="close close__btn"
                                data-dismiss="modal"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div className="modal-body">
                                <form id="requestDetailsForm">
                                    <div className="form-group">
                                        <label>
                                            Name{" "}
                                            <span className="text-danger">
                                                *
                                            </span>
                                        </label>
                                        <input
                                            type="text"
                                            id="req_user_name"
                                            name="user_name"
                                            className="form-control mb-2"
                                            placeholder="Your Name"
                                        />
                                    </div>
                                    <div className="form-group">
                                        <label>
                                            Phone{" "}
                                            <span className="text-danger">
                                                *
                                            </span>
                                        </label>
                                        <input
                                            type="text"
                                            id="req_user_phone"
                                            name="user_phone"
                                            className="form-control mb-2"
                                            placeholder="Your Phone Number"
                                        />
                                    </div>
                                    <div className="form-group">
                                        <label>Email</label>
                                        <input
                                            type="email"
                                            id="req_user_email"
                                            name="user_email"
                                            className="form-control mb-2"
                                            placeholder="Your Email"
                                        />
                                    </div>
                                    <div className="form-group">
                                        <label>
                                            Product Details
                                            <span className="text-danger">
                                                *
                                            </span>
                                        </label>
                                        <textarea
                                            id="req_product_detail"
                                            name="product_detail"
                                            className="form-control mb-2"
                                            placeholder="Product Details"
                                        ></textarea>
                                    </div>

                                    <div className="form-group">
                                        <input
                                            type="file"
                                            className="form-control"
                                            name="product_image"
                                            accept="image/*"
                                            id="product_image"
                                        />
                                    </div>
                                </form>
                            </div>
                            <div
                                className="modal-footer justify-content-center"
                                style={{ border: "none" }}
                            >
                                <button
                                    type="button"
                                    className="btn btn-secondary"
                                    data-dismiss="modal"
                                >
                                    Close
                                </button>
                                <button
                                    type="button"
                                    className="btn btn-primary"
                                    onClick={this.requestProduct}
                                >
                                    Request
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <ChangePasswordModal />
                <UserDetailModal />
            </div>
        );
    }
}
