import React, { useState, Component } from "react";
import ReactDOM from "react-dom";
import Carousel from "react-elastic-carousel";
import { BASE_URL } from "../config/Constants";
import ProductInfo from "./ProductInfo";
import "../../../../node_modules/slick-carousel/slick/slick.css";
import "../../../../node_modules/slick-carousel/slick/slick-theme.css";
import Slider from "react-slick";
import ProductDetailModal from "./ProductDetailModal";
import Loading from "../ShopComponents/Loading";

export default class AllProductContainer extends Component {
    constructor(props) {
        super(props);
        // this.next = this.next.bind(this);
        // this.previous = this.previous.bind(this);
    }
    render() {
        // let data = this.props.products.map((val, k) => {
        //     return ;
        // });

        let data = this.props.products.map((val, k)=> (
            <div className="allItemGrid" key={"itemGrid_"+ k}>
               <ProductInfo product={val} key={k} />                             
            </div>
        ))

        return (
            <div className="product_area product_style3 color_three">
                <div className="container mble_responsive">
                    <div className="row mble_responsive">
                        <div className="col-12">
                            <div className="section_title title_style2">
                                <div className="title_content">
                                    <h2>{this.props.name}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="tab-content">
                        <div
                            className="tab-pane fade show active"
                            id="Sellers"
                            role="tabpanel"
                        >
                            <div className="product_area">
                                <div className="container mble_responsive">
                                    <div style={{ display: 'flex', flexFlow: 'row wrap'}}>
                                        {data}
                                        { 
                                          this.props.loadingStatus ? <Loading/>: ''
                                        }
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}
