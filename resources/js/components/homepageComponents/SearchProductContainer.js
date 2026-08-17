import React, { Component } from "react";
import CarFilter from "./CarFilter";
import ProductContainer from "./ProdcutContainer";
import AllProductContainer from "./AllProductContainer";
import { BASE_URL } from "../config/Constants";
import Loading from "../ShopComponents/Loading";
import ProductInfo from "./ProductInfo";
export default class SearchProductContainer extends Component {
    constructor() {
        super();
        this.state = {
            products: [],
            sections: [],
            companies: [],
            allProducts: [],
            count: 0,
            loading: false,
            temp: "latest",
            skip: 0,
            allProductsSkip: 0,
            trackAllProduct: false
        };

        this.searchCar = this.searchCar.bind(this);
        this.loadData = this.loadData.bind(this);
        this.getAllProducts = this.getAllProducts.bind(this);
        this.allProductScrollTrack = this.allProductScrollTrack.bind(this);
        this.container = React.createRef();
        // this.scrollHandler = this.scrollHandler.bind(this);
    }

    searchCar(requestObj) {
        axios.post(BASE_URL + "getProductsByProps", requestObj).then(res => {
            this.setState({
                products: res.data.latestProducts,
                sections: res.data.sections,

            });
            this.forceUpdate();
        });
    }
    componentDidUpdate(prevProps, prevState) {
        if (prevState.allProducts.length !== this.state.allProducts.length) {
            if(this.state.trackAllProduct){
                document.addEventListener("scroll", this.allProductScrollTrack);
            }
        }
    }
    componentWillUnmount() {
        document.removeEventListener("scroll", this.allProductScrollTrack);
    }

    componentDidMount() {
        let token = document.head.querySelector('meta[name="csrf-token"]');
        let headersData = new Headers({
            "Content-Type": "x-www-form-urlencoded",
            "X-CSRF-TOKEN": token.content,
        });
        axios.post(BASE_URL + "getCompanies", {
            headers: headersData
        }).then(response => {
            this.setState({ companies: response.data });
        });

        axios.post(BASE_URL + "latestCollection", {
            headers: headersData
        }).then(res => {
            // console.log("latest collection ", res);
            this.setState({ products: res.data });
            this.forceUpdate();
        });

        this.loadData();

        this.getAllProducts();
        document.addEventListener("scroll", this.allProductScrollTrack);

        // axios.post(BASE_URL + "dynamicSections").then(res => {
        //     this.setState({ sections: res.data });
        // });
    }

   async getAllProducts(){
       this.setState({
           loading: true
       })
        const category_id = 0;
        const skipCount = this.state.allProductsSkip;
        const { data } = await axios.post(BASE_URL + "getAllProducts", {
            category_id,
            skipCount
        });
        this.setState({
            allProducts: [...this.state.allProducts, ...data],
            trackAllProduct: true,
            loading: false
        })
    }

    allProductScrollTrack = () =>{
        if(this.state.trackAllProduct){
            if (
                this.container.current.getBoundingClientRect().bottom - 20 <=
                window.innerHeight
              ){
                  this.setState({
                    allProductsSkip: this.state.allProductsSkip + 10
                  });
                  this.getAllProducts();
                  document.removeEventListener("scroll", this.allProductScrollTrack);
              }
        }
    }

    async loadData(){
        let token = document.head.querySelector('meta[name="csrf-token"]');
        let headersData = new Headers({
            "Content-Type": "x-www-form-urlencoded",
            "X-CSRF-TOKEN": token.content,
        });
       this.setState({
           loading: true,
        });
       const { data } =  await axios.post(BASE_URL + "dynamicSections", {
           skipCount: 0,
           headers: headersData
       });
       this.setState({
           sections: data,
           loading: false,
        });

        // console.log("state data ", this.state.sections)
    }
    // scrollHandler = (data) =>{
    //     this.setState({
    //         skip: this.state.skip + data
    //     }, async ()=> {
    //         const { data } =  await axios.post(BASE_URL + "dynamicSections", {
    //             skipCount: this.state.skip
    //         });
    //     })
    // }

    render() {
        return (
            <div ref={this.container}>

                {/* Commented

                <div className="row justify-content-center">
                   <div className="col-lg-8">
                    <CarFilter
                        companies={this.state.companies}
                        searchCar={this.searchCar}
                        parentState={this.state}
                        />
                   </div>

                </div>

                </div> Comment end*/}


                <ProductContainer
                    products={this.state.products}
                    model  ={this.state.model}
                    name="Latest Collection"
                    getId={this.state.temp}
                />

                { this.state.loading ? (<Loading/>) : ""}

                {this.state.sections.map((val, k) => (
                    <ProductContainer
                        products={val.items}
                        name={val.name}
                        getId={val.id}
                        key={k}
                        setStateOfParent = {this.scrollHandler}
                    />
                ))}
                <AllProductContainer
                        products={this.state.allProducts}
                        name="All Products"
                        getId={"all"}
                        loadingStatus = {this.state.loading}
                    />
            </div>
        );
    }
}
