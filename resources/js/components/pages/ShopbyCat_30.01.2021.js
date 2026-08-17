import React, { Component } from "react";
import ReactDOM from "react-dom";
import Header from "../homepageComponents/Header";
import SidebarContainer from "../ShopComponents/SidebarContainer";
import ShopSearchProductContainer from "../ShopComponents/ShopSearchProductContainer";
import { BASE_URL } from "../config/Constants";
import ProductDetailModal from "../homepageComponents/ProductDetailModal";

class ShopbyCat extends Component {
    constructor() {
        super();
        this.state = {
            products: [],
            count: 0,
            selectedCategory: 0,
            selectedSubCategory: 0,

            // newly added, to match with <Shop/>
            activePage: 1,
            itemsCountPerPage: 16,
            totalItemsCount: 1,
            pageRangeDisplayed: 1,
            is_searched: null,
            comapny_id: null,
            brand_id: null,
            model_id: null,
            sortBy: undefined,
        };

        if (location.href.split("/")[5] === "shopByCategory") {
            let category_id = location.href.split("/")[6];
            if (category_id != undefined) {
                let URL = BASE_URL + "shopByCategoryAjax/" + category_id;
                axios.post(URL).then(({ data }) => {
                    this.setState({
                        products: data,
                        selectedCategory: category_id,
                    });
                });
            }
        } else if (location.href.split("/")[5] === "shopBySubCategory") {
            let sub_category_id = location.href.split("/")[6];
            if (sub_category_id != undefined) {
                let URL = BASE_URL + "shopBySubCategoryAjax/" + sub_category_id;
                axios.post(URL).then(({ data }) => {
                    this.setState({
                        products: data,
                        selectedSubCategory: sub_category_id,
                    });
                });
            }
        }

        this.getCategoriesData = this.getCategoriesData.bind(this);
        this.getSubCategoriesData = this.getSubCategoriesData.bind(this);
        this.sortProductByParam = this.sortProductByParam.bind(this);
    }

    getCategoriesData(id) {
        axios.post(BASE_URL + "shopByCat", { id }).then((response) => {
            this.setState({
                products: response.data,
                selectedCategory: id,
            });
        });
    }

    getSubCategoriesData(subCategory, category) {
        axios.post(BASE_URL + "shopBySubCat", { subCategory }).then((response) => {
            this.setState({
                products: response.data,
                selectedSubCategory: subCategory,
                selectedCategory: category,
            });
        });
    }

    sortProductByParam(param) {
        if (param) {
            // if sub-category selected, include the sub-category value
            // else only search by category
            if (this.state.selectedSubCategory != 0) {
                axios
                    .post(BASE_URL + "sortProductByParam", {
                        param: param,
                        category: this.state.selectedCategory,
                        subCategory: this.state.selectedSubCategory,
                    })
                    .then((response) => {
                        this.setState({ products: response.data });
                    });
            } else {
                axios
                    .post(BASE_URL + "sortProductByParam", {
                        param: param,
                        category: this.state.selectedCategory,
                    })
                    .then((response) => {
                        this.setState({ products: response.data });
                    });
            }
        }
    }

    render() {
        return (
            <div>
                <Header />

                <div className="shop_area">
                    <div className="container">
                        <div className="row">
                            <SidebarContainer
                                getCategoriesData={this.getCategoriesData}
                                getSubCategoriesData={this.getSubCategoriesData}
                            />
                            <ShopSearchProductContainer
                                products={this.state.products}
                                sortProductByParam={this.sortProductByParam}
                            />
                            <ProductDetailModal />
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

if (document.getElementById("shopbyCatApp")) {
    ReactDOM.render(<ShopbyCat />, document.getElementById("shopbyCatApp"));
}
