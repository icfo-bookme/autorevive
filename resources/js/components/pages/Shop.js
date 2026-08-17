import React, { Component } from "react";
import ReactDOM from "react-dom";
import Header from "../homepageComponents/Header";
import SidebarContainer from "../ShopComponents/SidebarContainer";
import ShopSearchProductContainer from "../ShopComponents/ShopSearchProductContainer";
import { BASE_URL } from "../config/Constants";
import Pagination from "react-js-pagination";
import CarFilter from "../homepageComponents/CarFilter";
import ProductDetailModal from "../homepageComponents/ProductDetailModal";
import { Alert } from "bootstrap";

export default class Shop extends Component {
    constructor() {
        super();
        this.state = {
            products: [],
            companies: [],
            count: 0,
            selectedCategory: 0,
            selectedSubCategory: 0,
            activePage: 1,
            itemsCountPerPage: 16,
            totalItemsCount: 1,
            pageRangeDisplayed: 1,
            is_searched: null,
            comapny_id: null,
            brand_id: null,
            model_id: null,
            sortBy: undefined,
            showSidebar: true,
            items: [],
            hasMore: true,
            skip: 0,
            loading: true,
            trackScroll: true,
            skipCountWithCategory: 0,
            skipCountWithSubCategory: 0,
            skipCountForCarSearch: 0,
            getId: null,
            reachedBottom: false,
            countEntry: 0,
            skipTemp: null,
            temp: false,
            getCatId: null,
            getSubCatId: null,
            getCompanyId: "",
            getBrandId: "",
            getModelId: "",
            categoryScrollEnabled: false,
            subCategoryScrollEnabled: false,
            carSearch: false,
            carSearchStatus: false,
            sortByParamSkip: 0,
            sortingParam: '',
            setParam: undefined,
            setParamCat: undefined,
            setParamSubCat: undefined,
            setParamCarFilter: undefined,
            trackParam: false,
            trackParamCat: false,
            trackParamSubCat: false,
            trackParamCarFilter: false,
            sortParamSkip: 0,
            sortParamSkipCat: 0,
            sortParamSkipSubCat: 0,
            sortParamCarFilterSkip: 0,
            carEmptySkip: 0,
            carEmptySearch: false,
            slugCategorySearch: false,
            slugCategorySearchSkip: 0,
            get_category_id: null,
            get_slug: null,
            searchCarWithCompanyStatus: false,
            searchCarWithBrandStatus: false,
            searchCarWithModelStatus: false,
            searchCarWithNullCompanyStatus: false,
            searchCarWithCompanySkip: 0,
            searchCarWithBrandSkip: 0,
            searchCarWithModelSkip: 0,
            searchCarWithNullCompanySkip: 0,
            getComId: "",
            getBrand: "",
            getModel: "",
            emptyCompanyId: "",
            emptyBrandId: "",
            emptyModelId: "",
            setOnSaleParam: undefined,
            tarckOnsaleParam: false,
            onSaleParamSkip: 0,
        };
        let totalProducts = 0;
        this.getCategoriesData = this.getCategoriesData.bind(this);
        this.getSubCategoriesData = this.getSubCategoriesData.bind(this);
        this.sortProductByParam = this.sortProductByParam.bind(this);
        this.searchCar = this.searchCar.bind(this);
        this.setCarFilterParams = this.setCarFilterParams.bind(this);

        this.handlePageChange = this.handlePageChange.bind(this);
        this.fetch = this.fetch.bind(this);
        this.trackScrolling = this.trackScrolling.bind(this);
        this.fetchMoreDataForCat = this.fetchMoreDataForCat.bind(this);
        this.scrollRecordCat = this.scrollRecordCat.bind(this);
        this.fetchMoreDataForSubCat = this.fetchMoreDataForSubCat.bind(this);
        this.scrollRecordSubCat = this.scrollRecordSubCat.bind(this);
        this.fetchMoreByParams = this.fetchMoreByParams.bind(this);
        this.scrollRecordByParams = this.scrollRecordByParams.bind(this);
        this.sortMoreDataByParam = this.sortMoreDataByParam.bind(this);
        this.sortByParamScrollTrack = this.sortByParamScrollTrack.bind(this);
        this.container = React.createRef();
    }

    searchCar(requestObj) {
        console.log("hellow ", requestObj);
        if(requestObj.companyId == "" && requestObj.brandId =="" && requestObj.modelId =="" ){
            this.setState({
                getCompanyId: "",
                getBrandId: "",
                getModelId: "",
                carEmptySkip: 0,
                slugCategorySearch: false,
                get_slug: null,
                getId: null,
                getCatId: null,
                getSubCatId: null,
            }, ()=>{
                this.emptyCarSearch(requestObj);
                document.addEventListener("scroll", this.emptyCarSearchTrack);
            })
           
        }else{
            this.setState({
                getCompanyId: "",
                getBrandId: "",
                getModelId: "",
                slugCategorySearch: false,
                get_slug: null,
                getId: null,
                getCatId: null,
                getSubCatId: null,
            }, () => {
                this.fetchMoreByParams(requestObj);
                document.addEventListener("scroll", this.scrollRecordByParams);
            })
        }
    }
    searchProductByCategory(category_id, slug) {
        this.fetchMoreSearchProductDataByCategory(category_id, slug);
        document.addEventListener("scroll", this.fetchMoreSearchProductDataByCategoryScrollTrack);

    }
    getCategoriesData = (id) => {
        if (id == "all_products") {
            this.setState({
                allCategory: id
            })
            window.location.reload();
        } else {
            // fetch products by category
           this.setState({
            slugCategorySearch: false,
            get_slug: null
           }, ()=> {
            this.fetchMoreDataForCat(id);
            document.addEventListener("scroll", this.scrollRecordCat);
           })
        }
    }

    getSubCategoriesData(subCategory, category) {
        this.fetchMoreDataForSubCat(subCategory, category);
        document.addEventListener("scroll", this.scrollRecordSubCat);

    }

    sortProductByParam(param) {
        if(this.state.selectedCategory == 0 && this.state.selectedSubCategory == 0){
            if(this.state.getCompanyId == 0 && this.state.getBrandId == 0 && this.state.getModelId == 0){
                this.setState({
                   setParam: undefined,
                   setOnSaleParam: undefined,
                   tarckOnsaleParam: false,
                }, ()=> {
                    this.sortMoreDataByParam(param);
                    document.addEventListener("scroll", this.sortByParamScrollTrack);
                })
                
            }else{
                this.setState({
                    setParamCarFilter: undefined,
                    slugCategorySearch: false,
                    get_slug: null,
                    setOnSaleParam: undefined,
                    tarckOnsaleParam: false,
                }, ()=> {
                    this.fetchSortingDataByParam(param);
                    document.addEventListener("scroll", this.fetchSortingDataByParamScrollTrack);
                })
                
            }
        }
        else if(this.state.selectedCategory != 0 && this.state.selectedSubCategory == 0){
            this.setState({
                setParamCat: undefined,
                categoryScrollEnabled: false,
                subCategoryScrollEnabled: false,
                setOnSaleParam: undefined,
                tarckOnsaleParam: false,
            }, ()=>{
                this.sortMoreDataByParamForCat(param);
                document.addEventListener("scroll", this.sortByParamScrollTrackForCat);
            })
        }else{
            this.setState({
                setParamSubCat: undefined,
                setOnSaleParam: undefined,
                tarckOnsaleParam: false,
            }, ()=>{
                this.sortMoreDataByParamForSubCat(param);
                document.addEventListener("scroll", this.sortByParamScrollTrackForSubCat);
            })        
        }
    }

