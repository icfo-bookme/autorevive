import React, { Component } from "react";
import ReactDOM from "react-dom";
import Header from "../homepageComponents/Header";
import SidebarContainer from "../ShopComponents/SidebarContainer";
import ShopSearchProductContainer from "../ShopComponents/ShopSearchProductContainer";
import { BASE_URL } from "../config/Constants";
import ProductDetailModal from "../homepageComponents/ProductDetailModal";
import { Collapse } from "bootstrap";

class ShopbyCat extends Component {
    constructor() {
        super();
        this.state = {
            products: [],
            count: 0,
            selectedCategory: undefined,
            selectedSubCategory: undefined,
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
            items: [],
            skip: 0,
            loading: true,
            trackScroll: true,
            skipCountWithCategory: 0,
            skipCountWithSubCategory: 0,
            getId: null,
            reachedBottom: false,
            countEntry: 0,
            skipTemp: null,
            temp: false,
            getCatId: null,
            getSubCatId: null,
            categoryScrollEnabled: false,
            subCategoryScrollEnabled: false,
            carSearch: false,
            sortByParamSkip: 0,
            sortingParam: '',
            setParam: undefined,
            setParamCat: undefined,
            setParamSubCat: undefined,
            trackParam: false,
            trackParamCat: false,
            trackParamSubCat: false,
            sortParamSkip: 0,
            sortParamSkipCat: 0,
            sortParamSkipSubCat: 0,
        };

        this.getCategoriesData = this.getCategoriesData.bind(this);
        this.getSubCategoriesData = this.getSubCategoriesData.bind(this);
        this.sortProductByParam = this.sortProductByParam.bind(this);
        this.fetchCatData = this.fetchCatData.bind(this);
        this.trackScrolling = this.trackScrolling.bind(this);
        this.fetchMoreDataForCat = this.fetchMoreDataForCat.bind(this);
        this.scrollRecordCat = this.scrollRecordCat.bind(this);
        this.fetchMoreDataForSubCat = this.fetchMoreDataForSubCat.bind(this);
        this.scrollRecordSubCat = this.scrollRecordSubCat.bind(this);
        this.container = React.createRef();

    }
    componentDidMount(){
        this.fetchCatData();
        document.addEventListener("scroll", this.trackScrolling);
    }
    componentDidUpdate(prevProps, prevState) {
        if (prevState.products.length !== this.state.products.length) {
            if(this.state.trackScroll){
                document.addEventListener("scroll", this.trackScrolling);
            }else if(this.state.trackParam){
                document.addEventListener("scroll", this.sortByParamScrollTrack);
            }else if(this.state.trackParamCat){
                document.addEventListener("scroll", this.sortByParamScrollTrackForCat);
            }else if(this.state.trackParamSubCat){
                document.addEventListener("scroll", this.sortByParamScrollTrackForSubCat);
            }
        }else if(prevState.items.length !== this.state.items.length){
            if( this.state.categoryScrollEnabled){
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
    }
    async fetchCatData () {
        if (location.href.split("/")[3] === "shopByCategory") {
            let category_id = location.href.split("/")[4];
            if (category_id != undefined) {
                // let URL = BASE_URL + "shopByCategoryAjax/" + category_id;
                this.setState({
                    loading: true,
                })
                const skip_count = this.state.skip;
                const { data } = await axios.post(BASE_URL + "shopByCategoryAjax", {
                    category_id,
                    skip_count
                });
                this.setState({
                    products: [...this.state.products, ...data],
                    selectedCategory: category_id,
                    loading: false
                });
            }

        }
        else if (location.href.split("/")[3] === "shopBySubCategory") {
            let sub_category_id = location.href.split("/")[4];
            if (sub_category_id != undefined) {
                this.setState({
                    loading: true
                })
                const skip_count = this.state.skip;
                const { data } = await axios.post(BASE_URL + "shopBySubCategoryAjax", {
                    sub_category_id,
                    skip_count
                });
                this.setState({
                    products: [...this.state.products, ...data],
                    selectedSubCategory: sub_category_id,
                    loading: false
                });
                console.log("data from shop by sub cat", this.state.products);
               
            }
        }
        // console.log("data from fetchCatData ", this.state.products);
    }

    trackScrolling = () => {
       if(this.container.current.getBoundingClientRect().bottom <= window.innerHeight){
        //    console.log("we are at the bottom");
           this.setState({
            skip: this.state.skip + 8
        }, () => {
            this.fetchCatData();
            //console.log(this.state.skip)
        })
           document.removeEventListener("scroll", this.trackScrolling);
       }
    }
    getCategoriesData = (id) => {
        if (id == "all_products") {
            window.location.href = BASE_URL + "shopview";
        } else {
            this.fetchMoreDataForCat(id);
            document.addEventListener("scroll", this.scrollRecordCat);
        }
    }
    getSubCategoriesData(subCategory, category) {
        this.fetchMoreDataForSubCat(subCategory, category);
        document.addEventListener("scroll", this.scrollRecordSubCat);

    }
    async fetchMoreDataForCat(id){
        if(this.state.getId !== id){
            this.setState({
                items: [],
                getId: id,
                skipCountWithCategory: 0,
                categoryScrollEnabled: true,
                subCategoryScrollEnabled: false,
                loading: true,
                
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
                        temp: true,
                        loading: false,
                        trackParam: false,
                        trackParamCat: false,
                        trackParamSubCat: false,
                        categoryScrollEnabled: true,
                        subCategoryScrollEnabled: false,
                        selectedCategory: id,
                        selectedSubCategory: 0,
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
                 getSubCatId: null,
                 categoryScrollEnabled: true,
                 subCategoryScrollEnabled: false,
                 trackScroll: false,
                 temp: true,
                 loading: false,
                 trackParam: false,
                 trackParamCat: false,
                 trackParamSubCat: false,
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
                 getSubCatId: subCatId,
                 getCatId: catId,
                 categoryScrollEnabled: false,
                 subCategoryScrollEnabled: true,
                 skipCountWithSubCategory: 0,
                 loading: true
             }, async () => {
                 const {data} = await axios
                 .post(BASE_URL + "shopBySubCat", {
                     subCategory: subCatId,
                     category: catId,
                     skipCountSubCat: this.state.skipCountWithSubCategory
                 });
                 //console.log(data)
                 this.setState({
                     items: [...this.state.items, ...data],
                     getSubCatId: subCatId,
                     getCatId: catId,
                     getId: null,
                     trackScroll: false,
                     trackParam: false,
                     trackParamCat: false,
                     trackParamSubCat: false,
                     temp: true,
                     loading: false,
                     categoryScrollEnabled: false,
                     subCategoryScrollEnabled: true,
                     selectedCategory: catId,
                     selectedSubCategory: subCatId,
                     skipCountWithSubCategory: this.state.skipCountWithSubCategory
                 });
                 document.getElementById("short").value = "";
                 this.forceUpdate();
             });
         }else{
                 this.setState({
                     loading: true,
                     trackParam: false,
                     trackParamCat: false,
                     trackParamSubCat: false,
                 })
                 const {data} = await axios
                 .post(BASE_URL + "shopBySubCat", {
                     subCategory: subCatId,
                     category: catId,
                     skipCountSubCat: this.state.skipCountWithSubCategory
                 });
                 //console.log(data);
                 this.setState({
                     items: [...this.state.items, ...data],
                     getSubCatId: subCatId,
                     getId: null,
                     getCatId: catId,
                     trackScroll: false,
                     temp: true,
                     loading: false,
                     categoryScrollEnabled: false,
                     subCategoryScrollEnabled: true,
                     selectedSubCategory: subCatId,
                     selectedCategory: catId,
                     skipCountWithSubCategory: this.state.skipCountWithSubCategory
                 });
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
    sortProductByParam(param) {
        if(this.state.selectedCategory == 0 && this.state.selectedSubCategory == 0){
            this.setState({
                setParam: undefined
            }, ()=> {
                this.sortMoreDataByParam(param);
                document.addEventListener("scroll", this.sortByParamScrollTrack);
            })
        }
        else if(this.state.selectedCategory != 0 && this.state.selectedSubCategory == 0){
            this.setState({
                setParamCat: undefined,
                categoryScrollEnabled: false,
                subCategoryScrollEnabled: false,
            }, ()=> {
                this.sortMoreDataByParamForCat(param);
                document.addEventListener("scroll", this.sortByParamScrollTrackForCat);
            })
        }else{
            this.setState({
                setParamSubCat: undefined,
            }, ()=> {
                this.sortMoreDataByParamForSubCat(param);
                document.addEventListener("scroll", this.sortByParamScrollTrackForSubCat);
            })
                       
        }
    }
    async sortMoreDataByParam(sortParam){
        if(this.state.setParam !== sortParam){
            this.setState({
                products: [],
                temp: false,
                loading: true,
                carSearch: false,
                subCategoryScrollEnabled: false,
                trackScroll: false,
                trackParam: true,
                trackParamCat: false,
                trackParamSubCat: false,
                sortParamSkip: 0
    
            }, async ()=>{
                const {data} = await axios
                .post(BASE_URL + "sortProductByParam", {
                    param: sortParam,
                    category: this.state.selectedCategory,
                    itemsCountPerPage: this.state.itemsCountPerPage,
                    skipCount: this.state.sortParamSkip,
                });
    
                this.setState({
                    products: [...this.state.products, ...data],
                    setParam: sortParam,
                    setParamCat: undefined,
                    setParamSubCat: undefined,
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
                    skipCount: this.state.sortParamSkip,
                });
    
                this.setState({
                    products: [...this.state.products, ...data],
                    setParam: sortParam,
                    setParamCat: undefined,
                    setParamSubCat: undefined,
                    trackParam: true,
                    trackParamCat: false,
                    trackParamSubCat: false,
                    loading: false
                })
        }
        
    }
    async sortMoreDataByParamForCat(sortParamForCat){
        if(this.state.setParamCat !== sortParamForCat){
            this.setState({
                products: [],
                temp: false,
                carSearch: false,
                subCategoryScrollEnabled: false,
                trackScroll: false,
                trackParam: false,
                trackParamCat: true,
                trackParamSubCat: false,
                sortParamSkipCat: 0,
                loading: true,            
    
            }, async ()=>{
                const {data} = await axios
                .post(BASE_URL + "sortProductByParam", {
                    param: sortParamForCat,
                    category: this.state.selectedCategory,
                    itemsCountPerPage: this.state.itemsCountPerPage,
                    skipCount: this.state.sortParamSkipCat,
                });
    
                this.setState({
                    products: [...this.state.products, ...data],
                    setParamCat: sortParamForCat,
                    setParam: undefined,
                    setParamSubCat: undefined,
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
                    skipCount: this.state.sortParamSkipCat,
                });
    
                this.setState({
                    products: [...this.state.products, ...data],
                    setParamCat: sortParamForCat,
                    setParam: undefined,
                    setParamSubCat: undefined,
                    loading: false
                })
        }
        
    }
    async sortMoreDataByParamForSubCat(sortParamForSubCat){
        if(this.state.setParamSubCat !== sortParamForSubCat){
            this.setState({
                products: [],
                temp: false,
                carSearch: false,
                subCategoryScrollEnabled: false,
                trackScroll: false,
                trackParam: false,
                trackParamCat: false,
                trackParamSubCat: true,
                sortParamSkipSubCat: 0,
                loading: true            
    
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
                    setParamSubCat: sortParamForSubCat,
                    setParam: undefined,
                    setParamCat: undefined,
                    loading: false
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
                    setParamSubCat: sortParamForSubCat,
                    loading: false,
                    setParam: undefined,
                    setParamCat: undefined,
                })
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
    
    render() {
        openSidebarParentCategory(this.state.selectedSubCategory);
        
        return (
            <div>
                <Header />

                <div className="shop_area mb-4" ref={this.container}>
                    <div className="container">
                        <div className="row">
                            <SidebarContainer
                                getCategoriesData={this.getCategoriesData}
                                getSubCategoriesData={this.getSubCategoriesData}
                                selectedCategory={this.state.selectedCategory}
                                selectedSubCategory={this.state.selectedSubCategory}
                            />
                            <ShopSearchProductContainer
                                loading = {this.state.loading}
                                products={this.state.temp ? this.state.items : this.state.products}
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
