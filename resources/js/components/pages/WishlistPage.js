import React, { Component } from 'react';
import ReactDOM from "react-dom";
import Header from "../homepageComponents/Header";
import Wishlist from "../WishlistComponents/Wishlist"

class WishlistPage extends Component {
    render() {
        return (
            <div>
                <Header/>
                <Wishlist />
            </div>
        );
    }
}
if (document.getElementById("wishlistApp")) {
    ReactDOM.render(<WishlistPage />, document.getElementById("wishlistApp"));
}
