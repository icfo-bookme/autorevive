import React, { Component } from "react";
import SidebarCategoriesContainer from "../ShopComponents/SidebarCategoriesContainer";
import CategoriesAccordion from "./CategoriesAccordion";
import { BASE_URL } from "../config/Constants";


export default class SidebarContainer extends Component {
    constructor(props) {
        super();
        this.state = {
            categories: []
        };
        this.jsxData = undefined;
        console.log(props);
    }

    componentDidMount() {
        axios.post(BASE_URL + "categories").then(response => {
            this.setState({ categories: response.data });
        });
    }


    render() {
        let selectedCategory = this.props.selectedCategory;
        let selectedSubCategory = this.props.selectedSubCategory;
        let selectedCategoryStyle = {};
        let selectedSubCategoryStyle = {};
        let allProductsStyle = {};

        if (selectedCategory == 0) {
            allProductsStyle = {
                background: "#C70909",
                color: "#fff",
                textDecoration: "none !important",
            };
        }

        this.jsxData = this.state.categories.map((val, valKey) => {
            if (selectedCategory == val.id && !selectedSubCategory) {
                selectedCategoryStyle = {
                    background: "#C70909",
                    color: "#fff",
                    textDecoration: "none !important",
                };
            } else {
                selectedCategoryStyle = {};
            }

            if (val.sub_category) {
                return (
                    <li id={"collapseLi" + val.id} key={"cat_" + val.id}>
                        <a key={valKey} style={selectedCategoryStyle}>
                            <span
                                style={{
                                    display: "inline-block",
                                    width: "80%",
                                }}
                                onClick={() =>
                                    this.props.getCategoriesData(val.id)
                                }
                            >
                                {val.name}
                            </span>
                            <span
                                className="collapse__click"
                                style={{ width: "20%" }}
                                onMouseEnter = {() => collapse(val.id)}
                                onClick={() => collapse(val.id)}
                            >
                            <i className="fa fa-chevron-down"></i>
                            </span>
                        </a>
                        <ul>
                            {val.sub_category.map((subCategory) => {
                                // if (selectedCategory == val.id && selectedSubCategory == subCategory.id) {
                                if (selectedSubCategory == subCategory.id) {
                                    selectedSubCategoryStyle = {
                                        background: "#C70909",
                                        color: "#fff",
                                        textDecoration: "none !important",
                                    };
                                } else {
                                    selectedSubCategoryStyle = {};
                                }

                                return (
                                    <li
                                        key={"subcat_" + subCategory.id}
                                        id={"subcat_" + subCategory.id}
                                        ref={"subcat_" + subCategory.id}
                                    >
                                        <a
                                            style={selectedSubCategoryStyle}
                                            onClick={() =>
                                                this.props.getSubCategoriesData(
                                                    subCategory.id,
                                                    subCategory.category_id
                                                )
                                            }
                                        >
                                            {subCategory.name}
                                        </a>
                                    </li>
                                );
                            })}
                        </ul>
                    </li>
                );
            } else {
                return (
                    <li key={"cat_" + val.id}>
                        <a
                            key={valKey}
                            onClick={() => this.props.getCategoriesData(val.id)}
                        >
                            {val.name}
                        </a>
                    </li>
                );
            }
        });

        this.jsxData.unshift(
            <li key={"all_products"}>
                <a
                   href ={BASE_URL+"shopview"}
                    key={"all_products"}
                    onClick={() => this.props.getCategoriesData("all_products")}
                    style={allProductsStyle}
                >
                    All Products
                </a>
            </li>
        );

        return (
            <div className="col-sm-12 col-lg-3 col-md-12 order-sm-1 make-me-sticky">
                <div className="contenedor-menu make-me-sticky">
                    <h3>Categories</h3>

                    <ul
                        className="menu shadow-sm pb-5"
                        id="custom__scroll"
                        style={{ background: "#fff" }}
                    >
                        {this.jsxData}
                    </ul>
                </div>
            </div>
        );
    }
}
