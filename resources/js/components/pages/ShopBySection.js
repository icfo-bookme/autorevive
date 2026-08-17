import React, { Component } from "react";
import ReactDOM from "react-dom";
import Header from "../homepageComponents/Header";
import SidebarContainer from "../ShopComponents/SidebarContainer";
import ShopSearchProductContainer from "../ShopComponents/ShopSearchProductContainer";
import { BASE_URL } from "../config/Constants";
import ProductDetailModal from "../homepageComponents/ProductDetailModal";
import { Collapse } from "bootstrap";

class ShopBySection extends Component {
    constructor() {
        super();
        this.state = {
            products: [],
            sections: [],
            selectedSection: 0,
            initialScrollTrack: false,
            scrollTrackWithSectionId: false,
            scrollTrackWithParamSectionId: false,
            skip: 0,
            skipCountForSection: 0,
            sortParamSkip: 0,
            setParam: undefined,
            latestData: false,
            loading: false
        };
        this.sortProductByParam = this.sortProductByParam.bind(this);
        this.container = React.createRef();

    }

    componentDidMount(){
        axios.get(BASE_URL + "getAllSections").then(response => {
            this.setState({ sections: response.data });
        });
        
        this.fetchData();
        document.addEventListener("scroll", this.fetchDataMoreWithScroll);
    }
    componentDidUpdate(prevProps, prevState) {
        if (prevState.products.length !== this.state.products.length){
            if(this.state.initialScrollTrack){
                document.addEventListener("scroll", this.fetchDataMoreWithScroll);
            }else if(this.state.scrollTrackWithSectionId){
                document.addEventListener("scroll", this.fetchDataMoreByScrollWithSectionId);
            }else if(this.state.scrollTrackWithParamSectionId){
                document.addEventListener("scroll", this.fetchDataByParam);
            }
        }
    }
    componentWillUnmount() {
        document.removeEventListener("scroll", this.fetchDataMoreWithScroll);
        document.removeEventListener("scroll", this.fetchDataMoreByScrollWithSectionId);
        document.removeEventListener("scroll", this.fetchDataByParam);
    }

    sortProductByParam(sortParam) {
      this.fetchProductByParam(sortParam);
      document.addEventListener("scroll", this.fetchDataByParam);
    }
    
