import React, { Component } from "react";
import ReactDOM from "react-dom";
import Header from "../homepageComponents/Header";
import SidebarContainer from "../ShopComponents/SidebarContainer";
import ShopSearchProductContainer from "../ShopComponents/ShopSearchProductContainer";
import { BASE_URL } from "../config/Constants";
import Pagination from "react-js-pagination";

export default class ContactPage extends Component {
    constructor() {
        super();
        this.state = {
            products: [],
            count: 0,
            selectedCategory: 0,
            selectedSubCategory: 0,
            activePage: 1,
            itemsCountPerPage: 1,
            totalItemsCount: 1,
            pageRangeDisplayed: 1,
        };

        let totalProducts = 0;

        this.getCategoriesData = this.getCategoriesData.bind(this);
        this.getSubCategoriesData = this.getSubCategoriesData.bind(this);
        this.sortProductByParam = this.sortProductByParam.bind(this);

        this.handlePageChange = this.handlePageChange.bind(this);
    }

    searchProductByCategory(category_id, slug) {
        axios
            .post(BASE_URL + "searchByCategoryAjax", { category_id, slug })
            .then((response) => {
                this.setState({
                    products: response.data,
                    selectedCategory: category_id,
                });
            });
    }

    getCategoriesData(id) {
        axios.post(BASE_URL + "shopByCat", { id }).then((response) => {
            this.setState({
                products: response.data,
                selectedCategory: id,

                selectedSubCategory: undefined,
                itemsCountPerPage: 16,
                totalItemsCount: response.data.length,
                activePage: 1,
            });
        });
    }

    getSubCategoriesData(subCat) {
        axios.post(BASE_URL + "shopBySubCat", { subCat }).then((response) => {
            this.setState({
                products: response.data,
                selectedSubCategory: subCat,

                itemsCountPerPage: 16,
                totalItemsCount: response.data.length,
                activePage: 1,
            });
        });
    }

    sortProductByParam(param) {
        axios
            .post(BASE_URL + "sortProductByParam", {
                param: param,
                category: this.state.selectedCategory,
            })
            .then((response) => {
                this.setState({ products: response.data });
            });
    }

    componentDidMount() {
        let loadAllProducts = () => {
            axios
                .post(BASE_URL + "allProducts", {
                    category_id: this.state.selectedCategory,
                })
                .then((response) => {
                    this.setState({ products: response.data.data });
                    this.setState({
                        itemsCountPerPage: response.data.per_page,
                    });
                    this.setState({ totalItemsCount: response.data.total });
                    this.setState({ activePage: response.data.current_page });
                });
        }

        let searchProductsWithCategory = () => {
            let query_cat = location.search
                .split("&")[0]
                .replace("?", "")
                .split("=")[0];
            let query_slug = location.search.split("&")[1].split("=")[0];

            if (query_cat == "catId" && query_slug == "slug") {
                let category_id = location.search
                    .split("&")[0]
                    .replace("?", "")
                    .split("=")[1];
                let slug = location.search.split("&")[1].split("=")[1];

                // check empty search
                if (category_id.length > 0 || slug.length > 0) {
                    this.searchProductByCategory(category_id, slug);
                } else {
                    loadAllProducts();
                }
            }
        }

        // check if page loaded as search redirect or normal
        if (location.search.length > 0) {
            searchProductsWithCategory();
        } else {
            loadAllProducts();
        }
    }

    handlePageChange(pageNumber) {
        axios
            .post(BASE_URL + "allProducts?page=" + pageNumber, {
                category_id: this.state.selectedCategory,
                subcategory_id: this.state.selectedSubCategory,
            })
            .then((response) => {
                this.setState({ products: response.data.data });
                this.setState({ itemsCountPerPage: response.data.per_page });
                this.setState({ totalItemsCount: response.data.total });
                this.setState({ activePage: response.data.current_page });
            });
    }

    render() {
        return (
            <div>
                <Header />
                {/* <div className="breadcrumbs_area">
                    <div className="container">
                        <div className="row">
                            <div className="col-12">
                                <div className="breadcrumb_content">
                                    <ul>
                                        <li>
                                            <a href={"./"}>home</a>
                                        </li>
                                        <li>shop</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> */}
                <div className="shop_area shop_reverse">
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
                        </div>
                    </div>
                </div>

                <div id="pagination__sm" style={{ paddingLeft: "50%" }}>
                    <Pagination
                        activePage={this.state.activePage}
                        itemsCountPerPage={this.state.itemsCountPerPage}
                        totalItemsCount={this.state.totalItemsCount}
                        pageRangeDisplayed={5}
                        onChange={this.handlePageChange.bind(this)}
                        itemClass="page-item"
                        linkClass="page-link"
                    />
                </div>
            </div>
        );
    }
}

if (document.getElementById("contactApp")) {
    ReactDOM.render(<ContactPage />, document.getElementById("contactApp"));
}