    setCarFilterParams (filterParams) {
        this.setState({
            comapny_id: filterParams['companyId'],
            brand_id: filterParams['brandId'],
            model_id: filterParams['modelId'],
        });
    }
    componentDidMount() {
        // load all companies
        axios.post(BASE_URL + "getCompanies").then(({data}) => {
            if (JSON.stringify(this.state.companies) != JSON.stringify(data)) {
                this.setState({ companies: data });
            }
        });
        let loadAllProducts = () =>{
            this.fetch();
            document.addEventListener("scroll", this.trackScrolling);
            
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
                    // note: param might not be needed, re-check in refactoring. (1)
                    // loadAllProducts(this.state.selectedCategory);
                    loadAllProducts(this.state.selectedCategory);
                }
            }
        };
        let searchProductWithCarFilter = () => {
            let company = location.search.split("&")[0].replace("?", "").split("=")[0];
            let brand = location.search.split("&")[1].substring(0, 7);
            let model = location.search.split("&")[2].substring(0, 7);
            this.setState({
                slugCompany: company,
                slugBrand: brand,
                slugModel: model
            }, ()=> {
                if (this.state.slugCompany == "comId" && this.state.slugBrand == "brandId" && this.state.slugModel == "modelId") {
                    let comp_id = location.search
                        .split("&")[0]
                        .replace("?", "")
                        .split("=")[1];
                    let brand__id = location.search
                    .split("&")[1].replace("brandId=", "");
    
                    let model__id = location.search
                    .split("&")[2].replace("modelId=", "");

                    this.setState({
                        get_comp_id: comp_id,
                        get_brand__id: brand__id,
                        get_model__id: model__id 
                    }, () => {
                            if (this.state.get_comp_id.length > 0 && this.state.get_brand__id.length == 0  && this.state.get_model__id.length == 0 ) {
                                const data = {
                                    companyId: this.state.get_comp_id,
                                    brandId: this.state.get_brand__id,
                                    modelId: this.state.get_model__id
                                }
                                this.searchCarWithCompany(data);
                                document.addEventListener("scroll", this.searchCarWithCompanyScrollTrack);
                            }else if(this.state.get_comp_id.length > 0 && this.state.get_brand__id.length > 0  && this.state.get_model__id.length == 0 ){
                                const data = {
                                    companyId: this.state.get_comp_id,
                                    brandId: this.state.get_brand__id,
                                    modelId: this.state.get_model__id
                                }
                                   this.searchCarWithBrand(data);
                                   document.addEventListener("scroll", this.searchCarWithBrandScrollTrack);
                            }else if(this.state.get_comp_id.length > 0 && this.state.get_brand__id.length > 0  && this.state.get_model__id.length > 0){
                                const data = {
                                    companyId: this.state.get_comp_id,
                                    brandId: this.state.get_brand__id,
                                    modelId: this.state.get_model__id
                                }
                                   this.searchCarWithModel(data);
                                   document.addEventListener("scroll", this.searchCarWithModelScrollTrack);
                                   
                            }
                            else {
                                // loadAllProducts(this.state.selectedCategory);
                                const data = {
                                    companyId: this.state.get_comp_id,
                                    brandId: this.state.get_brand__id,
                                    modelId: this.state.get_model__id
                                }
                                this.fetchNullProducts(data);
                                document.addEventListener("scroll", this.searchCarWithNullCompanyTrack);
                            }
                    })  
                }
            })
            
        };
        let getOnsaleProducts = () => {
            let query = location.search
                .split("&")[0]
                .replace("?", "")
                .split("=")[1];
           document.getElementById("short").value = "onsale";
           this.setState({
             onSaleParamSkip: 0,
           }, ()=>{
            this.fetchOnSaleProduct(query);
            document.addEventListener("scroll", this.trackOnsaleProduct);
           })
        }      // check if page loaded as search redirect or normal
        if (location.search.split("&").length == 2) {
            searchProductsWithCategory();
        }else if(location.search.split("&").length == 4){
            searchProductWithCarFilter();
        } else if(location.search.split("&").length == 1 && location.search.length != 0){
           getOnsaleProducts();
        }else{
            loadAllProducts(this.state.selectedCategory);
        }
      
    }
    componentDidUpdate(prevProps, prevState) {
        if (prevState.products.length !== this.state.products.length) {
            if(this.state.trackScroll){
                document.addEventListener("scroll", this.trackScrolling);
            }else if(this.state.carSearch){
                document.addEventListener("scroll", this.scrollRecordByParams);
            }else if(this.state.trackParam){
                document.addEventListener("scroll", this.sortByParamScrollTrack);
            }else if(this.state.trackParamCat){
                document.addEventListener("scroll", this.sortByParamScrollTrackForCat);
            }else if(this.state.trackParamSubCat){
                document.addEventListener("scroll", this.sortByParamScrollTrackForSubCat);
            }else if(this.state.trackParamCarFilter){
                document.addEventListener("scroll", this.fetchSortingDataByParamScrollTrack);
            }else if(this.state.carEmptySearch){
                document.addEventListener("scroll", this.emptyCarSearchTrack);
            }else if(this.state.slugCategorySearch){
                 document.addEventListener("scroll", this.fetchMoreSearchProductDataByCategoryScrollTrack);
            }else if(this.state.searchCarWithCompanyStatus){
                document.addEventListener("scroll", this.searchCarWithCompanyScrollTrack);
           }else if(this.state.searchCarWithBrandStatus){
                document.addEventListener("scroll", this.searchCarWithBrandScrollTrack);
           }else if(this.state.searchCarWithModelStatus){
              document.addEventListener("scroll", this.searchCarWithModelScrollTrack);
           }else if(this.state.searchCarWithNullCompanyStatus){
            document.addEventListener("scroll", this.searchCarWithNullCompanyTrack);
         }else if(this.state.tarckOnsaleParam){
            document.addEventListener("scroll", this.trackOnsaleProduct);
         }
        }else if(prevState.items.length !== this.state.items.length){
            if(this.state.categoryScrollEnabled){
                document.addEventListener("scroll", this.scrollRecordCat);
            }else if(this.state.subCategoryScrollEnabled){
                document.addEventListener("scroll", this.scrollRecordSubCat);
            }
        }
    }
    componentWillUnmount() {
        document.removeEventListener("scroll", this.trackScrolling);
        document.removeEventListener("scroll", this.scrollRecordCat);
        document.removeEventListener("scroll", this.scrollRecordSubCat);
        document.removeEventListener("scroll", this.scrollRecordByParams);
        document.removeEventListener("scroll", this.sortByParamScrollTrack);
        document.removeEventListener("scroll", this.sortByParamScrollTrackForCat);
        document.removeEventListener("scroll", this.sortByParamScrollTrackForSubCat);
        document.removeEventListener("scroll", this.fetchSortingDataByParamScrollTrack);
        document.removeEventListener("scroll", this.emptyCarSearchTrack);
        document.removeEventListener("scroll", this.fetchMoreSearchProductDataByCategoryScrollTrack);
        document.removeEventListener("scroll", this.searchCarWithCompanyScrollTrack);
        document.removeEventListener("scroll", this.searchCarWithBrandScrollTrack);
        document.removeEventListener("scroll", this.searchCarWithModelScrollTrack);
        document.removeEventListener("scroll", this.searchCarWithNullCompanyTrack);
        document.addEventListener("scroll", this.trackOnsaleProduct);
    }
    async fetch(category_id = 0) {
        this.setState({
            loading: true
        });
        const skipCount = this.state.skip;
        const { data } = await axios.post(BASE_URL + "allProducts", {
            category_id,
            skipCount
        });
        this.setState({
            products: [...this.state.products, ...data],
            temp: false,
            trackParam: false,
            trackParamCat: false,
            trackParamSubCat: false,
            trackParamCarFilter: false,
            carSearch:false,
            carEmptySearch: false,
            slugCategorySearch: false,
            searchCarWithCompanyStatus: false,
            searchCarWithBrandStatus: false,
            searchCarWithModelStatus: false,
            searchCarWithNullCompanyStatus: false

        });
        this.setState({
            loading: false
        });
    }
    trackScrolling = () => {
     const scrollHistory = this.state.trackScroll; 
       if(scrollHistory){
        if (
            this.container.current.getBoundingClientRect().bottom <=
            window.innerHeight
          ) {
            this.setState({
                skip: this.state.skip + 8
            }, () => {
                this.fetch();
            })
            document.removeEventListener("scroll", this.trackScrolling);
          }
       }
    };
    async emptyCarSearch(getObjData){
        if(this.state.carEmptySkip > 0){
            this.setState({
                trackScroll: false,
                temp:false,
                loading: true,
                selectedCategory: 0,
                selectedSubCategory: 0,
                carSearch: false,
                carEmptySearch: true,
                trackParam: false,
                trackParamCat: false,
                trackParamSubCat: false,
                trackParamCarFilter: false,
                tarckOnsaleParam: false,
                categoryScrollEnabled:false,
                subCategoryScrollEnabled: false,
                slugCategorySearch: false,
                searchCarWithCompanyStatus: false,
                searchCarWithBrandStatus: false,
                searchCarWithModelStatus: false,
                searchCarWithNullCompanyStatus: false,
            }, async () =>{
                let skipCount = this.state.carEmptySkip;
                getObjData = Object.assign(getObjData, {"skipCount": skipCount});
                const { data } = await  axios.post(BASE_URL + "getProductsByProps", getObjData);
                this.setState({
                    products: [...this.state.products, ...data.latestProducts],
                    carSearch: false,
                    loading: false
                });
                document.getElementById("short").value = "";
                this.forceUpdate();
            })
        }else{
            this.setState({
                products: [],
                trackScroll: false,
                temp:false,
                loading: true,
                selectedCategory: 0,
                selectedSubCategory: 0,
                carSearch: false,
                carEmptySearch: true,
                trackParam: false,
                tarckOnsaleParam: false,
                trackParamCat: false,
                trackParamSubCat: false,
                trackParamCarFilter: false,
                categoryScrollEnabled:false,
                subCategoryScrollEnabled: false,
                slugCategorySearch: false,
                searchCarWithCompanyStatus: false,
                searchCarWithBrandStatus: false,
                searchCarWithModelStatus: false,
                searchCarWithNullCompanyStatus: false,
            }, async () =>{
                let skipCount = 0;
                getObjData = Object.assign(getObjData, {"skipCount": skipCount});
                const { data } = await  axios.post(BASE_URL + "getProductsByProps", getObjData);
                this.setState({
                    products: [...this.state.products, ...data.latestProducts],
                    carSearch: false,
                    carEmptySkip: 0,
                    loading: false,
                })
                document.getElementById("short").value = "";
                this.forceUpdate();
            })
        }   
    }
    emptyCarSearchTrack = () => {
        const scrollHistoryCarSearch = this.state.carEmptySearch; 
          if(scrollHistoryCarSearch){
           if (
               this.container.current.getBoundingClientRect().bottom <=
               window.innerHeight
             ) {
              const data = {
                        companyId: "",
                        brandId: "",
                        modelId: ""
                      }
              this.setState({
                carEmptySkip: this.state.carEmptySkip + 8,
                carEmptySearch: false
              });
              this.emptyCarSearch(data);
               document.removeEventListener("scroll", this.emptyCarSearchTrack);
             }
          }
    };
    async fetchMoreSearchProductDataByCategory (category_id, slug) {
        if(this.state.get_category_id !== category_id){
            this.setState({
                products: [],
                trackScroll: false,
                loading: true,
                temp:false,
                carSearch: false,
                carEmptySearch: false,
                trackParam: false,
                trackParamCat: false,
                tarckOnsaleParam: false,
                trackParamSubCat: false,
                trackParamCarFilter: false,
                categoryScrollEnabled: false,
                subCategoryScrollEnabled: false,
                slugCategorySearch: true,
                get_category_id: category_id,
                get_slug: slug,
                searchCarWithCompanyStatus: false,
                searchCarWithBrandStatus: false,
                searchCarWithModelStatus: false,
                searchCarWithNullCompanyStatus: false

            }, async () =>{
                const { data } = await  axios.post(BASE_URL + "searchByCategoryAjax", { category_id, slug, skipCount: 0 });
                this.setState({
                    products: [...this.state.products, ...data],
                    selectedCategory: category_id,
                    loading: false,
                    searchCarWithCompanyStatus: false,
                    searchCarWithBrandStatus: false,
                    searchCarWithModelStatus: false,
                    searchCarWithNullCompanyStatus: false
                })
            })
        }else{
            this.setState({
                loading: true,
            })
            const { data } = await  axios.post(BASE_URL + "searchByCategoryAjax", { category_id, slug, skipCount: this.state.slugCategorySearchSkip });
                this.setState({
                    products: [...this.state.products, ...data],
                    loading: false,
                    selectedCategory: category_id,
                    carSearch: false,
                    trackParam: false,
                    trackParamCat: false,
                    trackParamSubCat: false,
                    trackParamCarFilter: false,
                    tarckOnsaleParam: false,
                    carEmptySearch: false,
                    categoryScrollEnabled: false,
                    subCategoryScrollEnabled: false,
                    searchCarWithCompanyStatus: false,
                    searchCarWithBrandStatus: false,
                    searchCarWithModelStatus: false,
                    searchCarWithNullCompanyStatus: false

                })
        }
        // axios
        //     .post(BASE_URL + "searchByCategoryAjax", { category_id, slug })
        //     .then((response) => {
        //         this.setState({
        //             products: response.data,
        //             selectedCategory: category_id,
        //         });
        //     });
        // this.setState({
        //     products: [...this.state.products, ...data.latestProducts],
        // })
    }
    fetchMoreSearchProductDataByCategoryScrollTrack = () => {
          if(this.state.slugCategorySearch){
           if (
               this.container.current.getBoundingClientRect().bottom <=
               window.innerHeight
             ) {
              this.setState({
                slugCategorySearchSkip: this.state.slugCategorySearchSkip + 8
              });
              this.fetchMoreSearchProductDataByCategory(this.state.get_category_id, this.state.get_slug);
               document.removeEventListener("scroll", this.fetchMoreSearchProductDataByCategoryScrollTrack);
             }
          }
    };
    async fetchMoreDataForCat(id){
       if(this.state.getId !== id){
           this.setState({
               items: [],
               temp: true,
               trackScroll: false,
               carSearchStatus: true,
               loading: true,
               getId: id,
               selectedCategory: id,
               trackParam: false,
               trackParamCat: false,
               trackParamSubCat: false,
               trackParamCarFilter: false,
               carSearch: false,
               carEmptySearch: false,
               tarckOnsaleParam: false,
               categoryScrollEnabled: true,
               subCategoryScrollEnabled: false,
               skipCountWithCategory: 0,
               subCategoryScrollEnabled: false,
               slugCategorySearch: false,
               searchCarWithCompanyStatus: false,
               searchCarWithBrandStatus: false,
               searchCarWithModelStatus: false,
               searchCarWithNullCompanyStatus: false

           }, async () => {
               const {data} = await axios
               .post(BASE_URL + "shopByCat", {
                   id: id,
                   sortBy: this.state.sortBy,
                   skipCountCat: this.state.skipCountWithCategory
               });
                   this.setState({
                       items: [...this.state.items, ...data],
                       getId: id,
                       getSubCatId: null,
                       trackScroll: false,
                       loading: false,
                       selectedCategory: id,
                       selectedSubCategory: 0,
                       subCategoryScrollEnabled: false,
                       searchCarWithCompanyStatus: false,
                       searchCarWithBrandStatus: false,
                       searchCarWithNullCompanyStatus: false,
                       skipCountWithCategory: this.state.skipCountWithCategory
                   });
                   document.getElementById("short").value = "";
                   this.forceUpdate();
           });
       }else{
           this.setState({
               loading: true,
           })
        const {data} = await axios
        .post(BASE_URL + "shopByCat", {
            id: id,
            sortBy: this.state.sortBy,
            skipCountCat: this.state.skipCountWithCategory
        });
            this.setState({
                items: [...this.state.items, ...data],
                getId: id,
                loading: false,
                getSubCatId: null,
                categoryScrollEnabled: true,
                trackScroll: false,
                subCategoryScrollEnabled: false,
                carSearch: false,
                carEmptySearch: false,
                temp: true,
                trackParam: false,
                trackParamCat: false,
                trackParamSubCat: false,
                tarckOnsaleParam: false,
                trackParamCarFilter: false,
                searchCarWithCompanyStatus: false,
                searchCarWithBrandStatus: false,
                searchCarWithModelStatus: false,
                searchCarWithNullCompanyStatus: false,
                selectedCategory: id,
                selectedSubCategory: 0,
                skipCountWithCategory: this.state.skipCountWithCategory
            });
       }
      
        
    }
    async fetchMoreDataForSubCat(subCatId, catId){
        if(this.state.getSubCatId  !== subCatId ){
            this.setState({
                items: [],
                temp: true,
                loading: true,
                carSearch: false,
                carEmptySearch: false,
                trackParam: false,
                trackParamCat: false,
                trackParamSubCat: false,
                tarckOnsaleParam: false,
                trackParamCarFilter: false,
                carEmptySearch: false,
                getCatId: catId,
                getSubCatId: subCatId,
                categoryScrollEnabled: false,
                subCategoryScrollEnabled: true,
                skipCountWithSubCategory: 0,
                slugCategorySearch: false,
                searchCarWithCompanyStatus: false,
                searchCarWithBrandStatus: false,
                searchCarWithModelStatus: false,
                searchCarWithNullCompanyStatus: false
            }, async () => {
                const {data} = await axios
                .post(BASE_URL + "shopBySubCat", {
                    subCategory: subCatId,
                    category: catId,
                    skipCountSubCat: this.state.skipCountWithSubCategory
                });
                this.setState({
                    items: [...this.state.items, ...data],
                    getSubCatId: subCatId,
                    getCatId: catId,
                    loading: false,
                    getId: null,
                    trackScroll: false,
                    categoryScrollEnabled: false,
                    subCategoryScrollEnabled: true,
                    searchCarWithCompanyStatus: false,
                    searchCarWithBrandStatus: false,
                    searchCarWithModelStatus: false,
                    searchCarWithNullCompanyStatus: false,
                    selectedCategory: catId,
                    selectedSubCategory: subCatId,
                    skipCountWithSubCategory: this.state.skipCountWithSubCategory
                });
                document.getElementById("short").value = "";
                this.forceUpdate();
            });
        }else{
               this.setState({
                   loading: true
               })
                const {data} = await axios
                .post(BASE_URL + "shopBySubCat", {
                    subCategory: subCatId,
                    category: catId,
                    skipCountSubCat: this.state.skipCountWithSubCategory
                });
                this.setState({
                    items: [...this.state.items, ...data],
                    getSubCatId: subCatId,
                    getCatId: catId,
                    loading: false,
                    getId: null,
                    trackScroll: false,
                    temp: true,
                    carSearch: false,
                    carEmptySearch: false,
                    trackParam: false,
                    trackParamCat: false,
                    tarckOnsaleParam: false,
                    trackParamSubCat: false,
                    trackParamCarFilter: false,
                    carEmptySearch: false,
                    searchCarWithCompanyStatus: false,
                    searchCarWithBrandStatus: false,
                    searchCarWithModelStatus: false,
                    searchCarWithNullCompanyStatus: false,
                    categoryScrollEnabled: false,
                    subCategoryScrollEnabled: true,
                    selectedSubCategory: subCatId,
                    selectedCategory: catId,
                    skipCountWithSubCategory: this.state.skipCountWithSubCategory
                });
        }
       
         
     }
    async fetchMoreByParams(getObj){
        if(this.state.getCompanyId !== getObj.companyId && this.state.getBrandId == getObj.brandId && this.state.getModelId == getObj.modelId){
            this.setState({
                        products: [],
                        trackScroll: false,
                        temp:false,
                        loading: true,
                        selectedCategory: 0,
                        selectedSubCategory: 0,
                        carSearch: true,
                        carEmptySearch: false,
                        trackParam: false,
                        trackParamCat: false,
                        trackParamSubCat: false,
                        tarckOnsaleParam: false,
                        trackParamCarFilter: false,
                        subCategoryScrollEnabled: false,
                        slugCategorySearch: false,
                        searchCarWithCompanyStatus: false,
                        searchCarWithBrandStatus: false,
                        searchCarWithModelStatus: false,
                        searchCarWithNullCompanyStatus: false
                    },async () => {
                        let skipCount = 0;
                        getObj = Object.assign(getObj, {"skipCount":skipCount});
                        const { data } = await  axios.post(BASE_URL + "getProductsByProps", getObj);
                        this.setState({
                            products: [...this.state.products, ...data.latestProducts],
                            skipCountForCarSearch: 0,
                            getCompanyId: getObj.companyId,
                            getBrandId: getObj.brandId,
                            getModelId: getObj.modelId,
                            carEmptySearch: false,
                            loading: false

                        })
                        document.getElementById("short").value = "";
                        this.forceUpdate();
                    });
        }else if(this.state.getCompanyId !== getObj.companyId && this.state.getBrandId !== getObj.brandId && this.state.getModelId == getObj.modelId){
            this.setState({
                products: [],
                trackScroll: false,
                temp:false,
                loading: true,
                selectedCategory: 0,
                selectedSubCategory: 0,
                carSearch: true,
                tarckOnsaleParam: false,
                carEmptySearch: false,
                trackParam: false,
                trackParamCat: false,
                trackParamSubCat: false,
                trackParamCarFilter: false,
                subCategoryScrollEnabled: false,
                slugCategorySearch: false,
                searchCarWithCompanyStatus: false,
                searchCarWithBrandStatus: false,
                searchCarWithModelStatus: false,
                searchCarWithNullCompanyStatus: false

            },async () => {
                let skipCount = 0;
                getObj = Object.assign(getObj, {"skipCount":skipCount});
                const { data } = await  axios.post(BASE_URL + "getProductsByProps", getObj);
                this.setState({
                    products: [...this.state.products, ...data.latestProducts],
                    skipCountForCarSearch: 0,
                    getCompanyId: getObj.companyId,
                    getBrandId: getObj.brandId,
                    getModelId: getObj.modelId,
                    carEmptySearch: false,
                    loading: false
                })
                document.getElementById("short").value = "";
                this.forceUpdate();
            });
        }else if(this.state.getCompanyId == getObj.companyId && this.state.getBrandId !== getObj.brandId && this.state.getModelId == getObj.modelId){
            this.setState({
                products: [],
                trackScroll: false,
                temp:false,
                selectedCategory: 0,
                selectedSubCategory: 0,
                carSearch: true,
                loading: true,
                tarckOnsaleParam: false,
                carEmptySearch: false,
                trackParam: false,
                trackParamCat: false,
                trackParamSubCat: false,
                trackParamCarFilter: false,
                subCategoryScrollEnabled: false,
                slugCategorySearch: false,
                searchCarWithCompanyStatus: false,
                searchCarWithBrandStatus: false,
                searchCarWithModelStatus: false,
                searchCarWithNullCompanyStatus: false

            },async () => {
                let skipCount = 0;
                getObj = Object.assign(getObj, {"skipCount":skipCount});
                const { data } = await  axios.post(BASE_URL + "getProductsByProps", getObj);
                this.setState({
                    products: [...this.state.products, ...data.latestProducts],
                    skipCountForCarSearch: 0,
                    getCompanyId: getObj.companyId,
                    getBrandId: getObj.brandId,
                    getModelId: getObj.modelId,
                    carEmptySearch: false,
                    loading: false
                })
                document.getElementById("short").value = "";
                this.forceUpdate();
            });
        }else if(this.state.getCompanyId == getObj.companyId && this.state.getBrandId == getObj.brandId && this.state.getModelId !== getObj.modelId){
            this.setState({
                products: [],
                trackScroll: false,
                temp:false,
                loading: true,
                selectedCategory: 0,
                selectedSubCategory: 0,
                carSearch: true,
                tarckOnsaleParam: false,
                carEmptySearch: false,
                trackParam: false,
                trackParamCat: false,
                trackParamSubCat: false,
                trackParamCarFilter: false,
                subCategoryScrollEnabled: false,
                slugCategorySearch: false,
                searchCarWithCompanyStatus: false,
                searchCarWithBrandStatus: false,
                searchCarWithModelStatus: false,
                searchCarWithNullCompanyStatus: false

            },async () => {
                let skipCount = 0;
                getObj = Object.assign(getObj, {"skipCount":skipCount});
                const { data } = await  axios.post(BASE_URL + "getProductsByProps", getObj);
                this.setState({
                    products: [...this.state.products, ...data.latestProducts],
                    skipCountForCarSearch: 0,
                    getCompanyId: getObj.companyId,
                    getBrandId: getObj.brandId,
                    getModelId: getObj.modelId,
                    carEmptySearch: false,
                    loading: false
                })
                document.getElementById("short").value = "";
                this.forceUpdate();
            });
        }else if(this.state.getCompanyId !== getObj.companyId && this.state.getBrandId !== getObj.brandId && this.state.getModelId !== getObj.modelId){
            this.setState({
                products: [],
                trackScroll: false,
                temp:false,
                loading: true,
                selectedCategory: 0,
                selectedSubCategory: 0,
                carSearch: true,
                carEmptySearch: false,
                trackParam: false,
                tarckOnsaleParam: false,
                trackParamCat: false,
                trackParamSubCat: false,
                trackParamCarFilter: false,
                subCategoryScrollEnabled: false,
                slugCategorySearch: false,
                searchCarWithCompanyStatus: false,
                searchCarWithBrandStatus: false,
                searchCarWithModelStatus: false,
                searchCarWithNullCompanyStatus: false

            },async () => {
                let skipCount = 0;
                getObj = Object.assign(getObj, {"skipCount":skipCount});
                const { data } = await  axios.post(BASE_URL + "getProductsByProps", getObj);
                this.setState({
                    products: [...this.state.products, ...data.latestProducts],
                    skipCountForCarSearch: 0,
                    getCompanyId: getObj.companyId,
                    getBrandId: getObj.brandId,
                    getModelId: getObj.modelId,
                    carEmptySearch: false,
                    loading: false
                })
                document.getElementById("short").value = "";
                this.forceUpdate();
            });
        }else{
            this.setState({
                loading: true
            })
            let skipCount = this.state.skipCountForCarSearch;
            getObj = Object.assign(getObj, {"skipCount": skipCount});
            const { data } = await  axios.post(BASE_URL + "getProductsByProps", getObj);
            this.setState({
                products: [...this.state.products, ...data.latestProducts],
                trackScroll: false,
                temp:false,
                loading: false,
                selectedCategory: 0,
                selectedSubCategory: 0,
                carSearch: true,
                carEmptySearch: false,
                trackParam: false,
                trackParamCat: false,
                trackParamSubCat: false,
                trackParamCarFilter: false,
                tarckOnsaleParam: false,
                subCategoryScrollEnabled: false,
                slugCategorySearch: false,
                getCompanyId: getObj.companyId,
                getBrandId: getObj.brandId,
                getModelId: getObj.modelId,
                searchCarWithCompanyStatus: false,
                searchCarWithBrandStatus: false,
                searchCarWithModelStatus: false,
                searchCarWithNullCompanyStatus: false

            })
            document.getElementById("short").value = "";
            this.forceUpdate();
        }
    }
    async sortMoreDataByParam(sortParam){
        if(this.state.setParam !== sortParam){
            this.setState({
                products: [],
                temp: false,
                loading: true,
                carSearch: false,
                categoryScrollEnabled: false,
                subCategoryScrollEnabled: false,
                trackScroll: false,
                slugCategorySearch: false,
                trackParam: true,
                trackParamCat: false,
                trackParamSubCat: false,
                trackParamCarFilter: false,
                carEmptySearch: false,
                tarckOnsaleParam: false,
                sortParamSkip: 0,
                searchCarWithCompanyStatus: false,
                searchCarWithBrandStatus: false,
                searchCarWithModelStatus: false,
                searchCarWithNullCompanyStatus: false

            }, async ()=>{
                const {data} = await axios
                .post(BASE_URL + "sortProductByParam", {
                    param: sortParam,
                    category: this.state.selectedCategory,
                    itemsCountPerPage: this.state.itemsCountPerPage,
                    slugData: this.state.get_slug,
                    skipCount: this.state.sortParamSkip,
                });
    
                this.setState({
                    products: [...this.state.products, ...data],
                    setParam: sortParam,
                    setParamCat: undefined,
                    setParamSubCat: undefined,
                    setParamCarFilter: undefined,
                    setOnSaleParam: undefined,
                    
                    loading: false,

                })
            })
        }
        else{
            this.setState({
                loading: true
            })
                const {data} = await axios
                .post(BASE_URL + "sortProductByParam", {
                    param: sortParam,
                    category: this.state.selectedCategory,
                    itemsCountPerPage: this.state.itemsCountPerPage,
                    slugData: this.state.get_slug,
                    skipCount: this.state.sortParamSkip,
                });
    
                this.setState({
                    products: [...this.state.products, ...data],
                    trackParam: true,
                    trackParamCat: false,
                    trackParamSubCat: false,
                    trackParamCarFilter: false,
                    tarckOnsaleParam: false,
                    setParam: sortParam,
                    setParamCat: undefined,
                    setParamSubCat:undefined,
                    setParamCarFilter: undefined,
                    setOnSaleParam: undefined,
                    loading: false,
                    categoryScrollEnabled: false,
                    subCategoryScrollEnabled: false,
                    carEmptySearch: false,
                    searchCarWithCompanyStatus: false,
                    searchCarWithBrandStatus: false,
                    searchCarWithModelStatus: false,
                    searchCarWithNullCompanyStatus: false

                })
        }
        
    }
    async sortMoreDataByParamForCat(sortParamForCat){
        if(this.state.setParamCat !== sortParamForCat){
            this.setState({
                products: [],
                temp: false,
                loading: true,
                carSearch: false,
                subCategoryScrollEnabled: false,
                trackScroll: false,
                trackParam: false,
                trackParamCat: true,
                trackParamSubCat: false,
                trackParamCarFilter: false,
                carEmptySearch: false,
                tarckOnsaleParam: false,
                slugCategorySearch: false,
                sortParamSkipCat: 0,
                searchCarWithCompanyStatus: false,
                searchCarWithBrandStatus: false,
                searchCarWithModelStatus: false,
                searchCarWithNullCompanyStatus: false

            }, async ()=>{
                const {data} = await axios
                .post(BASE_URL + "sortProductByParam", {
                    param: sortParamForCat,
                    category: this.state.selectedCategory,
                    itemsCountPerPage: this.state.itemsCountPerPage,
                    slugData: this.state.get_slug,
                    skipCount: this.state.sortParamSkipCat,
                    
                });
    
                this.setState({
                    products: [...this.state.products, ...data],
                    setParamCat: sortParamForCat,
                    setParam: undefined,
                    setParamSubCat: undefined,
                    setParamCarFilter: undefined,
                    setOnSaleParam: undefined,
                    loading: false,

                })

            })
        }
        else{
            this.setState({
                loading: true
            })
                const {data} = await axios
                .post(BASE_URL + "sortProductByParam", {
                    param: sortParamForCat,
                    category: this.state.selectedCategory,
                    itemsCountPerPage: this.state.itemsCountPerPage,
                    slugData: this.state.get_slug,
                    skipCount: this.state.sortParamSkipCat,
                });
                this.setState({
                    products: [...this.state.products, ...data],
                    setParamCat: sortParamForCat,
                    setParam: undefined,
                    setParamSubCat: undefined,
                    setParamCarFilter: undefined,
                    setOnSaleParam: undefined,
                    loading: false,
                    trackParam: false,
                    trackParamCat:true,
                    trackParamSubCat: false,
                    trackParamCarFilter: false,
                    tarckOnsaleParam: false,
                    carEmptySearch: false,
                    categoryScrollEnabled: false,
                    subCategoryScrollEnabled: false,
                    searchCarWithCompanyStatus: false,
                    searchCarWithBrandStatus: false,
                    searchCarWithModelStatus: false,
                    searchCarWithNullCompanyStatus: false


                })
        }
        
    }
    async sortMoreDataByParamForSubCat(sortParamForSubCat){
        if(this.state.setParamSubCat !== sortParamForSubCat){
            this.setState({
                products: [],
                temp: false,
                carSearch: false,
                loading: true,
                categoryScrollEnabled: false,
                subCategoryScrollEnabled: false,
                trackScroll: false,
                trackParam: false,
                trackParamCat: false,
                tarckOnsaleParam: false,
                trackParamSubCat: true,
                trackParamCarFilter: false,
                carEmptySearch: false,
                slugCategorySearch: false,
                sortParamSkipSubCat: 0,
                searchCarWithCompanyStatus: false,
                searchCarWithBrandStatus: false ,
                searchCarWithModelStatus: false,
                searchCarWithNullCompanyStatus: false

    
            }, async () =>{
                const {data} = await axios
                .post(BASE_URL + "sortProductByParam", {
                    param: sortParamForSubCat,
                    category: this.state.selectedCategory,
                    subCategory: this.state.selectedSubCategory,
                    itemsCountPerPage: this.state.itemsCountPerPage,
                    skipCount: this.state.sortParamSkipSubCat,
                });
                this.setState({
                    products: [...this.state.products, ...data],
                    setParam: undefined,
                    setParamCat: undefined,
                    setParamCarFilter: undefined,
                    setOnSaleParam: undefined,
                    setParamSubCat: sortParamForSubCat,
                    loading: false,

                })
            })
        }
        else{
            this.setState({
                loading: true
            })
                const {data} = await axios
                .post(BASE_URL + "sortProductByParam", {
                    param: sortParamForSubCat,
                    category: this.state.selectedCategory,
                    subCategory: this.state.selectedSubCategory,
                    itemsCountPerPage: this.state.itemsCountPerPage,
                    skipCount: this.state.sortParamSkipSubCat,
                });
                this.setState({
                    products: [...this.state.products, ...data],
                    loading: false,
                    trackParam: false,
                    trackParamCat: false,
                    trackParamSubCat: true,
                    trackParamCarFilter: false,
                    tarckOnsaleParam: false,
                    setParam: undefined,
                    setParamCat: undefined,
                    setParamCarFilter: undefined,
                    setOnSaleParam: undefined,
                    setParamSubCat: sortParamForSubCat,
                    carEmptySearch: false,
                    categoryScrollEnabled: false,
                    subCategoryScrollEnabled: false,
                    searchCarWithCompanyStatus: false,
                    searchCarWithBrandStatus: false,
                    searchCarWithModelStatus: false,
                    searchCarWithNullCompanyStatus: false

                })
        }
        
    }
    async fetchSortingDataByParam(sortParamCarfilter){
        if(this.state.setParamCarFilter !== sortParamCarfilter){
            this.setState({
                products: [],
                temp: false,
                carSearch: false,
                loading: true,
                categoryScrollEnabled: false,
                subCategoryScrollEnabled: false,
                trackScroll: false,
                carEmptySearch: false,
                trackParamCat: false,
                trackParam: false,
                trackParamSubCat: false,
                trackParamCarFilter: true,
                 tarckOnsaleParam: false,
                sortParamCarFilterSkip: 0,
                setParamCarFilter: sortParamCarfilter,
                slugCategorySearch: false,
                searchCarWithCompanyStatus: false,
                searchCarWithBrandStatus: false,
                searchCarWithModelStatus: false,
                searchCarWithNullCompanyStatus: false


            }, async ()=>{
                const {data} = await axios
                .post(BASE_URL + "sortProductByParam", {
                    is_searched: 1,
                    param: sortParamCarfilter,
                    category: this.state.selectedCategory,
                    comapny_id: this.state.getCompanyId,
                    brand_id: this.state.getBrandId,
                    model_id: this.state.getModelId,
                    slugData: this.state.get_slug,
                    itemsCountPerPage: this.state.itemsCountPerPage,
                    skipCount: this.state.sortParamCarFilterSkip,
                });
                
                this.setState({
                    products: [...this.state.products, ...data],
                    loading: false,
                    setParam: undefined,
                    setParamCat: undefined,
                    setParamSubCat: undefined,
                    setOnSaleParam: undefined,
                    
                })
            })
        }
        else{
            this.setState({
                loading: true,
            })
                const {data} = await axios
                .post(BASE_URL + "sortProductByParam", {
                    is_searched: 1,
                    param: sortParamCarfilter,
                    category: this.state.selectedCategory,
                    comapny_id: this.state.getCompanyId,
                    brand_id: this.state.getBrandId,
                    model_id: this.state.getModelId,
                    slugData: this.state.get_slug,
                    itemsCountPerPage: this.state.itemsCountPerPage,
                    skipCount: this.state.sortParamCarFilterSkip,
                });
    
                this.setState({
                    products: [...this.state.products, ...data],
                    loading: false,
                    setParam: undefined,
                    setParamCat: undefined,
                    setParamSubCat: undefined,
                    setOnSaleParam: undefined,
                    setParamCarFilter: sortParamCarfilter,
                    trackParamCat: false,
                    trackParam: false,
                    trackParamSubCat: false,
                    trackParamCarFilter: true,
                    tarckOnsaleParam: false,
                    carEmptySearch: false,
                    categoryScrollEnabled: false,
                    subCategoryScrollEnabled: false,
                    searchCarWithCompanyStatus: false,
                    searchCarWithBrandStatus: false,
                    searchCarWithModelStatus: false,
                    searchCarWithNullCompanyStatus: false

                })
        }
        
    }
    async searchCarWithCompany(getData){
          this.setState({
            trackScroll: false,
            temp:false,
            carSearch: false,
            loading: true,
            carEmptySearch: false,
            trackParam: false,
            trackParamCat: false,
            trackParamSubCat: false,
            trackParamCarFilter: false,
            tarckOnsaleParam: false,
            categoryScrollEnabled: false,
            subCategoryScrollEnabled: false,
            slugCategorySearch: false,
            searchCarWithBrandStatus: false,
            searchCarWithModelStatus: false,
            searchCarWithNullCompanyStatus: false,
            searchCarWithCompanyStatus: true,
            getComId: getData.companyId
        }, async () =>{
            let skipCount = this.state.searchCarWithCompanySkip;
            getData = Object.assign(getData, {"skipCount": skipCount});
            const { data } = await  axios.post(BASE_URL + "getProductsByProps", getData);
            this.setState({
                products: [...this.state.products, ...data.latestProducts],
                loading: false,
                getCompanyId: getData.companyId

            })
        })
    }
    searchCarWithCompanyScrollTrack = () => {
        
          if(this.state.searchCarWithCompanyStatus){
           if (
               this.container.current.getBoundingClientRect().bottom <=
               window.innerHeight
             ) {
              const data = {
                        companyId: this.state.getComId,
                        brandId: "",
                        modelId: ""
                      }
              this.setState({
                searchCarWithCompanySkip: this.state.searchCarWithCompanySkip + 8
              });
              this.searchCarWithCompany(data);
               document.removeEventListener("scroll", this.searchCarWithCompanyScrollTrack);
             }
          }
    }
    async searchCarWithBrand(getData){
        this.setState({
          trackScroll: false,
          temp:false,
          loading: true,
          carSearch: false,
          carEmptySearch: false,
          trackParam: false,
          trackParamCat: false,
          trackParamSubCat: false,
          trackParamCarFilter: false,
          tarckOnsaleParam: false,
          categoryScrollEnabled: false,
          subCategoryScrollEnabled: false,
          slugCategorySearch: false,
          searchCarWithCompanyStatus: false,
          searchCarWithModelStatus: false,
          searchCarWithNullCompanyStatus: false,
          searchCarWithBrandStatus: true,
          getComId: getData.companyId,
          getBrand: getData.brandId
      }, async () =>{
          let skipCount = this.state.searchCarWithBrandSkip;
          getData = Object.assign(getData, {"skipCount": skipCount});
          const { data } = await  axios.post(BASE_URL + "getProductsByProps", getData);
          this.setState({
              products: [...this.state.products, ...data.latestProducts],
              loading: false,
              getCompanyId: getData.companyId,
              getBrandId: getData.brandId
          })
      })
  }
    searchCarWithBrandScrollTrack = () => {
            if(this.state.searchCarWithBrandStatus){
            if (
                this.container.current.getBoundingClientRect().bottom <=
                window.innerHeight
            ) {
                const data = {
                        companyId: this.state.getComId,
                        brandId: this.state.getBrand,
                        modelId: ""
                        }
                this.setState({
                    searchCarWithBrandSkip: this.state.searchCarWithBrandSkip + 8
                });
                this.searchCarWithBrand(data);
                document.removeEventListener("scroll", this.searchCarWithBrandScrollTrack);
            }
            }
    }
    async searchCarWithModel(getData){
        this.setState({
            trackScroll: false,
            temp:false,
            loading: true,
            carSearch: false,
            carEmptySearch: false,
            trackParam: false,
            trackParamCat: false,
            trackParamSubCat: false,
            trackParamCarFilter: false,
            tarckOnsaleParam: false,
            categoryScrollEnabled: false,
            subCategoryScrollEnabled: false,
            slugCategorySearch: false,
            searchCarWithCompanyStatus: false,
            searchCarWithBrandStatus: false,
            searchCarWithNullCompanyStatus: false,
            searchCarWithModelStatus: true,
            getComId: getData.companyId,
            getBrand: getData.brandId,
            getModel: getData.modelId,
        }, async () =>{
            let skipCount = this.state.searchCarWithModelSkip;
            getData = Object.assign(getData, {"skipCount": skipCount});
            const { data } = await  axios.post(BASE_URL + "getProductsByProps", getData);
            this.setState({
                products: [...this.state.products, ...data.latestProducts],
                loading: false,
                getCompanyId: getData.companyId,
                getBrandId: getData.brandId,
                getModelId: getData.modelId,


            })
        }) 
    }
    searchCarWithModelScrollTrack = () => {
        if(this.state.searchCarWithModelStatus){
            if (
                this.container.current.getBoundingClientRect().bottom <=
                window.innerHeight
            ) {
                const data = {
                        companyId: this.state.getComId,
                        brandId: this.state.getBrand,
                        modelId: this.state.getModel
                        }
                this.setState({
                    searchCarWithModelSkip: this.state.searchCarWithModelSkip + 8
                });
                this.searchCarWithModel(data);
                document.removeEventListener("scroll", this.searchCarWithModelScrollTrack);
            }
        }
    } 
    async fetchNullProducts (getData){
        this.setState({
            trackScroll: false,
            temp:false,
            carSearch: false,
            loading: true,
            carEmptySearch: false,
            trackParam: false,
            trackParamCat: false,
            trackParamSubCat: false,
            trackParamCarFilter: false,
            tarckOnsaleParam: false,
            categoryScrollEnabled: false,
            subCategoryScrollEnabled: false,
            slugCategorySearch: false,
            searchCarWithCompanyStatus: false,
            searchCarWithBrandStatus: false,
            searchCarWithModelStatus: false,
            searchCarWithNullCompanyStatus: true,
            getComId: getData.companyId,
            getBrand: getData.brandId,
            getModel: getData.modelId,
        }, async () =>{
            let skipCount = this.state.searchCarWithNullCompanySkip;
            getData = Object.assign(getData, {"skipCount": skipCount});
            const { data } = await  axios.post(BASE_URL + "getProductsByProps", getData);
            this.setState({
                products: [...this.state.products, ...data.latestProducts],
                loading: false,
                getCompanyId: "",
                getBrandId: "",
                getModelId: ""
            })
        }) 
    }
    async fetchOnSaleProduct(onsaleParam){
        console.log("state", this.state);
        if(this.state.setOnSaleParam != onsaleParam){
            this.setState({
                products: [],
                temp: false,
                carSearch: false,
                loading: true,
                categoryScrollEnabled: false,
                subCategoryScrollEnabled: false,
                trackScroll: false,
                trackParam: false,
                trackParamCat: false,
                trackParamSubCat: false,
                tarckOnsaleParam: true,
                trackParamCarFilter: false,
                carEmptySearch: false,
                slugCategorySearch: false,
                onSaleParamSkip: 0,
                searchCarWithCompanyStatus: false,
                searchCarWithBrandStatus: false ,
                searchCarWithModelStatus: false,
                searchCarWithNullCompanyStatus: false
            }, async ()=> {
                const {data} = await axios
                .post(BASE_URL + "sortProductByParam", {
                    param: onsaleParam,
                    category: this.state.selectedCategory,
                    itemsCountPerPage: this.state.itemsCountPerPage,
                    slugData: this.state.get_slug,
                    skipCount: this.state.onSaleParamSkip,
                });
                this.setState({
                    products: [...this.state.products, ...data],
                    loading: false,
                    setParam: undefined,
                    setParamCat: undefined,
                    setParamCarFilter: undefined,
                    setOnSaleParam: onsaleParam
                })
            })
            
        }else{
            this.setState({
                loading: true,
            });
            const {data} = await axios
            .post(BASE_URL + "sortProductByParam", {
                param: onsaleParam,
                category: this.state.selectedCategory,
                itemsCountPerPage: this.state.itemsCountPerPage,
                slugData: this.state.get_slug,
                skipCount: this.state.onSaleParamSkip,
            });
            this.setState({
                products: [...this.state.products, ...data],
                setParam: undefined,
                setParamCat: undefined,
                setParamCarFilter: undefined,
                setOnSaleParam: onsaleParam,
                loading: false
            });
        }
        
    }
    trackOnsaleProduct = ()=>{
        if(this.state.tarckOnsaleParam){
            if (
                this.container.current.getBoundingClientRect().bottom <=
                window.innerHeight
            ) {
                this.setState({
                    onSaleParamSkip: this.state.onSaleParamSkip + 8
                });
                this.fetchOnSaleProduct(this.state.setOnSaleParam);
                document.removeEventListener("scroll", this.trackOnsaleProduct);
            }
        }
    }
    searchCarWithNullCompanyTrack = () => {
        if(this.state.searchCarWithNullCompanyStatus){
            if (
                this.container.current.getBoundingClientRect().bottom <=
                window.innerHeight
            ) {
                const data = {
                        companyId: "",
                        brandId: "",
                        modelId: ""
                        }
                this.setState({
                    searchCarWithNullCompanySkip: this.state.searchCarWithNullCompanySkip + 8
                });
                this.fetchNullProducts(data);
                document.removeEventListener("scroll", this.searchCarWithNullCompanyTrack);
            }
        }
    } 
    scrollRecordCat = () =>{
        if(this.state.categoryScrollEnabled){
            if (
                this.container.current.getBoundingClientRect().bottom <=
                window.innerHeight
              ){
                this.setState({
                    skipCountWithCategory: this.state.skipCountWithCategory + 8
                });
                this.fetchMoreDataForCat(this.state.getId);
                  document.removeEventListener("scroll", this.scrollRecordCat);
              }
        }
    }
    scrollRecordSubCat = () =>{
        if(this.state.subCategoryScrollEnabled){
            if (
                this.container.current.getBoundingClientRect().bottom <=
                window.innerHeight
              ){
                this.setState({
                    skipCountWithSubCategory: this.state.skipCountWithSubCategory + 8
                });
                this.fetchMoreDataForSubCat(this.state.getSubCatId, this.state.getCatId);
                  document.removeEventListener("scroll", this.scrollRecordSubCat);
              }
        }
    }
    scrollRecordByParams = () =>{

        if(this.state.carSearch){
            if (
                this.container.current.getBoundingClientRect().bottom <=
                window.innerHeight
              ){
                  const data = {
                    companyId: this.state.getCompanyId,
                    brandId: this.state.getBrandId,
                    modelId: this.state.getModelId
                  }
                  this.setState({
                    skipCountForCarSearch: this.state.skipCountForCarSearch + 8
                  });
                  this.fetchMoreByParams(data);
                  document.removeEventListener("scroll", this.scrollRecordByParams);
              }
        }
    }
    sortByParamScrollTrack = () =>{
        if(this.state.trackParam){
            if (
                this.container.current.getBoundingClientRect().bottom <=
                window.innerHeight
              ){
                  this.setState({
                    sortParamSkip: this.state.sortParamSkip + 8
                  });
                  this.sortMoreDataByParam(this.state.setParam);
                  document.removeEventListener("scroll", this.sortByParamScrollTrack);
              }
        }
    }
    sortByParamScrollTrackForCat = () =>{
        if(this.state.trackParamCat){
            if (
                this.container.current.getBoundingClientRect().bottom <=
                window.innerHeight
              ){
                  this.setState({
                    sortParamSkipCat: this.state.sortParamSkipCat + 8
                  });
                  this.sortMoreDataByParamForCat(this.state.setParamCat);
                  document.removeEventListener("scroll", this.sortByParamScrollTrackForCat);
              }
        }
    }
    sortByParamScrollTrackForSubCat = () =>{
        if(this.state.trackParamSubCat){
            if (
                this.container.current.getBoundingClientRect().bottom <=
                window.innerHeight
              ){
                  this.setState({
                    sortParamSkipSubCat: this.state.sortParamSkipSubCat+ 8
                  });
                  this.sortMoreDataByParamForSubCat(this.state.setParamSubCat);
                  document.removeEventListener("scroll", this.sortByParamScrollTrackForSubCat);
              }
        }
    }
    fetchSortingDataByParamScrollTrack = () =>{
        if(this.state.trackParamCarFilter){
            if (
                this.container.current.getBoundingClientRect().bottom <=
                window.innerHeight
              ){
                  this.setState({
                    sortParamCarFilterSkip: this.state.sortParamCarFilterSkip + 8
                  });
                  this.fetchSortingDataByParam(this.state.setParamCarFilter);
                  document.removeEventListener("scroll", this.fetchSortingDataByParamScrollTrack);
              }
        }
    }
    handlePageChange(pageNumber) {
        axios
            .post(BASE_URL + "allProducts?page=" + pageNumber, {
                category_id: this.state.selectedCategory,
                subcategory_id: this.state.selectedSubCategory,
                sortBy: this.state.sortBy
            })
            .then((response) => {
                this.setState({ 
                    products: response.data.data,
                    itemsCountPerPage: response.data.per_page,
                    totalItemsCount: response.data.total,
                    activePage: response.data.current_page,
                });
            });
    }
    render() {
        return (
            <div>
                <Header/>
                <div className="shop_area" ref={this.container}>
                    <div className="container">
                        <div className="row">
                            <SidebarContainer
                                getCategoriesData={this.getCategoriesData}
                                getSubCategoriesData={this.getSubCategoriesData}
                                selectedCategory={this.state.selectedCategory}
                                selectedSubCategory={this.state.selectedSubCategory}
                            />
                            <ShopSearchProductContainer
                                CarFilter={CarFilter}
                                companies={this.state.companies}
                                searchCar={this.searchCar}
                                products={this.state.temp ? this.state.items : this.state.products}
                                carSearchStatus = {this.state.carSearchStatus}
                                loading = {this.state.loading}
                                sortProductByParam={this.sortProductByParam}
                                setCarFilterParams={this.setCarFilterParams}
                            />
                        </div>
                    </div>
                </div>

                {/* <div id="pagination__sm" style={{ paddingLeft: "50%" }}>
                    <Pagination
                        activePage={this.state.activePage}
                        itemsCountPerPage={this.state.itemsCountPerPage}
                        totalItemsCount={this.state.totalItemsCount}
                        pageRangeDisplayed={ Math.ceil(this.state.totalItemsCount / this.state.itemsCountPerPage) }
                        onChange={this.handlePageChange.bind(this)}
                        itemClass="page-item"
                        linkClass="page-link"
                    />
                </div> */}
                <ProductDetailModal />
            </div>
        );
    }
}

if (document.getElementById("shopApp")) {
    ReactDOM.render(<Shop />, document.getElementById("shopApp"));
}
