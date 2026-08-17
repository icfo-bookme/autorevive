// import React, { Component } from "react";
// import ReactDOM from "react-dom";
// import ProductDetails from "../ProductDetails/ProductDetails";
// import Header from "../homepageComponents/Header";
// import { BASE_URL } from '../config/Constants';


// export default class Product extends Component {
//     constructor() {
//         super();
//         this.state = {
//             productDetail: []
//         }
//         var productId = undefined; 
//     }

//     componentDidMount (){
//         if (location.href.split('/')[3] === 'singleProductDetails') {
//             let product_id = location.href.split("/")[4];
//             this.productId = product_id;
//             if (product_id) {
//                 let URL = BASE_URL + "getItemDetails/" + product_id;

//                 axios.post(URL).then(({ data }) => {
//                     this.setState({ productDetail: data[0] });
//                 });
//             }
//         }
//     }

//     render() {
//         return (
//             <div>
//                 <Header />
//                 <ProductDetails productDetail={this.state.productDetail} productId={this.productId}/>
//             </div>
//         );
//         // return <div>sadjnkasjd</div>
//     }
// }

// if (document.getElementById("productApp")) {
//     ReactDOM.render(<Product />, document.getElementById("productApp"));
// }


import React, { Component } from "react";
import ReactDOM from "react-dom";
import ProductDetails from "../ProductDetails/ProductDetails";
import Header from "../homepageComponents/Header";
import { BASE_URL } from '../config/Constants';

export default class Product extends Component {
    constructor() {
        super();
        this.state = {
            productDetail: []
        };
        this.productId = undefined;
    }

    componentDidMount() {
        // Set dynamic title if productName is available
        if (window.productName) {
            document.title = window.productName + " - Automart";
        }

        if (location.href.split('/')[3] === 'singleProductDetails') {
            let product_id = location.href.split("/")[4];
            this.productId = product_id;
            if (product_id) {
                let URL = BASE_URL + "getItemDetails/" + product_id;

                axios.post(URL).then(({ data }) => {
                    this.setState({ productDetail: data[0] });
                });
            }
        }
    }

    render() {
        return (
            <div>
                <Header />
                <ProductDetails productDetail={this.state.productDetail} productId={this.productId} />
            </div>
        );
    }
}

if (document.getElementById("productApp")) {
    ReactDOM.render(<Product />, document.getElementById("productApp"));
}