    getDataWithSection(id){
        if(id == "latest"){
            this.setState({
                latestData: true
            })
        }else{
            this.setState({
                latestData: false
            })
        }
       this.setState({
           products: [],
           selectedSection: id,
           initialScrollTrack: false,
           scrollTrackWithParamSectionId: false,
           scrollTrackWithSectionId: true,
           skipCountForSection: 0,
       }, async ()=> {
            this.fetchDataWithSectionId(id);
            document.addEventListener("scroll", this.fetchDataMoreByScrollWithSectionId);

       })
    }
    async fetchData(){
        if (location.href.split("/")[3] === "shopBySection") {
            let section_id = location.href.split("/")[4];
            if(section_id == "latest"){
                this.setState({
                    latestData: true,
                    loading: true
                })
            }else{
                this.setState({
                    latestData: false
                })
            }
            if (section_id != undefined) {
                this.setState({
                    loading: true
                })
                const skip_count = this.state.skip;
                const { data } = await axios.post(BASE_URL + "shopBySectionAjax", {
                    section_id,
                    skip_count
                });
                this.setState({
                    products: [...this.state.products, ...data],
                    loading: false,
                    selectedSection: section_id,
                    skip: skip_count,
                    initialScrollTrack: true,
                    scrollTrackWithSectionId: false,
                    scrollTrackWithParamSectionId: false,
                })
            }
        }
    }
    async fetchDataWithSectionId(id){
        if(this.state.selectedSection !== id){
            this.setState({
                products: [],
                selectedSection: id,
                initialScrollTrack: false,
                scrollTrackWithParamSectionId: false,
                scrollTrackWithSectionId: true,
                loading: true
            }, async ()=> {
                const skip_count = 0;
                const { data } = await axios.post(BASE_URL + "shopBySectionAjax", {
                    section_id: id,
                    skip_count
                });
                this.setState({
                    products: [...this.state.products, ...data],
                    skipCountForSection: 0,
                    loading: false
                    
                })
                
            })
        }else{
            this.setState({
                loading: true
            })
            const skip_count = this.state.skipCountForSection;
                const { data } = await axios.post(BASE_URL + "shopBySectionAjax", {
                    section_id: id,
                    skip_count
                });
                this.setState({
                    products: [...this.state.products, ...data],
                    loading: false,
                    skipCountForSection: skip_count,
                    selectedSection: id,
                    initialScrollTrack: false,
                    scrollTrackWithParamSectionId: false,
                    scrollTrackWithSectionId: true,
                })
        }
       
    }
    async fetchProductByParam(getParam){
        if(this.state.setParam !== getParam){
            this.setState({
              products: [],
              initialScrollTrack: false,
              scrollTrackWithSectionId: false,
              scrollTrackWithParamSectionId: true,
              sortParamSkip: 0,
              loading: true
            }, async ()=> {
                const {data} = await axios
                .post(BASE_URL + "sortProductBySectionWithParam", {
                    param: getParam,
                    section_id: this.state.selectedSection,
                    skipCount: this.state.sortParamSkip,
                });
                this.setState({
                    products: [...this.state.products, ...data],
                    setParam: getParam,
                    loading: false

                })
            })
        }else{
            this.setState({
                loading: true
            })
            const {data} = await axios
                .post(BASE_URL + "sortProductBySectionWithParam", {
                    param: getParam,
                    section_id: this.state.selectedSection,
                    skipCount: this.state.sortParamSkip,
                });
            this.setState({
                products: [...this.state.products, ...data],
                loading: false,
                setParam: getParam,
                scrollTrackWithParamSectionId: true,
                initialScrollTrack: false,
                scrollTrackWithSectionId: false,
            })
        }
        
    }
    fetchDataMoreWithScroll = () => { 
          if(this.state.initialScrollTrack){
           if (
               this.container.current.getBoundingClientRect().bottom <=
               window.innerHeight
             ) {
               this.setState({
                   skip: this.state.skip + 8
               }, () => {
                   this.fetchData(this.state.selectedSection);
               })
               document.removeEventListener("scroll", this.fetchDataMoreWithScroll);
             }
          }
    };
    fetchDataMoreByScrollWithSectionId = () => { 
        if(this.state.scrollTrackWithSectionId){
         if (
             this.container.current.getBoundingClientRect().bottom <=
             window.innerHeight
           ) {
             this.setState({
                 skipCountForSection: this.state.skipCountForSection + 8
             })
             this.fetchDataWithSectionId(this.state.selectedSection);
             document.removeEventListener("scroll", this.fetchDataMoreByScrollWithSectionId);
           }
        }
    };
    fetchDataByParam = () => {
        if(this.state.scrollTrackWithParamSectionId){
            if (
                this.container.current.getBoundingClientRect().bottom <=
                window.innerHeight
              ) {
                this.setState({
                    sortParamSkip: this.state.sortParamSkip + 8
                })
                this.fetchProductByParam(this.state.setParam);
                document.removeEventListener("scroll", this.fetchDataByParam);
              }
           }
    }
    
    render() {
        return (
            <div>
                <Header />
                <div className="shop_area mb-4">
                    <div className="container">
                        <div className="row" ref={this.container}>
                        <div className="col-lg-3 col-md-12">
                            <aside className="sidebar_widget">
                                <div className="widget_list widget_categories">
                                    <h3>Sections</h3>
                                    <ul>
                                        <li><a href={BASE_URL+ "shopview"}>All Products</a></li>
                                        <li onClick={()=>this.getDataWithSection("latest")} className={ this.state.latestData ? `selectedBg px-2`: ''}><a>Latest Products</a></li>
                                        {
                                            this.state.sections.map((val, k) =>(
                                            <li key={"section_" + val.id} className={val.id == this.state.selectedSection ? `selectedBg px-2`: ''} 
                                                onClick = {()=> this.getDataWithSection(val.id)}>
                                                    <a>{val.name}</a>
                                            </li>
                                            ))
                                        }
                                    </ul>
                                    
                                </div>
                            </aside>
                        </div>
                            <ShopSearchProductContainer
                                    products={this.state.products}
                                    loading = {this.state.loading}
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

if (document.getElementById("shopbySectionApp")) {
    ReactDOM.render(<ShopBySection />, document.getElementById("shopbySectionApp"));
}
