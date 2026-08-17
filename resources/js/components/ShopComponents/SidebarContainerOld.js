import { isUndefined } from "lodash";
import React, { Component } from "react";
import SidebarCategoriesContainer from "../ShopComponents/SidebarCategoriesContainer";
import { BASE_URL } from "../config/Constants";

export default class SidebarContainer extends Component {
    constructor(props) {
        super();
        this.state = {
            categories: [],
        };
     this.jsxData = undefined;
    
     
    }

    
    componentDidMount() {
        

        axios.post(BASE_URL + "categories").then(response => {
           
            this.setState({ categories: response.data });
         
        });

       
        
    }

    render() {


        
        this.jsxData = this.state.categories.map((val,valKey)=>{
           return  <SidebarCategoriesContainer getCategoriesData={this.props.getCategoriesData} getSubCategoriesData={this.props.getSubCategoriesData} categories ={val} key= {valKey} />

        })

       

       
           
     
        return (
            <div className="col-lg-3 col-md-12">
                <aside>
                    <div className="widget_list widget_categories">
                        <h3>Categories</h3>

                        <ul>
                           
                           {this.jsxData}
                         
                        
                        </ul>
                    </div>

                    {/* <div className="widget_list widget_filter">
                        <h3>Price</h3>
                        <form id="rangeForm">
                            <div id="slider-range"></div>
                            <button type="button" id="rangeFormBtn">
                                Filter
                            </button>
                            <input type="text" name="text" id="amount" />
                        </form>
                    </div>

                    <div className="widget_list widget_categories">
                        <h3>Brand</h3>

                        <ul>
                            <li>
                                <input
                                    id="check1"
                                    name="manufacturer_name"
                                    type="radio"
                                    value=""
                                />
                                <label></label>
                                <span className="checkmark"></span>
                            </li>
                        </ul>
                    </div> */}
                </aside>
            </div>
        );
    }
}
