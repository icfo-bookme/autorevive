import React, { Component } from "react";
import ShopProducts from "./ShopProducts";
import {BASE_URL} from "../config/Constants";
import ShopUtils from "./ShopUtils";
import Loading from "./Loading";

function uuidv4() {
    return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, c =>
        (
            c ^
            (crypto.getRandomValues(new Uint8Array(1))[0] & (15 >> (c / 4)))
        ).toString(16)
    );
}
export default class ShopSearchProductContainer extends Component {

    constructor(props) {
        super(props);
        this.parentThis = this;
    }

    render() {
        let CarFilter = this.props.CarFilter ? this.props.CarFilter : '';
        return (
            <div className="col-sm-12 col-lg-9 col-md-12 order-sm-2">

                {/* commented

                <div className="shop_banner_area mb-30">
                    <div className="row">
                        <div className="col-12">
                            {CarFilter
                                ?   <CarFilter
                                        companies={this.props.companies}
                                        carSearchStatus={this.props.carSearchStatus}
                                        searchCar={this.props.searchCar}
                                        setCarFilterParams={this.props.setCarFilterParams}
                                    />
                                :   ''
                            }
                        </div>
                    </div>

                </div>

                </div> Comment End*/}


                <div className="shop_toolbar_wrapper">
                    <div className="shop_toolbar_btn">
                        <button
                            data-role="grid_4"
                            type="button"
                            className="active btn-grid-4"
                            data-toggle="tooltip"
                            title="4"
                        ></button>
                        <button
                            data-role="grid_3"
                            type="button"
                            className=" btn-grid-3"
                            data-toggle="tooltip"
                            title="3"
                        ></button>
                    </div>
                    <div className="mx-auto">
                        <form action="#">
                            <select
                                name="orderby"
                                className="form-control"
                                id="short"
                                onChange={(e) =>
                                    this.props.sortProductByParam(
                                        e.target.value
                                    )
                                }
                                required
                            >
                                <option value="">Please Sort Products</option>
                                <option value={"price_asc"}>
                                    Sort by Price: Low to High
                                </option>
                                <option value={"price_desc"}>
                                    Sort by Price: High to Low
                                </option>
                                {/* <option value={"average"}>
                                    Sort by rating
                                </option> */}
                                {/* <option value={"popularity"}>
                                    Sort by popularity
                                </option> */}
                                <option value={"onsale"}>Sort by On Sale</option>
                                <option value={"time"}>Sort by Latest</option>
                                <option value={"name"}>Sort by Name</option>
                            </select>
                        </form>
                    </div>
                    <div className="page_amount"></div>
                </div>

                <div id="allProducts" className="row shop_wrapper">
                    {this.props.products.length > 0 ? this.props.products.map((products) => (
                        <ShopProducts products={products} key={uuidv4()}/>
                    )):(<div className="row d-flex justify-content-center">
                        <div className="col-lg-8">
                             <h4 className="text-center text-secondary">No Match Found</h4>
                            <button className="btn btn-danger btn-block" data-toggle="modal" data-target="#exampleModal">Request Product</button>
                        </div>
                    </div>)}
                    {this.props.loading && <Loading/>}
                </div>
            </div>
        );
    }

}
